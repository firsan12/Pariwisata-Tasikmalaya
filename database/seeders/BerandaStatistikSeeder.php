<?php

namespace Database\Seeders;

use App\Models\BerandaStatistik;
use Illuminate\Database\Seeder;

class BerandaStatistikSeeder extends Seeder
{
    /**
     * Isi persis sama dengan 4 kartu statistik animasi yang sebelumnya
     * hardcode di section "STATISTIK" pada beranda.blade.php
     * (atribut data-jt-count / data-jt-decimal / data-jt-suffix).
     */
    public function run(): void
    {
        $data = [
            ['ikon' => 'bi-geo-alt-fill', 'nilai' => 15, 'desimal' => 0, 'suffix' => null, 'label' => 'Destinasi'],
            ['ikon' => 'bi-people-fill', 'nilai' => 50000, 'desimal' => 0, 'suffix' => '+', 'label' => 'Wisatawan'],
            ['ikon' => 'bi-star-fill', 'nilai' => 4.8, 'desimal' => 1, 'suffix' => null, 'label' => 'Rating'],
            ['ikon' => 'bi-ticket-perforated-fill', 'nilai' => 300, 'desimal' => 0, 'suffix' => '+', 'label' => 'Tiket/Hari'],
        ];

        foreach ($data as $i => $item) {
            BerandaStatistik::updateOrCreate(['urutan' => $i], $item);
        }
    }
}
