<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daftar poin keunggulan di section "MENGAPA MEMILIH KAMI" pada
     * beranda.blade.php. Sebelumnya hardcode 6 item (ikon + judul).
     */
    public function up(): void
    {
        Schema::create('keunggulan', function (Blueprint $table) {
            $table->id();
            $table->string('ikon', 50);
            $table->string('judul', 100);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keunggulan');
    }
};
