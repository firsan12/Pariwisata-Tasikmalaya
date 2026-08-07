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
        $table->foreignId('destinasi_id')->nullable()->after('id')
            ->constrained('destinasi')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('atraksi', function (Blueprint $table) {
        $table->dropForeign(['destinasi_id']);
        $table->dropColumn('destinasi_id');

        });
    }
};
