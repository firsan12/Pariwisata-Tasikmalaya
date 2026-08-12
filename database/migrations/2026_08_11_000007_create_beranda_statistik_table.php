<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kartu statistik animasi (hitung naik) di section "STATISTIK" pada
     * beranda.blade.php. Sebelumnya hardcode 4 kartu dengan atribut
     * data-jt-count / data-jt-decimal / data-jt-suffix.
     */
    public function up(): void
    {
        Schema::create('beranda_statistik', function (Blueprint $table) {
            $table->id();
            $table->string('ikon', 50);
            $table->decimal('nilai', 10, 2);
            $table->unsignedTinyInteger('desimal')->default(0);
            $table->string('suffix', 10)->nullable();
            $table->string('label', 100);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beranda_statistik');
    }
};
