<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Models\Atraksi;
use App\Models\User;
use App\Models\Ulasan;


class AdminController extends Controller
{
 
public function dashboard()
{
    $data = [
        'totalDestinasi' => Destinasi::count(),
        'totalAtraksi' => Atraksi::count(),
        'totalUser' => User::count(),
        'totalUlasan' => Ulasan::count(),
    ];
 
    return view('admin.dashboard', $data);
   
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }

    return redirect('/')->with('error', 'Akses khusus admin.');
}
}

}
