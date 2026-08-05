<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atraksi extends Model
{
    use HasFactory;
    protected $table = 'atraksi';
    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'harga',
        'gambar',
        'jam_operasional',
    ];

}