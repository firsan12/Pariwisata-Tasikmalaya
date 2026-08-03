<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique();
            $table->foreignId('destinasi_id')->constrained('destinasi')->cascadeOnDelete();

            $table->string('nama_pemesan');
            $table->string('email_pemesan');
            $table->string('wa_pemesan');
            $table->date('tanggal_kunjungan');

            $table->unsignedInteger('jumlah_dewasa')->default(0);
            $table->unsignedInteger('jumlah_anak')->default(0);
            $table->unsignedInteger('jumlah_asing')->default(0);

            $table->unsignedBigInteger('subtotal_dewasa')->default(0);
            $table->unsignedBigInteger('subtotal_anak')->default(0);
            $table->unsignedBigInteger('subtotal_asing')->default(0);
            $table->unsignedBigInteger('total_harga')->default(0);

            $table->string('metode_pembayaran'); // qris, transfer_bank, ewallet
            $table->string('bank_kode')->nullable();
            $table->string('ewallet_kode')->nullable();
            $table->unsignedSmallInteger('kode_unik')->default(0);
            $table->unsignedBigInteger('total_transfer')->default(0);

            $table->enum('status', ['pending', 'lunas', 'dibatalkan'])->default('pending');
            $table->timestamp('dibayar_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};