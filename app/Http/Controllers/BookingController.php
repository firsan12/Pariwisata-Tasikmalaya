<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
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
        return view('pembayaran', compact('booking'));
    }

    public function confirm(string $kodeBooking)
    {
        $booking = Booking::where('kode_booking', $kodeBooking)->firstOrFail();

        if ($booking->status === 'pending') {
            $booking->update([
                'status'     => 'lunas',
                'dibayar_at' => now(),
            ]);
        }

        return redirect()->route('pembayaran.show', $booking->kode_booking);
    }
}