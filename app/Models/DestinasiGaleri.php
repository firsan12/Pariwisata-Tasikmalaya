<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinasiGaleri extends Model
{
    use HasFactory;

    protected $table = 'destinasi_galeri';

    protected $fillable = [
        'destinasi_id',
        'gambar',
        'urutan',
    ];

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }
}
