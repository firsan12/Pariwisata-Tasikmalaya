<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Destinasi;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->paginate(12);
        return view('galeri.index', compact('galeris'));
    }

    public function create()
    {
        $destinasis = Destinasi::all();
        return view('galeri.create', compact('destinasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destinasi_id' => 'nullable|exists:destinasis,id',
            'judul'        => 'required|string|max:255',
            'foto'         => 'required|image|max:2048',
            'keterangan'   => 'nullable|string',
        ]);

        $validated['foto'] = $request->file('foto')->store('galeri', 'public');

        Galeri::create($validated);

        return redirect()->route('galeri')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $destinasis = Destinasi::all();
        return view('galeri.edit', compact('galeri', 'destinasis'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $validated = $request->validate([
            'destinasi_id' => 'nullable|exists:destinasis,id',
            'judul'        => 'required|string|max:255',
            'foto'         => 'nullable|image|max:2048',
            'keterangan'   => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($validated);

        return redirect()->route('galeri')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Galeri::findOrFail($id)->delete();
        return redirect()->route('galeri')->with('success', 'Foto berhasil dihapus.');
    }
}