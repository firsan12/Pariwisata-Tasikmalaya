<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atraksi;


class AtraksiController extends Controller
{
    public function index()
{
    $atraksiList = Atraksi::latest()->get();
    return view('atraksi', compact('atraksiList'));
}
 
public function create()
{
    return view('atraksi-create');
}
 
public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|min:3',
        'deskripsi' => 'required',
        'kategori' => 'required',
        'harga' => 'required|numeric|min:0',
        'gambar' => 'required',
        'jam_operasional' => 'nullable|string|max:255',
    ]);
 
    Atraksi::create($validated);
 
    return redirect()->route('atraksi')
        ->with('success', 'Atraksi berhasil ditambahkan!');
}
 
public function edit($id)
{
    $atraksi = Atraksi::findOrFail($id);
    return view('atraksi-edit', compact('atraksi'));
}
 
public function update(Request $request, $id)
{
    $atraksi = Atraksi::findOrFail($id);
 
    $validated = $request->validate([
        'nama' => 'required|min:3',
        'deskripsi' => 'required',
        'kategori' => 'required',
        'harga' => 'required|numeric|min:0',
        'gambar' => 'required',
        'jam_operasional' => 'nullable|string|max:255',
    ]);
 
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