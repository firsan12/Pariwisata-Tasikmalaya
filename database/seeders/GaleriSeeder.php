<?php

namespace Database\Seeders;

use App\Models\Destinasi;
use App\Models\Galeri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GaleriSeeder extends Seeder
{
    /**
     * Isi foto contoh SESUAI TEMA ke tabel galeris (dipakai halaman admin
     * "Kelola Galeri Wisata"). Tema ditentukan otomatis dari kata kunci
     * di nama destinasi, lewat loremflickr.com (tidak perlu API key).
     *
     * Menjalankan ulang seeder ini akan MENGHAPUS foto lama hasil seeder
     * (yang keterangannya "Foto contoh untuk ...") dulu, baru isi ulang.
     *
     * Jalankan dengan: php artisan db:seed --class=GaleriSeeder
     */
    protected int $fotoPerDestinasi = 3;

    protected array $petaKataKunci = [
        'kawah'      => 'volcano,crater,mountain',
        'gunung'     => 'mountain,volcano,landscape',
        'pantai'     => 'beach,ocean,coast',
        'laut'       => 'ocean,sea,beach',
        'masjid'     => 'mosque,islamic,architecture',
        'kampung'    => 'traditional-village,rural,indonesia',
        'desa'       => 'village,rural,indonesia',
        'curug'      => 'waterfall,forest',
        'air terjun' => 'waterfall,forest',
        'danau'      => 'lake,nature',
        'situ'       => 'lake,nature',
        'goa'        => 'cave',
        'gua'        => 'cave',
        'taman'      => 'garden,park,nature',
        'hutan'      => 'forest,jungle',
        'candi'      => 'temple,ancient,architecture',
    ];

    public function run(): void
    {
        $destinasiList = Destinasi::all();

        if ($destinasiList->isEmpty()) {
            $this->command->warn('Belum ada data destinasi — jalankan seeder destinasi dulu.');
            return;
        }

        foreach ($destinasiList as $destinasi) {
            // Bersihkan foto hasil seeder sebelumnya untuk destinasi ini
            Galeri::where('destinasi_id', $destinasi->id)
                ->where('keterangan', 'like', 'Foto contoh untuk%')
                ->delete();

            $kataKunci = $this->kataKunciUntuk($destinasi->nama);

            for ($i = 1; $i <= $this->fotoPerDestinasi; $i++) {
                $path = $this->unduhFotoTema($kataKunci);

                if (! $path) {
                    $this->command->warn("Gagal unduh foto ke-{$i} untuk destinasi: {$destinasi->nama}");
                    continue;
                }

                Galeri::create([
                    'destinasi_id' => $destinasi->id,
                    'judul'        => $destinasi->nama . ' - Foto ' . $i,
                    'foto'         => $path,
                    'keterangan'   => 'Foto contoh untuk ' . $destinasi->nama,
                ]);
            }

            $this->command->info("Selesai: {$destinasi->nama} (tema: {$kataKunci})");
        }
    }

    protected function kataKunciUntuk(string $nama): string
    {
        $namaLower = mb_strtolower($nama);

        foreach ($this->petaKataKunci as $kunci => $tag) {
            if (str_contains($namaLower, $kunci)) {
                return $tag;
            }
        }

        return 'indonesia,travel,nature';
    }

    protected function unduhFotoTema(string $kataKunci): ?string
    {
        $url = "https://loremflickr.com/800/600/{$kataKunci}";

        try {
            $response = Http::timeout(15)->get($url);

            if (! $response->successful()) {
                return null;
            }

            $namaFile = 'galeri/' . uniqid() . '.jpg';
            Storage::disk('public')->put($namaFile, $response->body());

            return $namaFile;
        } catch (\Throwable $e) {
            return null;
        }
    }
}