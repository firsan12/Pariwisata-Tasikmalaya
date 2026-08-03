<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destinasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesanTiketController extends Controller
{
    /**
     * Tampilkan form pesan tiket.
     * Bisa diakses langsung (/pesan-tiket) atau dengan query ?destinasi=ID
     * untuk pre-select destinasi dari halaman detail.
     */
    public function create(Request $request)
    {
        $destinasiList = Destinasi::orderBy('nama')->get();

        $selectedDestinasiId = $request->query('destinasi');

        return view('pesan-tiket.create', compact('destinasiList', 'selectedDestinasiId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destinasi_id'      => 'required|exists:destinasi,id',
            'nama_pemesan'      => 'required|string|max:255',
            'email_pemesan'     => 'nullable|email|max:255',
            'telepon_pemesan'   => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jumlah_dewasa'     => 'required|integer|min:0',
            'jumlah_anak'       => 'required|integer|min:0',
            'jumlah_asing'      => 'required|integer|min:0',
        ]);

        if (
            $validated['jumlah_dewasa'] == 0 &&
            $validated['jumlah_anak'] == 0 &&
            $validated['jumlah_asing'] == 0
        ) {
            return back()
                ->withErrors(['jumlah_dewasa' => 'Minimal harus memesan 1 tiket.'])
                ->withInput();
        }

        try {
            $booking = DB::transaction(function () use ($validated) {
                // Lock row destinasi supaya aman dari race condition
                $destinasi = Destinasi::where('id', $validated['destinasi_id'])
                    ->lockForUpdate()
                    ->first();

                if ($destinasi->terisi_dewasa + $validated['jumlah_dewasa'] > $destinasi->kuota_dewasa) {
                    throw new \Exception('Kuota tiket dewasa tidak mencukupi. Sisa kuota: ' . $destinasi->sisa_dewasa);
                }
                if ($destinasi->terisi_anak + $validated['jumlah_anak'] > $destinasi->kuota_anak) {
                    throw new \Exception('Kuota tiket anak tidak mencukupi. Sisa kuota: ' . $destinasi->sisa_anak);
                }
                if ($destinasi->terisi_asing + $validated['jumlah_asing'] > $destinasi->kuota_asing) {
                    throw new \Exception('Kuota tiket wisatawan asing tidak mencukupi. Sisa kuota: ' . $destinasi->sisa_asing);
                }

                $totalHarga = ($validated['jumlah_dewasa'] * $destinasi->harga_dewasa)
                    + ($validated['jumlah_anak'] * $destinasi->harga_anak)
                    + ($validated['jumlah_asing'] * $destinasi->harga_asing);

                $booking = Booking::create([
                    'kode_booking'      => Booking::generateKodeBooking(),
                    'destinasi_id'      => $destinasi->id,
                    'user_id'           => auth()->id(),
                    'nama_pemesan'      => $validated['nama_pemesan'],
                    'email_pemesan'     => $validated['email_pemesan'] ?? null,
                    'telepon_pemesan'   => $validated['telepon_pemesan'],
                    'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
                    'jumlah_dewasa'     => $validated['jumlah_dewasa'],
                    'jumlah_anak'       => $validated['jumlah_anak'],
                    'jumlah_asing'      => $validated['jumlah_asing'],
                    'total_harga'       => $totalHarga,
                    'status'            => 'pending', // menunggu pembayaran
                ]);

                // Kuota langsung dikunci saat booking dibuat (status pending),
                // supaya slot tidak diambil orang lain saat menunggu pembayaran.
                $destinasi->increment('terisi_dewasa', $validated['jumlah_dewasa']);
                $destinasi->increment('terisi_anak', $validated['jumlah_anak']);
                $destinasi->increment('terisi_asing', $validated['jumlah_asing']);

                return $booking;
            });
        } catch (\Exception $e) {
            return back()
                ->withErrors(['jumlah_dewasa' => $e->getMessage()])
                ->withInput();
        }

        return redirect()
            ->route('pembayaran', $booking->kode_booking)
            ->with('success', 'Tiket berhasil dipesan. Silakan lanjutkan pembayaran.');
    }
}