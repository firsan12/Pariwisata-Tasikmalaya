<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuliners', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('nama');
            $table->string('kategori')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('kuliners', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'kategori']);
        });
    }
};
