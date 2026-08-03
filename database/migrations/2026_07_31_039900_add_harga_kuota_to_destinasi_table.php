<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $table->integer('harga_dewasa')->default(0);
            $table->integer('harga_anak')->default(0);
            $table->integer('harga_asing')->default(0);

            $table->integer('kuota_dewasa')->default(0);
            $table->integer('kuota_anak')->default(0);
            $table->integer('kuota_asing')->default(0);

            $table->integer('terisi_dewasa')->default(0);
            $table->integer('terisi_anak')->default(0);
            $table->integer('terisi_asing')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $table->dropColumn([
                'harga_dewasa',
                'harga_anak',
                'harga_asing',
                'kuota_dewasa',
                'kuota_anak',
                'kuota_asing',
                'terisi_dewasa',
                'terisi_anak',
                'terisi_asing',
            ]);
        });
    }
};
