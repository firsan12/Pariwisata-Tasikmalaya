<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Models\Atraksi;
use App\Models\User;
use App\Models\Ulasan;
use App\Models\Penginapan;

class AdminController extends Controller
{
    /**
     * Route menuju method ini sudah dilindungi middleware ['auth', 'admin']
     * di routes/web.php, jadi tidak perlu pengecekan role lagi di sini.
     */
    public function dashboard()
    {
        // Belum ada kolom status/is_aktif di tabel destinasi,
        // jadi untuk sekarang semua destinasi dianggap aktif.
        $totalDestinasi = Destinasi::count();

        $data = [
            'totalDestinasi'   => $totalDestinasi,
            'destinasiAktif'   => $totalDestinasi,
            'totalAtraksi'     => Atraksi::count(),
            'totalUser'        => User::count(),
            'totalPenginapan'  => Penginapan::count(),
            'totalUlasan'      => Ulasan::count(),
            'ulasanPending'    => Ulasan::where('status', 'pending')->count(),

            // Destinasi populer = 3 destinasi dengan rating rata-rata
            // tertinggi (dihitung dari ulasan yang sudah di-approve).
            'destinasiPopuler' => Destinasi::with('ulasan')
                ->get()
                ->sortByDesc(fn ($d) => $d->rating_rata_rata)
                ->take(3)
                ->values(),
        ];

        return view('admin.dashboard', $data);
    }
}