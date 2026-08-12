<?php

namespace App\Http\Controllers;

use App\Models\ProfilSitus;

class KontakController extends Controller
{
    public function index()
    {
        $profilSitus = ProfilSitus::current();

        return view('kontak', compact('profilSitus'));
    }
}
