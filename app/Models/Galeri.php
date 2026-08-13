<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'destinasi_id', 'judul', 'foto', 'keterangan',
    ];

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }
}