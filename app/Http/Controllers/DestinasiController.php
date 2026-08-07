<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Atraksi;
use Illuminate\Http\Request;
use app\Models\Ulasan;
class DestinasiController extends Controller
{
    public function beranda()
    {
        $destinasiUnggulan = Destinasi::latest()->get();
        $atraksiUnggulan   = Atraksi::latest()->take(6)->get(); // batasi 6 biar beranda tidak kepanjangan

        return view('beranda', compact('destinasiUnggulan', 'atraksiUnggulan'));
    }

    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $destinasiList = Destinasi::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->paginate(2);

        return view('destinasi', compact('destinasiList', 'keyword'));
    }

    public function show($id)
    {
     $destinasi = Destinasi::with('atraksi')->findOrFail($id);
        $destinasi = Destinasi::findOrFail($id);
        return view('destinasi-detail', compact('destinasi'));
    }

    public function create()
    {
        return view('destinasi-create');
    }

    protected function rules(): array
    {
        return [
            'nama'         => 'required|string|min:2|max:255',
            'deskripsi'    => 'required|string',
            'gambar'       => 'required|string|min:2|max:255',
            'jam_buka'     => 'required|date_format:H:i',
            'jam_tutup'    => 'required|date_format:H:i|after:jam_buka',
            'lokasi'       => 'nullable|string|max:255',
            'harga_dewasa' => 'required|integer|min:0',
            'harga_anak'   => 'required|integer|min:0',
            'harga_asing'  => 'required|integer|min:0',
            'kuota_dewasa' => 'required|integer|min:0',
            'kuota_anak'   => 'required|integer|min:0',
            'kuota_asing'  => 'required|integer|min:0',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

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
        $validated = $request->validate($this->rules());

        if ($validated['kuota_dewasa'] < $destinasi->terisi_dewasa) {
            return back()->withErrors(['kuota_dewasa' => 'Kuota dewasa tidak boleh kurang dari yang sudah terisi (' . $destinasi->terisi_dewasa . ').'])->withInput();
        }
        if ($validated['kuota_anak'] < $destinasi->terisi_anak) {
            return back()->withErrors(['kuota_anak' => 'Kuota anak tidak boleh kurang dari yang sudah terisi (' . $destinasi->terisi_anak . ').'])->withInput();
        }
        if ($validated['kuota_asing'] < $destinasi->terisi_asing) {
            return back()->withErrors(['kuota_asing' => 'Kuota asing tidak boleh kurang dari yang sudah terisi (' . $destinasi->terisi_asing . ').'])->withInput();
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