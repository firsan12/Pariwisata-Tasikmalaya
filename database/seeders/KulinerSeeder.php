<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuliner;

class KulinerSeeder extends Seeder
{
    /**
     * Kata kunci foto (bahasa Inggris, untuk loremflickr) per jenis makanan.
     * Dicocokkan dengan mencari potongan kata di nama menu (huruf kecil).
     * Urutan penting — yang lebih spesifik ditaruh lebih dulu.
     */
    protected array $petaKataKunci = [
        // PENTING: satu kata kunci UMUM saja per baris (tanpa koma, tanpa
        // tanda hubung/hyphen). loremflickr menganggap kata yang dipisah
        // koma sebagai "harus cocok SEMUA sekaligus" (AND), bukan salah
        // satu — jadi kombinasi kata yang jarang/aneh sering tidak ada
        // hasilnya (gambar patah). Kata umum tunggal jauh lebih pasti ada.
        'sate'           => 'satay',
        'bakso'          => 'meatball',
        'soto'           => 'soup',
        'mie kocok'      => 'noodles',
        'mie'            => 'noodles',
        'kwetiau'        => 'noodles',
        'kopi'           => 'coffee',
        'wedang'         => 'ginger',
        'bandrek'        => 'ginger',
        'bajigur'        => 'drink',
        'es cendol'      => 'dessert',
        'es dawet'       => 'dessert',
        'es campur'      => 'fruit',
        'es kelapa'      => 'coconut',
        'es teh'         => 'tea',
        'es '            => 'drink',
        'kerupuk'        => 'cracker',
        'keripik'        => 'chips',
        'opak'           => 'cracker',
        'rangginang'     => 'cracker',
        'klepon'         => 'dessert',
        'putu'           => 'dessert',
        'wajit'          => 'dessert',
        'colenak'        => 'dessert',
        'peuyeum'        => 'cassava',
        'combro'         => 'snack',
        'misro'          => 'snack',
        'cireng'         => 'snack',
        'cilok'          => 'meatball',
        'batagor'        => 'dumpling',
        'siomay'         => 'dumpling',
        'seblak'         => 'noodles',
        'tahu gejrot'    => 'tofu',
        'tahu'           => 'tofu',
        'ayam goreng'    => 'chicken',
        'ayam penyet'    => 'chicken',
        'ayam'           => 'chicken',
        'gurame'         => 'fish',
        'lele'           => 'fish',
        'ikan'           => 'fish',
        'pisang goreng'  => 'banana',
        'pisang molen'   => 'banana',
        'pisang'         => 'banana',
        'nasi goreng'    => 'rice',
        'nasi kuning'    => 'rice',
        'nasi'           => 'rice',
        'lontong'        => 'rice',
        'karedok'        => 'salad',
        'lotek'          => 'salad',
        'pecel'          => 'salad',
        'surabi'         => 'pancake',
        'donat'          => 'donut',
        'bubur'          => 'porridge',
        'sambal'         => 'chili',
    ];

    protected function fotoUntuk(string $nama, string $slug): string
    {
        $namaLower = mb_strtolower($nama);
        $kataKunci = 'food'; // fallback — kata umum, pasti banyak hasilnya

        foreach ($this->petaKataKunci as $kunci => $tag) {
            if (str_contains($namaLower, $kunci)) {
                $kataKunci = $tag;
                break;
            }
        }

        // lock dibuat dari slug supaya foto TETAP SAMA setiap dibuka lagi
        // (tanpa lock, loremflickr kasih foto acak baru tiap request)
        $lock = crc32($slug) % 100000;

        return "https://loremflickr.com/1600/1000/{$kataKunci}?lock={$lock}";
    }

