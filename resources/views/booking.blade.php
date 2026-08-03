<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking',
        'destinasi_id',
        'user_id',
        'nama_pemesan',
        'email_pemesan',
        'telepon_pemesan',
        'tanggal_kunjungan',
        'jumlah_dewasa',
        'jumlah_anak',
        'jumlah_asing',
        'total_harga',
        'status',
    ];

    protected $casts = [
    'tanggal_kunjungan' => 'date',
    'dibayar_at'        => 'datetime',
];

    // Supaya route model binding pakai kode_booking, bukan id
    public function getRouteKeyName(): string
    {
        return 'kode_booking';
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    public static function generateKodeBooking(): string
    {
        do {
            $kode = 'BOOK-' . strtoupper(uniqid());
        } while (self::where('kode_booking', $kode)->exists());

        return $kode;
    }
}