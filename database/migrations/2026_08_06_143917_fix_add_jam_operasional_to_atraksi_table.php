<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('atraksi', 'jam_operasional')) {
            Schema::table('atraksi', function (Blueprint $table) {
                $table->string('jam_operasional')->nullable()->after('gambar');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('atraksi', 'jam_operasional')) {
            Schema::table('atraksi', function (Blueprint $table) {
                $table->dropColumn('jam_operasional');
            });
        }
    }
};