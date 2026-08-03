<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking', 'destinasi_id',
        'nama_pemesan', 'email_pemesan', 'wa_pemesan', 'tanggal_kunjungan',
        'jumlah_dewasa', 'jumlah_anak', 'jumlah_asing',
        'subtotal_dewasa', 'subtotal_anak', 'subtotal_asing', 'total_harga',
        'metode_pembayaran', 'bank_kode', 'ewallet_kode', 'kode_unik', 'total_transfer',
        'status', 'dibayar_at',
    ];

    protected $casts = [
    'tanggal_kunjungan' => 'date',
    'dibayar_at'        => 'datetime',
    'dibatalkan_at'     => 'datetime',
];
    public function getRouteKeyName(): string
    {
        return 'kode_booking';
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    public function getTotalTiketAttribute(): int
    {
        return $this->jumlah_dewasa + $this->jumlah_anak + $this->jumlah_asing;
    }

    public static function generateKodeBooking(): string
    {
        do {
            $kode = 'WT-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 6));
        } while (self::where('kode_booking', $kode)->exists());

        return $kode;
    }

    protected $appends = [
    'harga_termurah',
];

}
