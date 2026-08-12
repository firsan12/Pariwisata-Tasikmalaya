<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Kuliner extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'alamat',
        'foto',
        'harga_mulai',
        'kategori', // ← tambahkan ini
    ];

   // app/Models/Kuliner.php
protected function fotoUrl(): Attribute
{
    return Attribute::make(
        get: function () {
            if (!$this->foto) {
                return null;
            }

            // Kalau sudah URL lengkap (http/https), pakai langsung
            if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                return $this->foto;
            }

            // Kalau path lokal, cek file benar-benar ada di storage
            return \Storage::disk('public')->exists($this->foto)
                ? asset('storage/'.$this->foto)
                : null;
        },
    );
}
}