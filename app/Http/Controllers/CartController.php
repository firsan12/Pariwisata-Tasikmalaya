<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;

/*
    Keranjang disimpan di session (key "keranjang"), TIDAK di database — jadi
    tidak butuh migrasi tambahan dan otomatis per-pengunjung (termasuk yang
    belum login). Bentuknya:

        [ destinasi_id => ['dewasa' => 0, 'anak' => 0, 'asing' => 0], ... ]

    Kuantitas di sini hanya nilai AWAL (0) — jumlah tiket sesungguhnya diatur
    lewat stepper di halaman Pesan Tiket dan dikirim sebagai field form
    terpisah per destinasi saat checkout (lihat BookingController::store()).
*/
class CartController extends Controller
{
    /**
     * Tambahkan destinasi ke keranjang. Dipanggil dari tombol "+ Keranjang".
     * Item yang sudah ada di keranjang TIDAK dihapus — supaya beberapa
     * destinasi bisa dikumpulkan lalu dibayar sekaligus dalam satu checkout.
     */
    public function tambah(string $destinasiId)
    {
        $destinasi = Destinasi::findOrFail($destinasiId);

        $keranjang = session('keranjang', []);
        if (!isset($keranjang[$destinasi->id])) {
            $keranjang[$destinasi->id] = ['dewasa' => 0, 'anak' => 0, 'asing' => 0];
            session(['keranjang' => $keranjang]);
        }

        return redirect()->route('pesan-tiket')
            ->with('info', $destinasi->nama . ' ditambahkan ke keranjang.');
    }

    /**
     * Hapus satu destinasi dari keranjang.
     */
    public function hapus(string $destinasiId)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$destinasiId]);
        session(['keranjang' => $keranjang]);

        return redirect()->route('pesan-tiket')
            ->with('info', 'Item dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh keranjang.
     */
    public function kosongkan()
    {
        session()->forget('keranjang');

        return redirect()->route('pesan-tiket');
    }
}