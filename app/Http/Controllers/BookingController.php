<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class BookingController extends Controller
{
    // Batas waktu pembayaran (menit) sebelum booking pending dianggap kedaluwarsa.
    // Nilai ini juga dipakai command booking:batalkan-kedaluwarsa (--menit=60) di Kernel.php —
    // kalau diubah, pastikan diubah juga di sana supaya konsisten.
    protected int $batasWaktuMenit = 60;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destinasi_id'       => 'required|exists:destinasi,id',
            'nama_pemesan'       => 'required|string|max:255',
            'email_pemesan'      => 'required|email|max:255',
            'wa_pemesan'         => ['required', 'regex:/^[0-9+\- ]{9,15}$/'],
            'tanggal_kunjungan'  => 'required|date|after_or_equal:today',
            'jumlah_dewasa'      => 'required|integer|min:0',
            'jumlah_anak'        => 'required|integer|min:0',
            'jumlah_asing'       => 'required|integer|min:0',
            'metode_pembayaran'  => 'required|in:qris,transfer_bank,ewallet',
            'bank_kode'          => 'required_if:metode_pembayaran,transfer_bank|nullable|in:bca,bri,mandiri,bni,seabank',
            'ewallet_kode'       => 'required_if:metode_pembayaran,ewallet|nullable|in:gopay,ovo,dana,shopeepay',
        ]);

        $totalTiket = $validated['jumlah_dewasa'] + $validated['jumlah_anak'] + $validated['jumlah_asing'];

        if ($totalTiket <= 0) {
            return back()->withErrors(['jumlah_dewasa' => 'Pilih minimal 1 tiket.'])->withInput();
        }

        try {
            $booking = DB::transaction(function () use ($validated) {
                // Lock row destinasi supaya aman dari race condition saat kuota hampir habis
                $destinasi = Destinasi::where('id', $validated['destinasi_id'])->lockForUpdate()->first();

                if ($destinasi->terisi_dewasa + $validated['jumlah_dewasa'] > $destinasi->kuota_dewasa) {
                    throw new \Exception('Kuota tiket dewasa tidak mencukupi. Sisa: ' . $destinasi->sisa_dewasa);
                }
                if ($destinasi->terisi_anak + $validated['jumlah_anak'] > $destinasi->kuota_anak) {
                    throw new \Exception('Kuota tiket anak tidak mencukupi. Sisa: ' . $destinasi->sisa_anak);
                }
                if ($destinasi->terisi_asing + $validated['jumlah_asing'] > $destinasi->kuota_asing) {
                    throw new \Exception('Kuota tiket wisatawan asing tidak mencukupi. Sisa: ' . $destinasi->sisa_asing);
                }

                $subDewasa = $validated['jumlah_dewasa'] * $destinasi->harga_dewasa;
                $subAnak   = $validated['jumlah_anak'] * $destinasi->harga_anak;
                $subAsing  = $validated['jumlah_asing'] * $destinasi->harga_asing;
                $total     = $subDewasa + $subAnak + $subAsing;
                $kodeUnik  = random_int(100, 999);

                $booking = Booking::create([
                    'kode_booking'      => Booking::generateKodeBooking(),
                    'destinasi_id'      => $destinasi->id,
                    'nama_pemesan'      => $validated['nama_pemesan'],
                    'email_pemesan'     => $validated['email_pemesan'],
                    'wa_pemesan'        => $validated['wa_pemesan'],
                    'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
                    'jumlah_dewasa'     => $validated['jumlah_dewasa'],
                    'jumlah_anak'       => $validated['jumlah_anak'],
                    'jumlah_asing'      => $validated['jumlah_asing'],
                    'subtotal_dewasa'   => $subDewasa,
                    'subtotal_anak'     => $subAnak,
                    'subtotal_asing'    => $subAsing,
                    'total_harga'       => $total,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'bank_kode'         => $validated['bank_kode'] ?? null,
                    'ewallet_kode'      => $validated['ewallet_kode'] ?? null,
                    'kode_unik'         => $kodeUnik,
                    'total_transfer'    => $total + $kodeUnik,
                    // status default tetap 'pending' — booking dibuat, belum ada indikasi bayar
                    'status'            => 'pending',
                ]);

                $destinasi->increment('terisi_dewasa', $validated['jumlah_dewasa']);
                $destinasi->increment('terisi_anak', $validated['jumlah_anak']);
                $destinasi->increment('terisi_asing', $validated['jumlah_asing']);

                return $booking;
            });
        } catch (\Exception $e) {
            return back()->withErrors(['jumlah_dewasa' => $e->getMessage()])->withInput();
        }

        return redirect()->route('pembayaran.show', $booking->kode_booking);
    }

    public function show(string $kodeBooking)
    {
        $booking = Booking::with('destinasi')->where('kode_booking', $kodeBooking)->firstOrFail();

        // Auto-cancel kalau sudah lewat batas waktu dan belum ada klaim/pembayaran
        if ($booking->sudahKedaluwarsa($this->batasWaktuMenit)) {
            $booking->batalkanDanKembalikanKuota();
            $booking->refresh();
        }

        $batasWaktu = $booking->created_at->addMinutes($this->batasWaktuMenit);

        return view('pembayaran', compact('booking', 'batasWaktu'));
    }

    /**
     * PUBLIC — user klaim "saya sudah transfer".
     * TIDAK langsung mengubah status jadi 'lunas'. Hanya menandai bahwa
     * user mengklaim sudah membayar, sehingga masuk antrean verifikasi admin.
     * Ini satu-satunya jalur klaim — jangan buat endpoint serupa di controller lain.
     * Konfirmasi 'lunas' yang sebenarnya HANYA terjadi lewat
     * AdminPaymentVerificationController::approve() (butuh login admin).
     */
    public function claimPaid(Request $request, string $kodeBooking)
    {
        // Batasi percobaan per IP + kode booking, cegah spam/brute-force
        $key = 'claim-paid:' . $request->ip() . ':' . $kodeBooking;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['status' => 'Terlalu banyak percobaan, coba lagi beberapa saat lagi.']);
        }
        RateLimiter::hit($key, 300);

        $booking = Booking::where('kode_booking', $kodeBooking)->firstOrFail();

        // Cek expiry dulu sebelum terima klaim — jangan sampai booking basi bisa diklaim
        if ($booking->sudahKedaluwarsa($this->batasWaktuMenit)) {
            $booking->batalkanDanKembalikanKuota();

            return redirect()->route('pembayaran.show', $booking->kode_booking)
                ->withErrors(['status' => 'Batas waktu pembayaran sudah habis. Booking dibatalkan otomatis.']);
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('pembayaran.show', $booking->kode_booking);
        }

        $validated = $request->validate([
            // opsional: minta bukti transfer untuk mempercepat & memperkuat verifikasi manual
            'bukti_transfer' => 'nullable|image|max:4096',
        ]);

        $path = null;
        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti-transfer', 'private');
        }

        $booking->update([
            'status'              => 'menunggu_verifikasi',
            'bukti_transfer_path' => $path,
            'klaim_bayar_at'      => now(),
        ]);

        Log::info('Booking claimed as paid by user', [
            'kode_booking' => $booking->kode_booking,
            'ip'           => $request->ip(),
        ]);

        return redirect()->route('pembayaran.show', $booking->kode_booking)
            ->with('info', 'Terima kasih, klaim pembayaran Anda sedang diverifikasi oleh admin.');
    }

    public function create(Request $request)
{
    $destinasiId = $request->query('d');
    $destinasi = $destinasiId ? Destinasi::find($destinasiId) : null;

    return view('pesan-tiket', compact('destinasi'));
}
}