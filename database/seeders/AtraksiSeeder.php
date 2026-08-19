<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Atraksi;
use App\Models\Destinasi;
 
class AtraksiSeeder extends Seeder
{
    public function run(): void
    {
        $atraksiData = [
            [
                'destinasi_nama' => 'Nama Destinasi Anda',
                'nama' => 'Nama Atraksi 1',
                'deskripsi' => 'Deskripsi singkat atraksi ini.',
                'kategori' => 'Budaya',
                'harga' => 5000,
                'gambar' => 'atraksi/nama-file-1.jpg',
            ],
            [
                'destinasi_nama' => 'Nama Destinasi Anda',
                'nama' => 'Nama Atraksi 2',
                'deskripsi' => 'Deskripsi singkat atraksi kedua.',
                'kategori' => 'Alam',
                'harga' => 0,
                'gambar' => 'atraksi/nama-file-2.jpg',
            ],
        ];
 
        foreach ($atraksiData as $data) {
            $destinasi = Destinasi::where('nama', $data['destinasi_nama'])->first();
 
            if (!$destinasi) {
                continue; // lewati kalau nama destinasinya tidak ditemukan (typo/belum ada)
            }
 
            $data['destinasi_id'] = $destinasi->id;
            unset($data['destinasi_nama']);
 
            Atraksi::updateOrCreate(['nama' => $data['nama']], $data);
        }
    }
}
