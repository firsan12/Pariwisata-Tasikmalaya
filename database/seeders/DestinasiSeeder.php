<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destinasi;

/**
 * DIPERBARUI oleh Claude — 14 Agustus 2026
 * Data disesuaikan dengan harga tiket, jam operasional, dan deskripsi TERKINI (2026)
 * hasil verifikasi dari sumber resmi/berita pariwisata (Traveloka, Priangan.com, Kompas, dll).
 *
 * CATATAN PENTING #1: seeder ini TIDAK memakai truncate() lagi, karena tabel `destinasi`
 * direferensikan oleh foreign key dari tabel `pemesanan` (pemesanan_destinasi_id_foreign).
 * truncate() gagal (error 1701) selama ada data pemesanan yang menunjuk ke destinasi.
 *
 * CATATAN PENTING #2: kolom 'gambar' SENGAJA tidak ditimpa untuk baris yang sudah ada,
 * supaya foto asli yang sudah diupload lewat dashboard/CMS tidak hilang/tertimpa balik
 * ke nama file placeholder lama. 'gambar' hanya diisi placeholder saat baris BARU dibuat
 * (baris itu belum pernah ada fotonya sama sekali).
 */
class DestinasiSeeder extends Seeder
{
    public function run(): void
    {
        $this->upsert('Kawah Gunung Galunggung', 'kawah-galunggung.jpg', [
            'deskripsi' => 'Kawah hijau yang indah di bawah tebing, pemandian air panas alami, serta harus menaiki sekitar 620 anak tangga untuk melihat pemandangan dari atas.',

            // UPDATE: jam buka area kawah resmi 06:00 (sebelumnya tertulis 07:00).
            // Pemandian air panas (Cipanas) buka 24 jam, terpisah dari area kawah.
            'jam_buka' => '06:00:00',
            'jam_tutup' => '17:00:00',

            'lokasi' => 'Desa Linggajati, Kecamatan Sukaratu, Kabupaten Tasikmalaya, Jawa Barat',

            // UPDATE: harga tiket 2026 (sumber: Priangan.com, Maret 2026) —
            // HTM lokal Rp17.000, HTM asing Rp72.000. Tidak ada tarif anak terpisah
            // untuk tiket masuk kawah, sehingga harga_anak disamakan dengan harga_dewasa.
            // Biaya lain di luar tiket dasar (tidak dimasukkan ke kolom ini):
            //   - Parkir motor Rp3.000, mobil Rp6.000 | Camping Rp28.000
            //   - Cipanas (air panas) Rp11.000/orang terpisah
            'harga_dewasa' => 17000,
            'harga_anak' => 17000,
            'harga_asing' => 72000,

            'kuota_dewasa' => 100, 'kuota_anak' => 60, 'kuota_asing' => 30,
        ]);

        $this->upsert('Kampung Naga', 'kampung-naga.jpg', [
            'deskripsi' => 'Kampung adat Sunda tradisional yang sangat ketat menjaga aturan leluhur, rumah panggung dari kayu dan bambu, serta suasana desa yang sangat tenang dan asri.',

            // UPDATE: jam tutup resmi 18:00 (sebelumnya tertulis 17:30).
            'jam_buka' => '08:00:00',
            'jam_tutup' => '18:00:00',

            'lokasi' => 'Desa Neglasari, Kecamatan Salawu, Kabupaten Tasikmalaya, Jawa Barat',

            // UPDATE: Kampung Naga TIDAK memungut tiket masuk resmi — bersifat
            // "seikhlasnya"/sumbangan sukarela, sehingga harga tiket sebenarnya Rp0
            // untuk semua kategori pengunjung (bukan Rp10.000/5.000/30.000 seperti sebelumnya).
            // Biaya di lapangan yang tidak dimasukkan ke kolom ini:
            //   - Jasa pemandu lokal ±Rp150.000 (opsional) | Parkir Rp3.000–Rp40.000
            'harga_dewasa' => 0,
            'harga_anak' => 0,
            'harga_asing' => 0,

            'kuota_dewasa' => 80, 'kuota_anak' => 40, 'kuota_asing' => 15,
        ]);

        $this->upsert('Pantai Karang Tawulan', 'pantai-karang-tawulan.jpg', [
            'deskripsi' => 'Tebing karang yang berbatasan langsung dengan Samudra Hindia, ombak besar yang memecah karang, dan pemandangan matahari terbenam yang sangat cantik.',

            // UPDATE: pantai ini buka 24 jam setiap hari menurut sumber terbaru
            // (Kompas, Kumparan, Goers 2026), bukan 06:00–18:00 seperti data lama.
            // Direpresentasikan 00:00–23:59 karena kolom bertipe time.
            'jam_buka' => '00:00:00',
            'jam_tutup' => '23:59:00',

            'lokasi' => 'Desa Kalapagenep/Cimanuk, Kecamatan Cikalong, Kabupaten Tasikmalaya, Jawa Barat',

            // UPDATE: harga tiket riil Rp3.500/orang (dikonfirmasi berulang oleh Kompas &
            // Traveloka), jauh lebih murah dari data lama (Rp20.000/10.000/60.000).
            // Tidak ada pembedaan harga anak/dewasa/asing di lapangan — disamakan Rp3.500.
            // Biaya lain di lapangan yang tidak dimasukkan ke kolom ini:
            //   - Parkir motor Rp2.500–3.000, mobil Rp10.000
            'harga_dewasa' => 3500,
            'harga_anak' => 3500,
            'harga_asing' => 3500,

            'kuota_dewasa' => 150, 'kuota_anak' => 80, 'kuota_asing' => 40,
        ]);

        // Masjid Agung Tasikmalaya — tidak diubah, di luar cakupan riset Firman.
        $this->upsert('Masjid Agung Tasikmalaya', 'masjid-agung-tasikmalaya.jpg', [
            'deskripsi' => 'Pusat Kota: Terletak di jantung Kota Tasikmalaya dekat kawasan pusat aktivitas warga.Ikon Religi: Menjadi pusat kegiatan keagamaan dan simbol keharmonisan Islam di daerah tersebut.Fasilitas: Memiliki area yang luas, halaman atau taman yang asri, serta bangunan utama yang sering menjadi rujukan wisata religi',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '23:00:00',
            'lokasi' => 'Jl. Mesjid Agung No.01, Yudanagara, Kec. Tawang, Kota Tasikmalaya, Jawa Barat 46121',
            'harga_dewasa' => 15000, 'harga_anak' => 8000, 'harga_asing' => 50000,
            'kuota_dewasa' => 100, 'kuota_anak' => 50, 'kuota_asing' => 20,
        ]);
    }

    /**
     * Update destinasi berdasarkan nama tanpa menyentuh kolom 'gambar' jika baris
     * sudah ada (agar foto asli yang sudah diupload tidak tertimpa). Kolom 'gambar'
     * hanya diisi $placeholderGambar saat baris benar-benar baru dibuat.
     */
    private function upsert(string $nama, string $placeholderGambar, array $data): void
    {
        $destinasi = Destinasi::firstOrNew(['nama' => $nama]);

        if (!$destinasi->exists) {
            $destinasi->gambar = $placeholderGambar;
        }

        $destinasi->fill($data);
        $destinasi->save();
    }
}