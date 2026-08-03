<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    // Batas waktu pembayaran (menit) sebelum booking dianggap kedaluwarsa
    protected int $batasWaktuMenit = 60;

    public function show(string $kodeBooking)
    {
        $booking = Booking::with('destinasi')
            ->where('kode_booking', $kodeBooking)
            ->firstOrFail();

        // Jika sudah lewat batas waktu dan masih pending -> otomatis batalkan & kembalikan kuota
        if ($booking->status === 'pending' && $this->sudahKedaluwarsa($booking)) {
            $this->batalkanDanKembalikanKuota($booking);
            $booking->refresh();
        }

        $batasWaktu = $booking->created_at->addMinutes($this->batasWaktuMenit);

        return view('pembayaran.show', compact('booking', 'batasWaktu'));
    }

    public function confirm(Request $request, string $kodeBooking)
    {
        $booking = Booking::where('kode_booking', $kodeBooking)->firstOrFail();

        if ($booking->status === 'confirmed') {
            return redirect()
                ->route('pembayaran', $booking->kode_booking)
                ->with('info', 'Pembayaran untuk booking ini sudah dikonfirmasi sebelumnya.');
        }

        if ($booking->status === 'cancelled') {
            return redirect()
                ->route('pembayaran', $booking->kode_booking)
                ->withErrors(['status' => 'Booking ini sudah dibatalkan/kedaluwarsa. Silakan lakukan pemesanan ulang.']);
        }

        if ($this->sudahKedaluwarsa($booking)) {
            $this->batalkanDanKembalikanKuota($booking);

            return redirect()
                ->route('pembayaran', $booking->kode_booking)
                ->withErrors(['status' => 'Batas waktu pembayaran sudah habis. Booking dibatalkan otomatis.']);
        }

        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|in:transfer_bank,qris,ewallet',
            'bukti_pembayaran'  => 'nullable|image|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
        }

        $booking->update([
            'status'             => 'confirmed',
            'metode_pembayaran'  => $validated['metode_pembayaran'],
            'bukti_pembayaran'   => $buktiPath,
            'dibayar_at'         => now(),
        ]);

        return redirect()
            ->route('pembayaran', $booking->kode_booking)
            ->with('success', 'Pembayaran berhasil dikonfirmasi. Terima kasih!');
    }

    protected function sudahKedaluwarsa(Booking $booking): bool
    {
        return $booking->status === 'pending'
            && $booking->created_at->addMinutes($this->batasWaktuMenit)->isPast();
    }

    protected function batalkanDanKembalikanKuota(Booking $booking): void
    {
        DB::transaction(function () use ($booking) {
            $destinasi = $booking->destinasi()->lockForUpdate()->first();

            $destinasi->decrement('terisi_dewasa', $booking->jumlah_dewasa);
            $destinasi->decrement('terisi_anak', $booking->jumlah_anak);
            $destinasi->decrement('terisi_asing', $booking->jumlah_asing);

            $booking->update(['status' => 'cancelled']);
        });
    }
}