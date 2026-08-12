<?php

namespace Database\Seeders;

use App\Models\ProfilSitus;
use Illuminate\Database\Seeder;

class ProfilSitusSeeder extends Seeder
{
    /**
     * Isi persis sama dengan teks statis yang sebelumnya hardcode di
     * beranda.blade.php, tentang.blade.php, dan kontak.blade.php.
     */
    public function run(): void
    {
        ProfilSitus::updateOrCreate(
            ['id' => 1],
            [
                // Beranda - Hero
                'nama_situs' => 'Wisata Tasikmalaya',
                'hero_deskripsi' => 'Temukan wisata, kuliner, budaya, dan pengalaman terbaik di Tasikmalaya.',
                'hero_trust_destinasi' => '🗺️ 15+ Destinasi Pilihan',
                'hero_trust_wisatawan' => '⭐ Dipercaya 50K+ Wisatawan Setiap Tahun',

                // Tentang
                'tentang_hero_deskripsi' => 'Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun.',
                'tentang_gambar_hero' => 'pantai-karang-tawulan.jpeg',
                'tentang_judul' => 'Sepenggal Cerita dari Tanah Tasikmalaya',
                'tentang_intro' => 'Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun.',
                'tentang_gambar' => 'tata-letak4.jpg',
                'tentang_sublabel' => 'Kekayaan Alam & Budaya',
                'tentang_subjudul' => 'Jejak Alam yang Tak Lekang Waktu',
                'tentang_deskripsi_1' => 'Berbagai destinasi wisata alam, sejarah, dan kuliner siap menyambut setiap wisatawan yang berkunjung. Dari kawah gunung yang megah, kampung adat yang masih menjaga tradisi leluhur, hingga pantai dengan pemandangan matahari terbenam yang memukau.',
                'tentang_deskripsi_2' => 'Kami berkomitmen menjaga kelestarian alam sekaligus memperkenalkan budaya lokal kepada generasi masa kini.',

                // Kontak
                'kontak_judul' => 'Ada Pertanyaan atau Saran?',
                'kontak_intro' => 'Kirimkan pesan Anda kepada kami, atau hubungi langsung lewat kontak di bawah ini.',
                'kontak_email' => 'firmanihsan13@gmail.com',
                'kontak_whatsapp' => '6281261604202',
                'kontak_whatsapp_display' => '0812-6160-4202',
                'kontak_alamat' => 'Dinas Pariwisata, Kota Tasikmalaya, Jawa Barat',
                'kontak_alamat_maps_url' => 'https://www.google.com/maps/search/?api=1&query=Dinas+Pariwisata+Kota+Tasikmalaya+Jawa+Barat',
                'kontak_jam_operasional' => 'Senin – Jumat, 08.00 – 16.00 WIB',

                // Rekening & e-wallet tujuan pembayaran
                'rekening_seabank_nomor' => '901287295755',
                'rekening_seabank_nama' => 'Firman Khoerul Ihsan',
                'ewallet_tujuan_nomor' => '081261604202',
            ]
        );
    }
}
