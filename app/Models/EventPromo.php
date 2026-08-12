<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPromo extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'judul',
        'promo',
        'urutan',
        'deskripsi',
        'gambar',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}