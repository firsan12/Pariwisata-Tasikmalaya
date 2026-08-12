<?php

namespace Database\Seeders;

use App\Models\Statistik;
use App\Models\VisiMisi;
use Illuminate\Database\Seeder;

class TentangContentSeeder extends Seeder
{
    /**
     * Isi persis sama dengan array statis yang sebelumnya hardcode
     * di resources/views/tentang.blade.php (variabel $statistik, $visi_misi).
     *
     * Pakai updateOrCreate (kunci: urutan) supaya aman dijalankan
     * berkali-kali lewat `php artisan db:seed` tanpa membuat data dobel.
     */
    public function run(): void
    {
        $statistik = [
            ['ikon' => 'bi-map-fill', 'angka' => '15+', 'label' => 'Destinasi Wisata'],
            ['ikon' => 'bi-houses-fill', 'angka' => '8', 'label' => 'Desa Wisata'],
            ['ikon' => 'bi-people-fill', 'angka' => '50K+', 'label' => 'Pengunjung / Tahun'],
            ['ikon' => 'bi-egg-fried', 'angka' => '20+', 'label' => 'Kuliner Khas'],
        ];
        foreach ($statistik as $i => $item) {
            Statistik::updateOrCreate(['urutan' => $i], $item);
        }

        $visiMisi = [
            [
                'ikon' => 'bi-bullseye',
                'judul' => 'Visi',
                'isi' => 'Menjadi destinasi wisata unggulan yang melestarikan alam dan budaya sambil meningkatkan kesejahteraan masyarakat lokal.',
            ],
            [
                'ikon' => 'bi-tree-fill',
                'judul' => 'Misi',
                'isi' => 'Mengembangkan pariwisata berkelanjutan, memberdayakan masyarakat sekitar, dan memperkenalkan kekayaan budaya kepada dunia.',
            ],
        ];
        foreach ($visiMisi as $i => $item) {
            VisiMisi::updateOrCreate(['urutan' => $i], $item);
        }
    }
}
