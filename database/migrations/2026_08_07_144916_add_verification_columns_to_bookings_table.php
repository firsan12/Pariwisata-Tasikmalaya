<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'klaim_bayar_at')) {
                $table->timestamp('klaim_bayar_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'bukti_transfer_path')) {
                $table->string('bukti_transfer_path')->nullable()->after('klaim_bayar_at');
            }
            if (!Schema::hasColumn('bookings', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('dibayar_at')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'verified_ip')) {
                $table->string('verified_ip')->nullable()->after('verified_by');
            }
            if (!Schema::hasColumn('bookings', 'alasan_ditolak')) {
                $table->string('alasan_ditolak')->nullable()->after('verified_ip');
            }
            if (!Schema::hasColumn('bookings', 'dibatalkan_at')) {
                $table->timestamp('dibatalkan_at')->nullable()->after('alasan_ditolak');
            }
        });

        // Pastikan enum status mencakup semua nilai yang dipakai controller:
        // pending, menunggu_verifikasi, lunas, ditolak, dibatalkan
        DB::statement("ALTER TABLE bookings MODIFY status ENUM('pending', 'menunggu_verifikasi', 'lunas', 'ditolak', 'dibatalkan') DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'klaim_bayar_at',
                'bukti_transfer_path',
                'verified_by',
                'verified_ip',
                'alasan_ditolak',
                'dibatalkan_at',
            ]);
        });
    }
};