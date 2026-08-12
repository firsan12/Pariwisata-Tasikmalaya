<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Nomor rekening & e-wallet tujuan pembayaran — sebelumnya hardcode
     * berulang di pesan-tiket.blade.php dan pembayaran.blade.php
     * ($rekening_seabank, $nomor_ewallet_tujuan). Dipisah jadi migration
     * baru (bukan edit migration profil_situs yang sudah ada) supaya aman
     * dipakai walau migration sebelumnya sudah pernah dijalankan.
     */
    public function up(): void
    {
        Schema::table('profil_situs', function (Blueprint $table) {
            $table->string('rekening_seabank_nomor', 50)->nullable()->after('kontak_jam_operasional');
            $table->string('rekening_seabank_nama', 150)->nullable()->after('rekening_seabank_nomor');
            $table->string('ewallet_tujuan_nomor', 30)->nullable()->after('rekening_seabank_nama');
        });
    }

    public function down(): void
    {
        Schema::table('profil_situs', function (Blueprint $table) {
            $table->dropColumn(['rekening_seabank_nomor', 'rekening_seabank_nama', 'ewallet_tujuan_nomor']);
        });
    }
};
