<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visi_misi', function (Blueprint $table) {
            $table->id();
            $table->string('ikon', 50);
            $table->string('judul', 100);
            $table->text('isi');
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visi_misi');
    }
};
