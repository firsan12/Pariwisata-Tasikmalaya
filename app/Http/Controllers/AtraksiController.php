<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atraksi;
use App\Models\Destinasi;




class AtraksiController extends Controller
{
    public function index()
{
    $atraksiList = Atraksi::latest()->get();
    return view('atraksi', compact('atraksiList'));
}
 
public function create()
{
    $destinasiList = Destinasi::all();
    return view('atraksi-create', compact('destinasiList'));
}
 
public function store(Request $request)
{
    $validated = $request->validate([
         'destinasi_id' => 'required|exists:destinasi,id',
        'nama' => 'required|min:3',
        'deskripsi' => 'required',
        'kategori' => 'required',
        'harga' => 'required|numeric|min:0',
        'gambar' => 'required|image|max:2048',
        'jam_operasional' => 'nullable|string|max:255',
    ]);

    // FIX: sebelumnya file gambar tidak pernah benar-benar diupload ke
    // storage -> $validated['gambar'] berisi objek/nilai mentah dari
    // request, bukan path file yang tersimpan, sehingga gambar tidak
    // pernah muncul. Sekarang file disimpan ke storage/app/public/atraksi
    // dan path hasil penyimpanannya yang dipakai.
    $validated['gambar'] = $request->file('gambar')->store('atraksi', 'public');

    Atraksi::create($validated);
 
    return redirect()->route('atraksi')
        ->with('success', 'Atraksi berhasil ditambahkan!');
}
 
public function edit($id)
{
    $atraksi = Atraksi::findOrFail($id);
    $destinasiList = Destinasi::all();
    return view('atraksi-edit', compact('atraksi', 'destinasiList'));
}
 
public function update(Request $request, $id)
{
    $atraksi = Atraksi::findOrFail($id);
 
    $validated = $request->validate([
        'destinasi_id' => 'required|exists:destinasi,id',
        'nama' => 'required|min:3',
        'deskripsi' => 'required',
        'kategori' => 'required',
        'harga' => 'required|numeric|min:0',
        'gambar' => 'nullable|image|max:2048',
        'jam_operasional' => 'nullable|string|max:255',
    ]);

    // FIX: sama seperti store() — kalau ada file baru diupload, simpan ke
    // storage dan pakai path-nya. Kalau tidak ada file baru (user tidak
    // ganti gambar saat edit), jangan timpa kolom 'gambar' yang sudah ada.
    if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request->file('gambar')->store('atraksi', 'public');
    } else {
        unset($validated['gambar']);
    }

    $atraksi->update($validated);
 
    return redirect()->route('atraksi')
        ->with('success', 'Atraksi berhasil diperbarui!');
}
 
public function destroy($id)
{
    $atraksi = Atraksi::findOrFail($id);
    $atraksi->delete();
    return redirect()->route('atraksi')
        ->with('success', 'Atraksi berhasil dihapus!');
}

}