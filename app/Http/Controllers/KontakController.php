<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PesanKontak;
 
class KontakController extends Controller
{
    public function index()
    {
        return view('kontak');
    }
 
    public function send(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string|max:2000',
        ]);
 
        Mail::to('firmanihsan18@gmail.com')
            ->send(new PesanKontak($request->nama, $request->email, $request->pesan));
 
        return back()->with('success', 'Pesan berhasil dikirim, terima kasih!');
    }
}