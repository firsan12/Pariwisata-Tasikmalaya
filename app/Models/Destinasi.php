<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Destinasi extends Model
{
    use HasFactory;

    protected $table = 'destinasi';

    protected $fillable = [
    'nama',
    'deskripsi',
    'gambar',
    'jam_buka',
    'jam_tutup',
    'lokasi',

    'harga_dewasa',
    'harga_anak',
    'harga_asing',

    'kuota_dewasa',
    'kuota_anak',
    'kuota_asing',

    'terisi_dewasa',
    'terisi_anak',
    'terisi_asing',
];


    public function bookings()
{
    return $this->hasMany(Booking::class);
}

public function ulasan()
{
    return $this->hasMany(Ulasan::class, 'destinasi_id');
}

  public function getIsBukaAttribute(): bool
{
    $sekarang = Carbon::now('Asia/Jakarta');
    $jamBuka  = Carbon::parse($this->jam_buka, 'Asia/Jakarta')->setDate($sekarang->year, $sekarang->month, $sekarang->day);
    $jamTutup = Carbon::parse($this->jam_tutup, 'Asia/Jakarta')->setDate($sekarang->year, $sekarang->month, $sekarang->day);

    // Kasus jam tutup lewat tengah malam (misal buka 20:00, tutup 02:00)
    if ($jamTutup->lessThan($jamBuka)) {
        $jamTutup->addDay();
    }

    return $sekarang->between($jamBuka, $jamTutup);
}

    public function getHargaTermurahAttribute(): int
    {
        $harga = array_filter([$this->harga_dewasa, $this->harga_anak, $this->harga_asing], fn ($h) => $h > 0);
        return $harga ? min($harga) : 0;
    }

    public function getSisaDewasaAttribute(): int { return max(0, $this->kuota_dewasa - $this->terisi_dewasa); }
    public function getSisaAnakAttribute(): int   { return max(0, $this->kuota_anak - $this->terisi_anak); }
    public function getSisaAsingAttribute(): int  { return max(0, $this->kuota_asing - $this->terisi_asing); }

    public function getKuotaTotalAttribute(): int  { return $this->kuota_dewasa + $this->kuota_anak + $this->kuota_asing; }
    public function getTerisiTotalAttribute(): int { return $this->terisi_dewasa + $this->terisi_anak + $this->terisi_asing; }
    public function getSisaSlotAttribute(): int    { return max(0, $this->kuota_total - $this->terisi_total); }

    public function getPersenTerisiAttribute(): int
    {
        return $this->kuota_total > 0
            ? (int) round(($this->terisi_total / $this->kuota_total) * 100)
            : 0;
    }

    public function getKetSlotAttribute(): string
    {
        if ($this->sisa_slot <= 0) return 'habis';
        if ($this->persen_terisi >= 80) return 'hampir_habis';
        return 'tersedia';
    }

    
}

