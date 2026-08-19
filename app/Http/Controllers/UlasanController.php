<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Ulasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Admin: daftar semua ulasan, bisa difilter per status
     * (?status=pending|approved|ditolak). Dipakai oleh halaman
     * 'Kelola Ulasan' di panel admin.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $ulasanList = Ulasan::with('destinasi')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'semua'    => Ulasan::count(),
            'pending'  => Ulasan::where('status', 'pending')->count(),
            'approved' => Ulasan::where('status', 'approved')->count(),
            'ditolak'  => Ulasan::where('status', 'ditolak')->count(),
        ];

        return view('ulasan-admin', compact('ulasanList', 'counts', 'status'));
    }

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
        $ulasan->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
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
     * Admin: tolak ulasan yang berstatus pending.
     */
    public function reject(Ulasan $ulasan): RedirectResponse
    {
        $ulasan->update(['status' => 'ditolak']);

        return back()->with('success', 'Ulasan ditolak dan tidak akan tampil di halaman destinasi.');
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