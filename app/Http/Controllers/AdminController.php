<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Models\Atraksi;
use App\Models\User;
use App\Models\Ulasan;

class AdminController extends Controller
{
    /**
     * Route menuju method ini sudah dilindungi middleware ['auth', 'admin']
     * di routes/web.php, jadi tidak perlu pengecekan role lagi di sini.
     * (Sebelumnya ada sisa kode middleware yang nyangkut/rusak di dalam
     * method ini — sudah dibersihkan.)
     */
    public function dashboard()
    {
        $data = [
            'totalDestinasi' => Destinasi::count(),
            'totalAtraksi'   => Atraksi::count(),
            'totalUser'      => User::count(),
            'totalUlasan'    => Ulasan::count(),
        ];

        return view('admin.dashboard', $data);
    }
}