<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kuliner;

class KulinerSeeder extends Seeder
{
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
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Nasi Cikur',
                'slug' => 'nasi-cikur',
                'deskripsi' => 'Olahan nasi dengan aroma khas kencur yang menjadi salah satu kuliner tradisional Sunda.',
                'kategori' => 'Makanan Khas',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Kupat Tahu Tasikmalaya',
                'slug' => 'kupat-tahu-tasikmalaya',
                'deskripsi' => 'Kupat tahu dengan perpaduan ketupat, tahu, tauge dan bumbu kacang yang gurih.',
                'kategori' => 'Makanan Tradisional',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Soto Tasikmalaya',
                'slug' => 'soto-tasikmalaya',
                'deskripsi' => 'Sajian soto hangat dengan kuah gurih dan isian yang cocok dinikmati kapan saja.',
                'kategori' => 'Makanan',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Bubur Ayam Tasikmalaya',
                'slug' => 'bubur-ayam-tasikmalaya',
                'deskripsi' => 'Bubur ayam dengan suwiran ayam, cakwe, daun bawang dan pelengkap lainnya.',
                'kategori' => 'Sarapan',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Bakso Tasik',
                'slug' => 'bakso-tasik',
                'deskripsi' => 'Bakso dengan kuah gurih, mie, sayuran dan pelengkap yang cocok disantap siang maupun malam.',
                'kategori' => 'Makanan',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1601050690117-94f5f6fa8bd7?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Mie Bakso',
                'slug' => 'mie-bakso-tasikmalaya',
                'deskripsi' => 'Perpaduan mie dan bakso dengan kuah kaldu gurih serta berbagai pelengkap.',
                'kategori' => 'Mie & Bakso',
                'alamat' => 'Kota Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Sate Maranggi',
                'slug' => 'sate-maranggi-tasikmalaya',
                'deskripsi' => 'Sate berbumbu khas dengan aroma bakaran yang kuat dan cita rasa gurih manis.',
                'kategori' => 'Sate',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 25000,
                'foto' => 'https://images.unsplash.com/photo-1529563021893-cc83c992d75d?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Nasi Liwet Sunda',
                'slug' => 'nasi-liwet-sunda',
                'deskripsi' => 'Nasi liwet gurih khas Sunda dengan lauk, lalapan dan sambal.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 20000,
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Ayam Goreng Sunda',
                'slug' => 'ayam-goreng-sunda',
                'deskripsi' => 'Ayam goreng berbumbu gurih dengan sambal dan lalapan segar.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 18000,
                'foto' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Gurame Bakar',
                'slug' => 'gurame-bakar-tasikmalaya',
                'deskripsi' => 'Ikan gurame bakar dengan bumbu khas Sunda dan sambal pendamping.',
                'kategori' => 'Seafood',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 35000,
                'foto' => 'https://images.unsplash.com/photo-1544943910-4c1dc44aab44?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Gurame Goreng',
                'slug' => 'gurame-goreng',
                'deskripsi' => 'Gurame goreng renyah dengan sambal dan lalapan.',
                'kategori' => 'Seafood',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 35000,
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Karedok',
                'slug' => 'karedok-tasikmalaya',
                'deskripsi' => 'Sayuran segar dengan bumbu kacang khas Sunda.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Lotek',
                'slug' => 'lotek-tasikmalaya',
                'deskripsi' => 'Aneka sayuran dengan bumbu kacang gurih dan pelengkap tradisional.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Pecel Sunda',
                'slug' => 'pecel-sunda',
                'deskripsi' => 'Sayuran rebus dengan sambal kacang dan pelengkap khas Sunda.',
                'kategori' => 'Makanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Tahu Bulat',
                'slug' => 'tahu-bulat-tasikmalaya',
                'deskripsi' => 'Jajanan tahu berbentuk bulat yang digoreng dan disantap hangat.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Cireng',
                'slug' => 'cireng-tasikmalaya',
                'deskripsi' => 'Jajanan berbahan tepung tapioka dengan tekstur kenyal dan gurih.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1625398407796-82650a8c0e7f?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Cilok',
                'slug' => 'cilok-tasikmalaya',
                'deskripsi' => 'Jajanan aci berbentuk bulat dengan saus kacang dan berbagai pilihan bumbu.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1601050690117-94f5f6fa8bd7?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Combro',
                'slug' => 'combro-tasikmalaya',
                'deskripsi' => 'Gorengan berbahan singkong dengan isian oncom pedas gurih.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 3000,
                'foto' => 'https://images.unsplash.com/photo-1601050690117-94f5f6fa8bd7?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Misro',
                'slug' => 'misro-tasikmalaya',
                'deskripsi' => 'Jajanan singkong goreng dengan isian gula merah yang manis.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 3000,
                'foto' => 'https://images.unsplash.com/photo-1601050690117-94f5f6fa8bd7?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Opak',
                'slug' => 'opak-tasikmalaya',
                'deskripsi' => 'Kerupuk tradisional berbahan singkong atau beras dengan tekstur renyah.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1599599810694-57a4e7e2d6f8?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Rangginang',
                'slug' => 'rangginang-tasikmalaya',
                'deskripsi' => 'Kerupuk tradisional dari beras ketan yang digoreng hingga renyah.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Sale Pisang',
                'slug' => 'sale-pisang-tasikmalaya',
                'deskripsi' => 'Olahan pisang yang dikeringkan dan memiliki cita rasa manis khas.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Wajit',
                'slug' => 'wajit-tasikmalaya',
                'deskripsi' => 'Jajanan tradisional berbahan ketan, gula merah dan santan dengan rasa manis legit.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Peuyeum Ketan',
                'slug' => 'peuyeum-ketan',
                'deskripsi' => 'Olahan ketan fermentasi dengan rasa manis dan sedikit asam.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Sambal Goang',
                'slug' => 'sambal-goang',
                'deskripsi' => 'Sambal khas Sunda yang sederhana namun memiliki rasa pedas segar.',
                'kategori' => 'Sambal',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Nasi Timbel',
                'slug' => 'nasi-timbel-tasikmalaya',
                'deskripsi' => 'Nasi hangat yang dibungkus daun pisang dan disajikan dengan lauk serta lalapan.',
                'kategori' => 'Makanan Sunda',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 18000,
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Nasi Bakar',
                'slug' => 'nasi-bakar-tasikmalaya',
                'deskripsi' => 'Nasi berbumbu yang dibungkus daun pisang kemudian dibakar hingga harum.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Seblak',
                'slug' => 'seblak-tasikmalaya',
                'deskripsi' => 'Jajanan bercita rasa pedas dengan kerupuk basah dan berbagai pilihan isian.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1601050690117-94f5f6fa8bd7?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Mie Jebew',
                'slug' => 'mie-jebew-tasikmalaya',
                'deskripsi' => 'Olahan mie pedas dengan bumbu kuat dan pilihan topping.',
                'kategori' => 'Mie',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Mie Kocok',
                'slug' => 'mie-kocok-tasikmalaya',
                'deskripsi' => 'Mie dengan kuah kaldu gurih dan pelengkap yang menghangatkan.',
                'kategori' => 'Mie',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Batagor',
                'slug' => 'batagor-tasikmalaya',
                'deskripsi' => 'Olahan tahu dan ikan goreng yang disajikan dengan bumbu kacang.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Siomay',
                'slug' => 'siomay-tasikmalaya',
                'deskripsi' => 'Siomay dengan tahu, kentang, kol dan bumbu kacang.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Tahu Gejrot',
                'slug' => 'tahu-gejrot',
                'deskripsi' => 'Potongan tahu dengan kuah gula merah, bawang dan cabai.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Pisang Goreng',
                'slug' => 'pisang-goreng-tasikmalaya',
                'deskripsi' => 'Pisang goreng renyah yang cocok sebagai teman minum kopi atau teh.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1587132137056-bfbf0166836e?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Surabi',
                'slug' => 'surabi-tasikmalaya',
                'deskripsi' => 'Kue tradisional berbahan tepung beras dengan pilihan rasa manis atau gurih.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 7000,
                'foto' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Colenak',
                'slug' => 'colenak-tasikmalaya',
                'deskripsi' => 'Peuyeum bakar yang disajikan dengan saus gula merah dan kelapa.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Es Cendol',
                'slug' => 'es-cendol-tasikmalaya',
                'deskripsi' => 'Minuman tradisional dengan cendol, santan dan gula merah.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Es Campur',
                'slug' => 'es-campur-tasikmalaya',
                'deskripsi' => 'Minuman dingin dengan campuran buah, agar-agar, sirup dan es.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1490474418585-ba9bad8fd0ea?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Es Kelapa Muda',
                'slug' => 'es-kelapa-muda',
                'deskripsi' => 'Kelapa muda segar yang disajikan dingin dengan es.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Kopi Sunda',
                'slug' => 'kopi-sunda-tasikmalaya',
                'deskripsi' => 'Kopi dengan cita rasa khas biji kopi Jawa Barat.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Bandrek',
                'slug' => 'bandrek-tasikmalaya',
                'deskripsi' => 'Minuman tradisional hangat berbahan jahe dan gula merah.',
                'kategori' => 'Minuman Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Bajigur',
                'slug' => 'bajigur-tasikmalaya',
                'deskripsi' => 'Minuman tradisional Sunda dengan rasa manis dan hangat.',
                'kategori' => 'Minuman Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Keripik Singkong',
                'slug' => 'keripik-singkong-tasikmalaya',
                'deskripsi' => 'Keripik singkong renyah dengan berbagai pilihan rasa.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1621939514649-280e2aa1f2f5?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Keripik Pisang',
                'slug' => 'keripik-pisang-tasikmalaya',
                'deskripsi' => 'Keripik pisang renyah sebagai oleh-oleh khas daerah.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Kerupuk Aci',
                'slug' => 'kerupuk-aci-tasikmalaya',
                'deskripsi' => 'Kerupuk berbahan aci yang renyah dan cocok sebagai camilan.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1599599810694-57a4e7e2d6f8?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Kerupuk Kulit',
                'slug' => 'kerupuk-kulit-tasikmalaya',
                'deskripsi' => 'Kerupuk kulit dengan tekstur renyah dan rasa gurih.',
                'kategori' => 'Oleh-Oleh',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Tahu Sumedang',
                'slug' => 'tahu-sumedang-tasikmalaya',
                'deskripsi' => 'Tahu goreng yang populer sebagai jajanan di Jawa Barat.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Nasi Kuning',
                'slug' => 'nasi-kuning-tasikmalaya',
                'deskripsi' => 'Nasi kuning gurih dengan berbagai lauk pendamping.',
                'kategori' => 'Sarapan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Lontong Sayur',
                'slug' => 'lontong-sayur-tasikmalaya',
                'deskripsi' => 'Lontong dengan kuah sayur gurih dan berbagai pelengkap.',
                'kategori' => 'Sarapan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 10000,
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Mie Goreng Sunda',
                'slug' => 'mie-goreng-sunda',
                'deskripsi' => 'Mie goreng dengan bumbu gurih dan tambahan sayuran serta lauk.',
                'kategori' => 'Mie',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Kwetiau Goreng',
                'slug' => 'kwetiau-goreng-tasikmalaya',
                'deskripsi' => 'Kwetiau goreng dengan bumbu gurih dan berbagai pilihan topping.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Ayam Penyet',
                'slug' => 'ayam-penyet-tasikmalaya',
                'deskripsi' => 'Ayam goreng yang dipenyet bersama sambal pedas dan lalapan.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 18000,
                'foto' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Lele Goreng',
                'slug' => 'lele-goreng-tasikmalaya',
                'deskripsi' => 'Lele goreng renyah dengan sambal dan lalapan.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 15000,
                'foto' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Soto Ayam',
                'slug' => 'soto-ayam-tasikmalaya',
                'deskripsi' => 'Soto ayam berkuah gurih dengan suwiran ayam dan pelengkap.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Nasi Goreng Kampung',
                'slug' => 'nasi-goreng-kampung-tasikmalaya',
                'deskripsi' => 'Nasi goreng sederhana dengan bumbu gurih dan aroma khas masakan rumahan.',
                'kategori' => 'Makanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 12000,
                'foto' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Pisang Molen',
                'slug' => 'pisang-molen-tasikmalaya',
                'deskripsi' => 'Pisang yang dibalut adonan tipis kemudian digoreng hingga renyah.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 7000,
                'foto' => 'https://images.unsplash.com/photo-1587132137056-bfbf0166836e?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Donat Kampung',
                'slug' => 'donat-kampung-tasikmalaya',
                'deskripsi' => 'Donat sederhana dengan tekstur lembut dan berbagai pilihan topping.',
                'kategori' => 'Jajanan',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Putu Ayu',
                'slug' => 'putu-ayu-tasikmalaya',
                'deskripsi' => 'Kue tradisional bertekstur lembut dengan aroma pandan dan kelapa.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Klepon',
                'slug' => 'klepon-tasikmalaya',
                'deskripsi' => 'Kue tradisional berbentuk bola dengan isian gula merah dan balutan kelapa.',
                'kategori' => 'Jajanan Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Es Dawet',
                'slug' => 'es-dawet-tasikmalaya',
                'deskripsi' => 'Minuman tradisional dingin dengan dawet, santan dan gula merah.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 8000,
                'foto' => 'https://images.unsplash.com/photo-1544145945-f90425340c7e?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Es Teh Manis',
                'slug' => 'es-teh-manis-tasikmalaya',
                'deskripsi' => 'Minuman sederhana dan menyegarkan yang cocok menemani berbagai hidangan.',
                'kategori' => 'Minuman',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 5000,
                'foto' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=1600&q=90',
            ],

            [
                'nama' => 'Wedang Jahe',
                'slug' => 'wedang-jahe-tasikmalaya',
                'deskripsi' => 'Minuman hangat berbahan jahe dengan rasa pedas dan manis.',
                'kategori' => 'Minuman Tradisional',
                'alamat' => 'Tasikmalaya',
                'harga_mulai' => 7000,
                'foto' => 'https://images.unsplash.com/photo-1597318181409-cf64d0b5d8a2?auto=format&fit=crop&w=1600&q=90',
            ],

        ];

        foreach ($data as $item) {
            Kuliner::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $this->command->info(
            'Data kuliner berhasil dimasukkan: ' . count($data) . ' data.'
        );
    }
}