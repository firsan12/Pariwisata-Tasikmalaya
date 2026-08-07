<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atraksi extends Model
{
    use HasFactory;
    protected $table = 'atraksi';
    protected $fillable = [
        'destinasi_id',
        'nama',
        'deskripsi',
        'kategori',
        'harga',
        'gambar',
        'jam_operasional',
    ];

    public function destinasi()
{
    return $this->belongsTo(Destinasi::class);
}

}