<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = [
        'destinasi_id', 'nama_pengguna', 'email_pengguna',
        'rating', 'komentar', 'status', 'balasan_admin', 'dibalas_pada',
        
    ];

    protected $casts = [
        'dibalas_pada' => 'datetime',
    ];

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeTerbaru($query)
    {
        return $query->latest();
    }
}