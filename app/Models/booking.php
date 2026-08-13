<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'kode_booking', 'destinasi_id',
        'nama_pemesan', 'email_pemesan', 'wa_pemesan', 'tanggal_kunjungan',
        'jumlah_dewasa', 'jumlah_anak', 'jumlah_asing',
        'subtotal_dewasa', 'subtotal_anak', 'subtotal_asing', 'total_harga',
        'metode_pembayaran', 'bank_kode', 'ewallet_kode', 'kode_unik', 'total_transfer',
        'status', 'dibayar_at',
        'klaim_bayar_at', 'bukti_transfer_path',
        'verified_by', 'verified_ip', 'alasan_ditolak',
        'dibatalkan_at',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'dibayar_at'        => 'datetime',
        'dibatalkan_at'     => 'datetime',
        'klaim_bayar_at'    => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'kode_booking';
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    /**
     * User pemilik booking ini (bisa null kalau dibuat sebagai tamu / guest checkout,
     * atau booking lama sebelum kolom user_id ada).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admin yang melakukan verifikasi pembayaran (approve/reject).
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
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

    /**
     * Cek apakah booking pending ini sudah lewat batas waktu pembayaran.
     */
    public function sudahKedaluwarsa(int $batasMenit = 60): bool
    {
        return $this->status === 'pending'
            && $this->created_at->addMinutes($batasMenit)->isPast();
    }

    /**
     * Batalkan booking & kembalikan kuota destinasi terkait.
     * SATU-SATUNYA tempat yang boleh melakukan ini.
     */
    public function batalkanDanKembalikanKuota(): void
    {
        \Illuminate\Support\Facades\DB::transaction(function () {
            $destinasi = $this->destinasi()->lockForUpdate()->first();

            if ($destinasi) {
                $destinasi->decrement('terisi_dewasa', $this->jumlah_dewasa);
                $destinasi->decrement('terisi_anak', $this->jumlah_anak);
                $destinasi->decrement('terisi_asing', $this->jumlah_asing);
            }

            $this->update([
                'status'        => 'dibatalkan',
                'dibatalkan_at' => now(),
            ]);
        });
    }
}