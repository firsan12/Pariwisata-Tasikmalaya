<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Atraksi;
use Illuminate\Http\Request;
use App\Models\Ulasan;
use App\Models\EventPromo;
use App\Models\KategoriWisata;
use App\Models\Testimoni;
use App\Models\ProfilSitus;
use App\Models\BerandaStatistik;
use App\Models\Keunggulan;
use App\Models\Kuliner;

class DestinasiController extends Controller
{
    public function beranda()
    {
        // Tidak ada kolom "unggulan" di tabel destinasi, jadi ambil 6 terbaru
        $destinasiUnggulan = Destinasi::latest()->take(6)->get();

        // Konten kategori/event/testimoni/statistik/keunggulan sekarang dari
        // database (lihat BerandaContentSeeder, BerandaStatistikSeeder,
        // KeunggulanSeeder). Blade tetap punya fallback array statis
        // sehingga tidak error kalau tabelnya masih kosong.
        $kategoriWisata    = KategoriWisata::orderBy('urutan')->get();
        $events            = EventPromo::orderBy('urutan')->get();
        $testimonis        = Testimoni::orderBy('urutan')->get();
        $profilSitus       = ProfilSitus::current();
        $berandaStatistik  = BerandaStatistik::orderBy('urutan')->get();
        $keunggulan        = Keunggulan::orderBy('urutan')->get();
        $kulinerPopuler    = Kuliner::latest()->take(4)->get();

        // Semua destinasi yang sudah punya koordinat, untuk peta interaktif
        $destinasiPeta = Destinasi::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'nama', 'latitude', 'longitude']);

        return view('beranda', compact(
            'destinasiUnggulan',
            'kategoriWisata',
            'events',
            'testimonis',
            'profilSitus',
            'berandaStatistik',
            'keunggulan',
            'kulinerPopuler',
            'destinasiPeta'
        ));
    }

    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $destinasiList = Destinasi::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->paginate(9);

        return view('destinasi', compact('destinasiList', 'keyword'));
    }

    public function show($id)
    {
        $destinasi = Destinasi::with(['atraksi', 'galeri'])->findOrFail($id);

        $destinasiLain = Destinasi::where('id', '!=', $destinasi->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('destinasi-detail', compact('destinasi', 'destinasiLain'));
    }

    public function create()
    {
        return view('destinasi-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|min:2|max:255',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|max:2048',
            'jam_buka'     => 'required|date_format:H:i',
            'jam_tutup'    => 'required|date_format:H:i',
            'lokasi'       => 'nullable|string|max:255',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'harga_dewasa' => 'required|integer|min:0',
            'harga_anak'   => 'required|integer|min:0',
            'harga_asing'  => 'required|integer|min:0',
            'kuota_dewasa' => 'required|integer|min:0',
            'kuota_anak'   => 'required|integer|min:0',
            'kuota_asing'  => 'required|integer|min:0',
        ]);

        $destinasi = Destinasi::create($validated);

        return redirect()->route('destinasi.detail', $destinasi->id)
            ->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $destinasi = Destinasi::findOrFail($id);
        return view('destinasi-edit', compact('destinasi'));
    }

    public function update(Request $request, $id)
    {
        $destinasi = Destinasi::findOrFail($id);

        $validated = $request->validate([
            'nama'         => 'required|string|min:2|max:255',
            'deskripsi'    => 'required|string',
            'gambar'       => 'nullable|image|max:2048',
            'jam_buka'     => 'required|date_format:H:i',
            'jam_tutup'    => 'required|date_format:H:i',
            'lokasi'       => 'nullable|string|max:255',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
            'harga_dewasa' => 'required|integer|min:0',
            'harga_anak'   => 'required|integer|min:0',
            'harga_asing'  => 'required|integer|min:0',
            'kuota_dewasa' => 'required|integer|min:0',
            'kuota_anak'   => 'required|integer|min:0',
            'kuota_asing'  => 'required|integer|min:0',
        ]);

        if ($validated['kuota_dewasa'] < $destinasi->terisi_dewasa) {
            return back()->withErrors(['kuota_dewasa' => 'Kuota dewasa tidak boleh kurang dari yang sudah terisi (' . $destinasi->terisi_dewasa . ').'])->withInput();
        }
        if ($validated['kuota_anak'] < $destinasi->terisi_anak) {
            return back()->withErrors(['kuota_anak' => 'Kuota anak tidak boleh kurang dari yang sudah terisi (' . $destinasi->terisi_anak . ').'])->withInput();
        }
        if ($validated['kuota_asing'] < $destinasi->terisi_asing) {
            return back()->withErrors(['kuota_asing' => 'Kuota asing tidak boleh kurang dari yang sudah terisi (' . $destinasi->terisi_asing . ').'])->withInput();
        }
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('destinasi', 'public');
        } else {
            unset($validated['gambar']);
        }

        $destinasi->update($validated);

        return redirect()->route('destinasi.detail', $destinasi->id)
            ->with('success', 'Destinasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $destinasi = Destinasi::findOrFail($id);
        $destinasi->delete();

        return redirect()->route('destinasi')
            ->with('success', 'Destinasi berhasil dihapus!');
    }

    public function admin(Request $request)
    {
        $keyword = $request->input('cari');

        $destinasiList = Destinasi::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->get();

        return view('destinasi-admin', compact('destinasiList', 'keyword'));
    }
}