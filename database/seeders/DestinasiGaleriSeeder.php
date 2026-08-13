<?php

namespace Database\Seeders;

use App\Models\Destinasi;
use App\Models\DestinasiGaleri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DestinasiGaleriSeeder extends Seeder
{
    /**
     * Isi foto contoh SESUAI TEMA ke tabel destinasi_galeri (dipakai halaman
     * detail destinasi). Tema ditentukan otomatis dari kata kunci di nama
     * destinasi (kawah/gunung, pantai, masjid, kampung, dst), lewat
     * loremflickr.com — layanan foto acak berbasis kata kunci, tidak
     * perlu API key.
     *
     * Menjalankan ulang seeder ini akan MENGHAPUS foto lama di tabel ini
     * dulu (supaya tidak dobel), baru isi ulang dengan foto baru.
     *
     * Jalankan dengan: php artisan db:seed --class=DestinasiGaleriSeeder
     */
    protected int $fotoPerDestinasi = 4;

    /**
     * Kata kunci pencarian foto per jenis destinasi. Dicocokkan dengan
     * mencari potongan kata ini di dalam nama destinasi (huruf kecil semua).
     * Urutan penting — yang lebih spesifik taruh di atas.
     */
    protected array $petaKataKunci = [
        'kawah'    => 'volcano,crater,mountain',
        'gunung'   => 'mountain,volcano,landscape',
        'pantai'   => 'beach,ocean,coast',
        'laut'     => 'ocean,sea,beach',
        'masjid'   => 'mosque,islamic,architecture',
        'kampung'  => 'traditional-village,rural,indonesia',
        'desa'     => 'village,rural,indonesia',
        'curug'    => 'waterfall,forest',
        'air terjun' => 'waterfall,forest',
        'danau'    => 'lake,nature',
        'situ'     => 'lake,nature',
        'goa'      => 'cave',
        'gua'      => 'cave',
        'taman'    => 'garden,park,nature',
        'hutan'    => 'forest,jungle',
        'candi'    => 'temple,ancient,architecture',
    ];

    public function run(): void
    {
        $destinasiList = Destinasi::all();

        if ($destinasiList->isEmpty()) {
            $this->command->warn('Belum ada data destinasi — jalankan seeder destinasi dulu.');
            return;
        }

        foreach ($destinasiList as $destinasi) {
            // Bersihkan foto lama milik destinasi ini supaya tidak dobel
            DestinasiGaleri::where('destinasi_id', $destinasi->id)->delete();

            $kataKunci = $this->kataKunciUntuk($destinasi->nama);

            for ($urutan = 1; $urutan <= $this->fotoPerDestinasi; $urutan++) {
                $path = $this->unduhFotoTema($kataKunci);

                if (! $path) {
                    $this->command->warn("Gagal unduh foto ke-{$urutan} untuk destinasi: {$destinasi->nama}");
                    continue;
                }

                DestinasiGaleri::create([
                    'destinasi_id' => $destinasi->id,
                    'gambar'       => $path,
                    'urutan'       => $urutan,
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

        return 'indonesia,travel,nature'; // fallback kalau tidak cocok kata kunci manapun
    }

    protected function unduhFotoTema(string $kataKunci): ?string
    {
        // loremflickr: foto acak dari Flickr yang cocok dengan tag yang diminta
        $url = "https://loremflickr.com/900/700/{$kataKunci}";

        try {
            $response = Http::timeout(15)->get($url);

            if (! $response->successful()) {
                return null;
            }

            $namaFile = 'destinasi-galeri/' . uniqid() . '.jpg';
            Storage::disk('public')->put($namaFile, $response->body());

            return $namaFile;
        } catch (\Throwable $e) {
            return null;
        }
    }
}