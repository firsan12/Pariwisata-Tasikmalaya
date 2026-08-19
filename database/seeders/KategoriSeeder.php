<?php
 
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Kategori;
 
class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriData = ['Alam', 'Sejarah', 'Budaya'];
 
        foreach ($kategoriData as $nama) {
            Kategori::updateOrCreate(['nama_kategori' => $nama], ['nama_kategori' => $nama]);
        }
    }
}
