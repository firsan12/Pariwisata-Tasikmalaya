<?php

namespace App\Http\Controllers;

use App\Models\Penginapan;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function index()
    {
        $penginapans = Penginapan::latest()->paginate(12);
        return view('penginapan.index', compact('penginapans'));
    }

    public function create()
    {
        return view('penginapan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'alamat'          => 'nullable|string|max:255',
            'foto'            => 'nullable|image|max:2048',
            'harga_per_malam' => 'nullable|numeric',
            'rating'          => 'nullable|integer|min:1|max:5',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('penginapan', 'public');
        }

        Penginapan::create($validated);

        return redirect()->route('penginapan')->with('success', 'Penginapan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penginapan = Penginapan::findOrFail($id);
        return view('penginapan.edit', compact('penginapan'));
    }

    public function update(Request $request, $id)
    {
        $penginapan = Penginapan::findOrFail($id);

        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'alamat'          => 'nullable|string|max:255',
            'foto'            => 'nullable|image|max:2048',
            'harga_per_malam' => 'nullable|numeric',
            'rating'          => 'nullable|integer|min:1|max:5',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('penginapan', 'public');
        }

        $penginapan->update($validated);

        return redirect()->route('penginapan')->with('success', 'Penginapan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Penginapan::findOrFail($id)->delete();
        return redirect()->route('penginapan')->with('success', 'Penginapan berhasil dihapus.');
    }
}