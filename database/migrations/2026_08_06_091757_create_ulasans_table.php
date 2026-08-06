<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();

            // Relasi ke destinasi yang diulas
            $table->foreignId('destinasi_id')
                  ->constrained('destinasi')
                  ->onDelete('cascade');

            // Kalau situs punya sistem login user, aktifkan baris ini dan
            // hapus kolom nama_pengguna manual di bawah:
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('nama_pengguna');           // nama yang mengulas (tanpa login)
            $table->string('email_pengguna')->nullable();

            $table->unsignedTinyInteger('rating');      // 1 - 5
            $table->text('komentar');

            // Moderasi sederhana: ulasan baru masuk 'pending' dulu,
            // admin approve sebelum tampil publik. Set default 'approved'
            // kalau Anda tidak butuh moderasi.
            $table->enum('status', ['pending', 'approved', 'ditolak'])
                  ->default('pending');

            // Balasan admin/pengelola untuk ulasan tsb (opsional)
            $table->text('balasan_admin')->nullable();
            $table->timestamp('dibalas_pada')->nullable();

            $table->timestamps();

            $table->index(['destinasi_id', 'status']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};