    public function run(): void
    {
        $data = [

            [
                'nama' => 'Nasi Tutug Oncom',
                'slug' => 'nasi-tutug-oncom',
                'deskripsi' => 'Nasi khas Tasikmalaya yang dicampur dengan tutug oncom, biasanya disajikan bersama lalapan, sambal dan lauk.',
                'kategori' => 'Makanan Khas',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Nasi Cikur',
                'slug' => 'nasi-cikur',
                'deskripsi' => 'Olahan nasi dengan aroma khas kencur yang menjadi salah satu kuliner tradisional Sunda.',
                'kategori' => 'Makanan Khas',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Kupat Tahu Tasikmalaya',
                'slug' => 'kupat-tahu-tasikmalaya',
                'deskripsi' => 'Kupat tahu dengan perpaduan ketupat, tahu, tauge dan bumbu kacang yang gurih.',
                'kategori' => 'Makanan Tradisional',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Soto Tasikmalaya',
                'slug' => 'soto-tasikmalaya',
                'deskripsi' => 'Sajian soto hangat dengan kuah gurih dan isian yang cocok dinikmati kapan saja.',
                'kategori' => 'Makanan',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Bubur Ayam Tasikmalaya',
                'slug' => 'bubur-ayam-tasikmalaya',
                'deskripsi' => 'Bubur ayam dengan suwiran ayam, cakwe, daun bawang dan pelengkap lainnya.',
                'kategori' => 'Sarapan',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Bakso Tasik',
                'slug' => 'bakso-tasik',
                'deskripsi' => 'Bakso dengan kuah gurih, mie, sayuran dan pelengkap yang cocok disantap siang maupun malam.',
                'kategori' => 'Makanan',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Mie Bakso',
                'slug' => 'mie-bakso-tasikmalaya',
                'deskripsi' => 'Perpaduan mie dan bakso dengan kuah kaldu gurih serta berbagai pelengkap.',
                'kategori' => 'Mie & Bakso',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Sate Maranggi',
                'slug' => 'sate-maranggi-tasikmalaya',
                'deskripsi' => 'Sate berbumbu khas dengan aroma bakaran yang kuat dan cita rasa gurih manis.',
                'kategori' => 'Sate',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 25000,
            ],

            [
                'nama' => 'Nasi Liwet Sunda',
                'slug' => 'nasi-liwet-sunda',
                'deskripsi' => 'Nasi liwet gurih khas Sunda dengan lauk, lalapan dan sambal.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 20000,
            ],

            [
                'nama' => 'Ayam Goreng Sunda',
                'slug' => 'ayam-goreng-sunda',
                'deskripsi' => 'Ayam goreng berbumbu gurih dengan sambal dan lalapan segar.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 18000,
            ],

            [
                'nama' => 'Gurame Bakar',
                'slug' => 'gurame-bakar-tasikmalaya',
                'deskripsi' => 'Ikan gurame bakar dengan bumbu khas Sunda dan sambal pendamping.',
                'kategori' => 'Seafood',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 35000,
            ],

            [
                'nama' => 'Gurame Goreng',
                'slug' => 'gurame-goreng',
                'deskripsi' => 'Gurame goreng renyah dengan sambal dan lalapan.',
                'kategori' => 'Seafood',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 35000,
            ],

            [
                'nama' => 'Karedok',
                'slug' => 'karedok-tasikmalaya',
                'deskripsi' => 'Sayuran segar dengan bumbu kacang khas Sunda.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Lotek',
                'slug' => 'lotek-tasikmalaya',
                'deskripsi' => 'Aneka sayuran dengan bumbu kacang gurih dan pelengkap tradisional.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Pecel Sunda',
                'slug' => 'pecel-sunda',
                'deskripsi' => 'Sayuran rebus dengan sambal kacang dan pelengkap khas Sunda.',
                'kategori' => 'Makanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Tahu Bulat',
                'slug' => 'tahu-bulat-tasikmalaya',
                'deskripsi' => 'Jajanan tahu berbentuk bulat yang digoreng dan disantap hangat.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Cireng',
                'slug' => 'cireng-tasikmalaya',
                'deskripsi' => 'Jajanan berbahan tepung tapioka dengan tekstur kenyal dan gurih.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Cilok',
                'slug' => 'cilok-tasikmalaya',
                'deskripsi' => 'Jajanan aci berbentuk bulat dengan saus kacang dan berbagai pilihan bumbu.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Combro',
                'slug' => 'combro-tasikmalaya',
                'deskripsi' => 'Gorengan berbahan singkong dengan isian oncom pedas gurih.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 3000,
            ],

            [
                'nama' => 'Misro',
                'slug' => 'misro-tasikmalaya',
                'deskripsi' => 'Jajanan singkong goreng dengan isian gula merah yang manis.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 3000,
            ],

            [
                'nama' => 'Opak',
                'slug' => 'opak-tasikmalaya',
                'deskripsi' => 'Kerupuk tradisional berbahan singkong atau beras dengan tekstur renyah.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Rangginang',
                'slug' => 'rangginang-tasikmalaya',
                'deskripsi' => 'Kerupuk tradisional dari beras ketan yang digoreng hingga renyah.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Sale Pisang',
                'slug' => 'sale-pisang-tasikmalaya',
                'deskripsi' => 'Olahan pisang yang dikeringkan dan memiliki cita rasa manis khas.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Wajit',
                'slug' => 'wajit-tasikmalaya',
                'deskripsi' => 'Jajanan tradisional berbahan ketan, gula merah dan santan dengan rasa manis legit.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Peuyeum Ketan',
                'slug' => 'peuyeum-ketan',
                'deskripsi' => 'Olahan ketan fermentasi dengan rasa manis dan sedikit asam.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Sambal Goang',
                'slug' => 'sambal-goang',
                'deskripsi' => 'Sambal khas Sunda yang sederhana namun memiliki rasa pedas segar.',
                'kategori' => 'Sambal',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Nasi Timbel',
                'slug' => 'nasi-timbel-tasikmalaya',
                'deskripsi' => 'Nasi hangat yang dibungkus daun pisang dan disajikan dengan lauk serta lalapan.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 18000,
            ],

            [
                'nama' => 'Nasi Bakar',
                'slug' => 'nasi-bakar-tasikmalaya',
                'deskripsi' => 'Nasi berbumbu yang dibungkus daun pisang kemudian dibakar hingga harum.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Seblak',
                'slug' => 'seblak-tasikmalaya',
                'deskripsi' => 'Jajanan bercita rasa pedas dengan kerupuk basah dan berbagai pilihan isian.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Mie Jebew',
                'slug' => 'mie-jebew-tasikmalaya',
                'deskripsi' => 'Olahan mie pedas dengan bumbu kuat dan pilihan topping.',
                'kategori' => 'Mie',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Mie Kocok',
                'slug' => 'mie-kocok-tasikmalaya',
                'deskripsi' => 'Mie dengan kuah kaldu gurih dan pelengkap yang menghangatkan.',
                'kategori' => 'Mie',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Batagor',
                'slug' => 'batagor-tasikmalaya',
                'deskripsi' => 'Olahan tahu dan ikan goreng yang disajikan dengan bumbu kacang.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Siomay',
                'slug' => 'siomay-tasikmalaya',
                'deskripsi' => 'Siomay dengan tahu, kentang, kol dan bumbu kacang.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Tahu Gejrot',
                'slug' => 'tahu-gejrot',
                'deskripsi' => 'Potongan tahu dengan kuah gula merah, bawang dan cabai.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Pisang Goreng',
                'slug' => 'pisang-goreng-tasikmalaya',
                'deskripsi' => 'Pisang goreng renyah yang cocok sebagai teman minum kopi atau teh.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Surabi',
                'slug' => 'surabi-tasikmalaya',
                'deskripsi' => 'Kue tradisional berbahan tepung beras dengan pilihan rasa manis atau gurih.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 7000,
            ],

            [
                'nama' => 'Colenak',
                'slug' => 'colenak-tasikmalaya',
                'deskripsi' => 'Peuyeum bakar yang disajikan dengan saus gula merah dan kelapa.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Es Cendol',
                'slug' => 'es-cendol-tasikmalaya',
                'deskripsi' => 'Minuman tradisional dengan cendol, santan dan gula merah.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Es Campur',
                'slug' => 'es-campur-tasikmalaya',
                'deskripsi' => 'Minuman dingin dengan campuran buah, agar-agar, sirup dan es.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Es Kelapa Muda',
                'slug' => 'es-kelapa-muda',
                'deskripsi' => 'Kelapa muda segar yang disajikan dingin dengan es.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Kopi Sunda',
                'slug' => 'kopi-sunda-tasikmalaya',
                'deskripsi' => 'Kopi dengan cita rasa khas biji kopi Jawa Barat.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Bandrek',
                'slug' => 'bandrek-tasikmalaya',
                'deskripsi' => 'Minuman tradisional hangat berbahan jahe dan gula merah.',
                'kategori' => 'Minuman Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Bajigur',
                'slug' => 'bajigur-tasikmalaya',
                'deskripsi' => 'Minuman tradisional Sunda dengan rasa manis dan hangat.',
                'kategori' => 'Minuman Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Keripik Singkong',
                'slug' => 'keripik-singkong-tasikmalaya',
                'deskripsi' => 'Keripik singkong renyah dengan berbagai pilihan rasa.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Keripik Pisang',
                'slug' => 'keripik-pisang-tasikmalaya',
                'deskripsi' => 'Keripik pisang renyah sebagai oleh-oleh khas daerah.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Kerupuk Aci',
                'slug' => 'kerupuk-aci-tasikmalaya',
                'deskripsi' => 'Kerupuk berbahan aci yang renyah dan cocok sebagai camilan.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Kerupuk Kulit',
                'slug' => 'kerupuk-kulit-tasikmalaya',
                'deskripsi' => 'Kerupuk kulit dengan tekstur renyah dan rasa gurih.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Tahu Sumedang',
                'slug' => 'tahu-sumedang-tasikmalaya',
                'deskripsi' => 'Tahu goreng yang populer sebagai jajanan di Jawa Barat.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Nasi Kuning',
                'slug' => 'nasi-kuning-tasikmalaya',
                'deskripsi' => 'Nasi kuning gurih dengan berbagai lauk pendamping.',
                'kategori' => 'Sarapan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Lontong Sayur',
                'slug' => 'lontong-sayur-tasikmalaya',
                'deskripsi' => 'Lontong dengan kuah sayur gurih dan berbagai pelengkap.',
                'kategori' => 'Sarapan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
            ],

            [
                'nama' => 'Mie Goreng Sunda',
                'slug' => 'mie-goreng-sunda',
                'deskripsi' => 'Mie goreng dengan bumbu gurih dan tambahan sayuran serta lauk.',
                'kategori' => 'Mie',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Kwetiau Goreng',
                'slug' => 'kwetiau-goreng-tasikmalaya',
                'deskripsi' => 'Kwetiau goreng dengan bumbu gurih dan berbagai pilihan topping.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Ayam Penyet',
                'slug' => 'ayam-penyet-tasikmalaya',
                'deskripsi' => 'Ayam goreng yang dipenyet bersama sambal pedas dan lalapan.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 18000,
            ],

            [
                'nama' => 'Lele Goreng',
                'slug' => 'lele-goreng-tasikmalaya',
                'deskripsi' => 'Lele goreng renyah dengan sambal dan lalapan.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
            ],

            [
                'nama' => 'Soto Ayam',
                'slug' => 'soto-ayam-tasikmalaya',
                'deskripsi' => 'Soto ayam berkuah gurih dengan suwiran ayam dan pelengkap.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Nasi Goreng Kampung',
                'slug' => 'nasi-goreng-kampung-tasikmalaya',
                'deskripsi' => 'Nasi goreng sederhana dengan bumbu gurih dan aroma khas masakan rumahan.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
            ],

            [
                'nama' => 'Pisang Molen',
                'slug' => 'pisang-molen-tasikmalaya',
                'deskripsi' => 'Pisang yang dibalut adonan tipis kemudian digoreng hingga renyah.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 7000,
            ],

            [
                'nama' => 'Donat Kampung',
                'slug' => 'donat-kampung-tasikmalaya',
                'deskripsi' => 'Donat sederhana dengan tekstur lembut dan berbagai pilihan topping.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Putu Ayu',
                'slug' => 'putu-ayu-tasikmalaya',
                'deskripsi' => 'Kue tradisional bertekstur lembut dengan aroma pandan dan kelapa.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Klepon',
                'slug' => 'klepon-tasikmalaya',
                'deskripsi' => 'Kue tradisional berbentuk bola dengan isian gula merah dan balutan kelapa.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Es Dawet',
                'slug' => 'es-dawet-tasikmalaya',
                'deskripsi' => 'Minuman tradisional dingin dengan dawet, santan dan gula merah.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
            ],

            [
                'nama' => 'Es Teh Manis',
                'slug' => 'es-teh-manis-tasikmalaya',
                'deskripsi' => 'Minuman sederhana dan menyegarkan yang cocok menemani berbagai hidangan.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
            ],

            [
                'nama' => 'Wedang Jahe',
                'slug' => 'wedang-jahe-tasikmalaya',
                'deskripsi' => 'Minuman hangat berbahan jahe dengan rasa pedas dan manis.',
                'kategori' => 'Minuman Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 7000,
            ],

        ];

        foreach ($data as $item) {
            $item['foto'] = $this->fotoUntuk($item['nama'], $item['slug']);

            Kuliner::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $this->command->info(
            'Data kuliner berhasil dimasukkan: ' . count($data) . ' data (foto disesuaikan dengan nama makanan).'
        );
    }
}