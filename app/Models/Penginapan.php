<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'alamat', 'foto', 'harga_per_malam', 'rating'];
}

