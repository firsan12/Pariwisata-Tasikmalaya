<?php

namespace App\Http\Controllers;

use App\Models\Kuliner;
use Illuminate\Http\Request;

class KulinerController extends Controller
{
    public function index()
    {
        $kuliners = Kuliner::latest()->paginate(12);
        return view('kuliner.index', compact('kuliners'));
    }

    public function create()
    {
        return view('kuliner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'alamat'      => 'nullable|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'harga_mulai' => 'nullable|numeric',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kuliner', 'public');
        }

        Kuliner::create($validated);

        return redirect()->route('kuliner')->with('success', 'Kuliner berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kuliner = Kuliner::findOrFail($id);
        return view('kuliner.edit', compact('kuliner'));
    }

    public function update(Request $request, $id)
    {
        $kuliner = Kuliner::findOrFail($id);

        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'alamat'      => 'nullable|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'harga_mulai' => 'nullable|numeric',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kuliner', 'public');
        }

        $kuliner->update($validated);

        return redirect()->route('kuliner')->with('success', 'Kuliner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kuliner::findOrFail($id)->delete();
        return redirect()->route('kuliner')->with('success', 'Kuliner berhasil dihapus.');
    }
}