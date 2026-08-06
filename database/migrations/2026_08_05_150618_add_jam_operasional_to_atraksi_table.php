<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('atraksi', function (Blueprint $table) {
        $table->string('jam_operasional')->nullable()->after('gambar');
    });
}

public function down(): void
{
    Schema::table('atraksi', function (Blueprint $table) {
        $table->dropColumn('jam_operasional');
    });

    }
};
