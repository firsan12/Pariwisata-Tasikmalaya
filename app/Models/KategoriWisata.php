<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriWisata extends Model
{
    protected $table = 'kategori_wisata';

    protected $fillable = ['emoji', 'nama', 'urutan'];

    public $timestamps = true;
}
