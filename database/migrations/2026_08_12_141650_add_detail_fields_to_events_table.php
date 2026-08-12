<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('promo');
            $table->string('gambar')->nullable()->after('deskripsi');
            $table->date('tanggal_mulai')->nullable()->after('gambar');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'gambar', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }
};