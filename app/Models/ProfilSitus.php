<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSitus extends Model
{
    protected $table = 'profil_situs';

    protected $fillable = [
        'nama_situs',
        'hero_deskripsi',
        'hero_trust_destinasi',
        'hero_trust_wisatawan',
        'tentang_hero_deskripsi',
        'tentang_gambar_hero',
        'tentang_judul',
        'tentang_intro',
        'tentang_gambar',
        'tentang_sublabel',
        'tentang_subjudul',
        'tentang_deskripsi_1',
        'tentang_deskripsi_2',
        'kontak_judul',
        'kontak_intro',
        'kontak_email',
        'kontak_whatsapp',
        'kontak_whatsapp_display',
        'kontak_alamat',
        'kontak_alamat_maps_url',
        'kontak_jam_operasional',
        'rekening_seabank_nomor',
        'rekening_seabank_nama',
        'ewallet_tujuan_nomor',
    ];

    /**
     * Tabel ini singleton (idealnya cuma 1 baris). Helper ini mengambil
     * baris pertama, atau instance kosong (pakai nilai default kolom)
     * kalau datanya belum di-seed — supaya view tetap aman dipakai
     * dengan operator "??" tanpa perlu cek null di banyak tempat.
     */
    public static function current(): self
    {
        return static::first() ?? new static();
    }
}
