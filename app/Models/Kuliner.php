<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuliner extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'alamat', 'foto', 'harga_mulai'];
}