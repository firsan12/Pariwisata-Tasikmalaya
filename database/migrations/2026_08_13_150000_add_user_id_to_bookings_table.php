<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom user_id ke tabel bookings supaya "Tiket Saya" bisa
     * dicocokkan lewat relasi user, bukan cuma email_pemesan yang
     * diketik manual di form pesan-tiket (rawan typo / email berbeda
     * dari akun login).
     *
     * nullable + nullOnDelete: booking guest (tanpa login) atau user
     * yang akunnya sudah dihapus tetap boleh ada, datanya tidak ikut hilang.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};