<?php

namespace Database\Seeders;

use App\Models\Keunggulan;
use Illuminate\Database\Seeder;

class KeunggulanSeeder extends Seeder
{
    /**
     * Isi persis sama dengan 6 item yang sebelumnya hardcode di section
     * "MENGAPA MEMILIH KAMI" pada beranda.blade.php.
     */
    public function run(): void
    {
        $data = [
            ['ikon' => 'bi-check-circle-fill', 'judul' => 'Booking Online'],
            ['ikon' => 'bi-lightning-charge-fill', 'judul' => 'Cepat'],
            ['ikon' => 'bi-shield-lock-fill', 'judul' => 'Aman'],
            ['ikon' => 'bi-star-fill', 'judul' => 'Rating Terpercaya'],
            ['ikon' => 'bi-geo-alt-fill', 'judul' => 'Destinasi Lengkap'],
            ['ikon' => 'bi-ticket-perforated-fill', 'judul' => 'Tiket Digital'],
        ];

        foreach ($data as $i => $item) {
            Keunggulan::updateOrCreate(['urutan' => $i], $item);
        }
    }
}
