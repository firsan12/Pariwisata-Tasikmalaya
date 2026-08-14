<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Kuliner extends Model
{
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'alamat',
        'foto',
        'harga_mulai',
        'kategori',
    ];

    /**
     * Accessor foto_url — 1 kuliner = 1 foto yang sesuai nama.
     *
     * Urutan prioritas:
     * 1. foto sudah berupa URL penuh (http/https) -> pakai langsung
     * 2. foto lokal hasil seeder di public/images/kuliner/{slug}.jpg
     *    -> dipakai kalau file-nya sudah benar-benar ada
     * 3. foto hasil upload lewat form admin (Storage disk 'public')
     * 4. belum ada file sama sekali -> placeholder otomatis berisi
     *    NAMA kuliner (sementara, sampai foto asli di-upload)
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $foto = $this->foto;

                if ($foto && (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://'))) {
                    return $foto;
                }

                if ($foto && file_exists(public_path($foto))) {
                    return asset($foto);
                }

                if ($foto && Storage::disk('public')->exists($foto)) {
                    return asset('storage/' . $foto);
                }

                if (!$this->nama) {
                    return null;
                }

                // Placeholder sementara berisi nama kuliner (bukan foto asli)
                return 'https://placehold.co/800x600/eef5fb/3b6ea5?font=poppins&text='
                    . urlencode($this->nama);
            },
        );
    }
}