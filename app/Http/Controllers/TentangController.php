<?php

namespace App\Http\Controllers;

use App\Models\Statistik;
use App\Models\VisiMisi;
use App\Models\ProfilSitus;

class TentangController extends Controller
{
    public function index()
    {
        $statistik   = Statistik::orderBy('urutan')->get();
        $visi_misi   = VisiMisi::orderBy('urutan')->get();
        $profilSitus = ProfilSitus::current();

        return view('tentang', compact('statistik', 'visi_misi', 'profilSitus'));
    }
}
