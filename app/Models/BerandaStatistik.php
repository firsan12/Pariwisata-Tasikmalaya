<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerandaStatistik extends Model
{
    protected $table = 'beranda_statistik';

    protected $fillable = ['ikon', 'nilai', 'desimal', 'suffix', 'label', 'urutan'];
}
