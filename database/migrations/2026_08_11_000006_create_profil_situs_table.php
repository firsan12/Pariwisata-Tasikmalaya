<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel singleton (biasanya cuma 1 baris) untuk menampung teks & info
     * yang sebelumnya hardcode di beranda.blade.php, tentang.blade.php,
     * dan kontak.blade.php: nama situs, deskripsi hero, teks trust badge,
     * konten section "Tentang", serta info kontak (email, whatsapp, alamat,
     * jam operasional).
     */
    public function up(): void
    {
        Schema::create('profil_situs', function (Blueprint $table) {
            $table->id();

            // Beranda - Hero
            $table->string('nama_situs', 150)->default('Wisata Tasikmalaya');
            $table->text('hero_deskripsi')->nullable();
            $table->string('hero_trust_destinasi', 100)->nullable();
            $table->string('hero_trust_wisatawan', 150)->nullable();

            // Tentang - Hero & konten
            $table->text('tentang_hero_deskripsi')->nullable();
            $table->string('tentang_gambar_hero', 255)->nullable();
            $table->string('tentang_judul', 255)->nullable();
            $table->text('tentang_intro')->nullable();
            $table->string('tentang_gambar', 255)->nullable();
            $table->string('tentang_sublabel', 150)->nullable();
            $table->string('tentang_subjudul', 255)->nullable();
            $table->text('tentang_deskripsi_1')->nullable();
            $table->text('tentang_deskripsi_2')->nullable();

            // Kontak
            $table->string('kontak_judul', 255)->nullable();
            $table->text('kontak_intro')->nullable();
            $table->string('kontak_email', 150)->nullable();
            $table->string('kontak_whatsapp', 20)->nullable();
            $table->string('kontak_whatsapp_display', 30)->nullable();
            $table->string('kontak_alamat', 255)->nullable();
            $table->string('kontak_alamat_maps_url', 500)->nullable();
            $table->string('kontak_jam_operasional', 150)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_situs');
    }
};
