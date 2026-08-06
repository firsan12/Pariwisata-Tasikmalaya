<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Simpan ulasan baru untuk sebuah destinasi.
     * Dipanggil via AJAX dari form di partial 'partials.ulasan-section'.
     */
    public function store(Request $request, Destinasi $destinasi)
    {
        $validated = $request->validate([
            'rating'         => 'required|integer|min:1|max:5',
            'nama_pengguna'  => 'required|string|max:100',
            'email_pengguna' => 'nullable|email|max:150',
            'komentar'       => 'required|string|min:10|max:1000',
        ]);

        $validated['destinasi_id'] = $destinasi->id;

        Ulasan::create($validated);

        $message = 'Terima kasih! Ulasan kamu akan tampil setelah disetujui pengelola.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message], 201);
        }

        return back()->with('ulasan_success', $message);
    }

    /**
     * Hapus ulasan (dipakai di panel admin, kalau ada).
     */
    public function destroy(Ulasan $ulasan): RedirectResponse
    {
        $destinasiId = $ulasan->destinasi_id;
        $ulasan->delete();

        return redirect()
            ->route('destinasi.detail', $destinasiId)
            ->with('success', 'Ulasan berhasil dihapus.');
    }

    /**
     * Admin: setujui ulasan yang berstatus pending.
     */
    public function approve(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->update(['status' => 'approved']);

        return back()->with('success', 'Ulasan disetujui dan tampil di halaman destinasi.');
    }

    /**
     * Admin: balas ulasan pengunjung.
     */
    public function balas(Request $request, Ulasan $ulasan): RedirectResponse
    {
        $request->validate([
            'balasan_admin' => ['required', 'string', 'max:1000'],
        ]);

        $ulasan->update([
            'balasan_admin' => $request->balasan_admin,
            'dibalas_pada'  => now(),
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}