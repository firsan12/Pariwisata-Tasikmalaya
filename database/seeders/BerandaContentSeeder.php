<?php

namespace Database\Seeders;

use App\Models\EventPromo;
use App\Models\KategoriWisata;
use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class BerandaContentSeeder extends Seeder
{
    /**
     * Isi persis sama dengan array statis yang sebelumnya hardcode
     * di resources/views/beranda.blade.php (variabel $kategoriList,
     * $eventList, $testimoniList).
     *
     * Pakai updateOrCreate (kunci: urutan) supaya aman dijalankan
     * berkali-kali lewat `php artisan db:seed` tanpa membuat data dobel.
     */
    public function run(): void
    {
        $kategori = [
            ['emoji' => '🏖', 'nama' => 'Pantai'],
            ['emoji' => '🌋', 'nama' => 'Gunung'],
            ['emoji' => '🕌', 'nama' => 'Religi'],
            ['emoji' => '🏛', 'nama' => 'Budaya'],
            ['emoji' => '🍜', 'nama' => 'Kuliner'],
        ];
        foreach ($kategori as $i => $item) {
            KategoriWisata::updateOrCreate(['urutan' => $i], $item);
        }

        $events = [
            ['judul' => 'Festival Budaya Tasikmalaya', 'promo' => 'Diskon 20%'],
            ['judul' => 'Wisata Religi Ramadan', 'promo' => 'Diskon 15%'],
        ];
        foreach ($events as $i => $item) {
            EventPromo::updateOrCreate(['urutan' => $i], $item);
        }

        $testimoni = [
            ['nama' => 'Firman', 'isi' => 'Sangat mudah membeli tiket, prosesnya cepat.'],
            ['nama' => 'Andi', 'isi' => 'Tempat wisatanya bagus dan terawat.'],
            ['nama' => 'Sinta', 'isi' => 'Pelayanan ramah, akan booking lagi lain kali.'],
        ];
        foreach ($testimoni as $i => $item) {
            Testimoni::updateOrCreate(['urutan' => $i], $item);
        }
    }
}
