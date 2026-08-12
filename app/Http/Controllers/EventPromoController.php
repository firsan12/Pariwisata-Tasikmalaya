<?php

namespace App\Http\Controllers;

use App\Models\EventPromo;
use Illuminate\Http\Request;

class EventPromoController extends Controller
{
    public function index()
    {
        $eventList = EventPromo::orderBy('urutan')->get();
        return view('event-admin', compact('eventList'));
    }

    public function create()
    {
        return view('event-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'promo'            => 'required|string|max:100',
            'deskripsi'        => 'nullable|string',
            'gambar'           => 'nullable|image|max:2048',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'urutan'           => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('events', 'public');
        }

        EventPromo::create($validated);

        return redirect()->route('event.admin')->with('success', 'Event berhasil ditambahkan!');
    }

    public function show($id)
    {
        $event = EventPromo::findOrFail($id);
        return view('event-detail', compact('event'));
    }

    public function edit($id)
    {
        $event = EventPromo::findOrFail($id);
        return view('event-edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = EventPromo::findOrFail($id);

        $validated = $request->validate([
            'judul'            => 'required|string|max:255',
            'promo'            => 'required|string|max:100',
            'deskripsi'        => 'nullable|string',
            'gambar'           => 'nullable|image|max:2048',
            'tanggal_mulai'    => 'nullable|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'urutan'           => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('events', 'public');
        } else {
            unset($validated['gambar']);
        }

        $event->update($validated);

        return redirect()->route('event.admin')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = EventPromo::findOrFail($id);
        $event->delete();

        return redirect()->route('event.admin')->with('success', 'Event berhasil dihapus!');
    }
}