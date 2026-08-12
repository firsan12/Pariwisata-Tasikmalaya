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

    public function katalog(Request $request)
    {
        $query = Kuliner::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->q.'%')
                  ->orWhere('deskripsi', 'like', '%'.$request->q.'%')
                  ->orWhere('alamat', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        switch ($request->get('sort', 'nama')) {
            case 'harga':
                $query->orderBy('harga_mulai', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga_mulai', 'desc');
                break;
            case 'nama_desc':
                $query->orderBy('nama', 'desc');
                break;
            default:
                $query->orderBy('nama', 'asc');
        }

        $kuliners = $query->paginate(12)->withQueryString();
        $kategoris = Kuliner::whereNotNull('kategori')->distinct()->pluck('kategori');

        return view('kuliner.katalog', compact('kuliners', 'kategoris'));
    }

   public function show(Kuliner $kuliner)
{
    $rekomendasi = Kuliner::where('id', '!=', $kuliner->id)
        ->when($kuliner->kategori, function ($query) use ($kuliner) {
            $query->where('kategori', $kuliner->kategori);
        })
        ->inRandomOrder()
        ->limit(4)
        ->get();

    return view('kuliner.detail', compact('kuliner', 'rekomendasi'));
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
            'kategori'    => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kuliner', 'public');
        }

        Kuliner::create($validated);

        return redirect()->route('kuliner')->with('success', 'Kuliner berhasil ditambahkan.');
    }

    public function edit(Kuliner $kuliner)
    {
        return view('kuliner.edit', compact('kuliner'));
    }

    public function update(Request $request, Kuliner $kuliner)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'alamat'      => 'nullable|string|max:255',
            'foto'        => 'nullable|image|max:2048',
            'harga_mulai' => 'nullable|numeric',
            'kategori'    => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kuliner', 'public');
        }

        $kuliner->update($validated);

        return redirect()->route('kuliner')->with('success', 'Kuliner berhasil diperbarui.');
    }

    public function destroy(Kuliner $kuliner)
    {
        $kuliner->delete();
        return redirect()->route('kuliner')->with('success', 'Kuliner berhasil dihapus.');
    }
}