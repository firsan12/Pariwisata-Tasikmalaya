<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $fillable = [
        'booking_id', 'destinasi_id',
        'jumlah_dewasa', 'jumlah_anak', 'jumlah_asing',
        'harga_dewasa', 'harga_anak', 'harga_asing',
        'subtotal_dewasa', 'subtotal_anak', 'subtotal_asing',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    public function getTotalTiketAttribute(): int
    {
        return $this->jumlah_dewasa + $this->jumlah_anak + $this->jumlah_asing;
    }

    public function getSubtotalAttribute(): int
    {
        return $this->subtotal_dewasa + $this->subtotal_anak + $this->subtotal_asing;
    }
}