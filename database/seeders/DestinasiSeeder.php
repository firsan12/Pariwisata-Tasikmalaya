<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destinasi;

class DestinasiSeeder extends Seeder
{
    public function run(): void
    {
        Destinasi::truncate();

        Destinasi::create([
            'nama' => 'Kawah Gunung Galunggung',
            'deskripsi' => 'Kawah hijau yang indah di bawah tebing, pemandian air panas alami, serta harus menaiki sekitar 620 anak tangga untuk melihat pemandangan dari atas.',
            'gambar' => 'kawah-galunggung.jpg',
            'jam_buka' => '07:00:00',
            'jam_tutup' => '17:00:00',
            'lokasi' => 'Desa Linggajati, Kecamatan Sukaratu, Kabupaten Tasikmalaya, Jawa Barat',
            'harga_dewasa' => 15000, 'harga_anak' => 8000, 'harga_asing' => 50000,
            'kuota_dewasa' => 100, 'kuota_anak' => 60, 'kuota_asing' => 30,
            'terisi_dewasa' => 0, 'terisi_anak' => 0, 'terisi_asing' => 0,
        ]);

        Destinasi::create([
            'nama' => 'Kampung Naga',
            'deskripsi' => 'Kampung adat Sunda tradisional yang sangat ketat menjaga aturan leluhur, rumah panggung dari kayu dan bambu, serta suasana desa yang sangat tenang dan asri.',
            'gambar' => 'kampung-naga.jpg',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '17:30:00',
            'lokasi' => 'Desa Neglasari, Kecamatan Salawu, Kabupaten Tasikmalaya, Jawa Barat',
            'harga_dewasa' => 10000, 'harga_anak' => 5000, 'harga_asing' => 30000,
            'kuota_dewasa' => 80, 'kuota_anak' => 40, 'kuota_asing' => 15,
            'terisi_dewasa' => 0, 'terisi_anak' => 0, 'terisi_asing' => 0,
        ]);

        Destinasi::create([
            'nama' => 'Pantai Karang Tawulan',
            'deskripsi' => 'Tebing karang yang berbatasan langsung dengan Samudra Hindia, ombak besar yang memecah karang, dan pemandangan matahari terbenam yang sangat cantik.',
            'gambar' => 'pantai-karang-tawulan.jpg',
            'jam_buka' => '06:00:00',
            'jam_tutup' => '18:00:00',
            'lokasi' => 'Desa Kalapagenep, Kecamatan Cikalong, Kabupaten Tasikmalaya, Jawa Barat',
            'harga_dewasa' => 20000, 'harga_anak' => 10000, 'harga_asing' => 60000,
            'kuota_dewasa' => 150, 'kuota_anak' => 80, 'kuota_asing' => 40,
            'terisi_dewasa' => 0, 'terisi_anak' => 0, 'terisi_asing' => 0,
        ]);

        Destinasi::create([
            'nama' => 'Masjid Agung Tasikmalaya',
            'deskripsi' => 'Pusat Kota: Terletak di jantung Kota Tasikmalaya dekat kawasan pusat aktivitas warga.Ikon Religi: Menjadi pusat kegiatan keagamaan dan simbol keharmonisan Islam di daerah tersebut.Fasilitas: Memiliki area yang luas, halaman atau taman yang asri, serta bangunan utama yang sering menjadi rujukan wisata religi',
            'gambar' => 'masjid-agung-tasikmalaya.jpg',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '23:00:00',
            'lokasi' => 'Jl. Mesjid Agung No.01, Yudanagara, Kec. Tawang, Kota Tasikmalaya, Jawa Barat 46121',
            'harga_dewasa' => 15000, 'harga_anak' => 8000, 'harga_asing' => 50000,
            'kuota_dewasa' => 100, 'kuota_anak' => 50, 'kuota_asing' => 20,
            'terisi_dewasa' => 0, 'terisi_anak' => 0, 'terisi_asing' => 0,
        ]);
    }
}