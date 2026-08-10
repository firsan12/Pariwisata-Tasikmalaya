<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            // Ganti 'destinasi' di bawah ini dengan nama tabel destinasi yang SEBENARNYA
            // (cek dengan php artisan migrate:status lalu buka file migration destinasi kamu)
            $table->foreignId('destinasi_id')->nullable()->constrained('destinasi')->nullOnDelete();
            $table->string('judul');
            $table->string('foto');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};