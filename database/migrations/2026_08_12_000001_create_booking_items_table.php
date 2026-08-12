<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
    Tabel booking_items — satu baris per destinasi di dalam satu booking/order.
    Sebelumnya satu Booking = satu destinasi (destinasi_id langsung di tabel
    bookings). Sekarang bookings tetap dipakai sebagai "order" (data pemesan,
    metode pembayaran, total gabungan) TANPA mengubah kolom yang sudah ada
    (destinasi_id & jumlah_/subtotal_* di bookings tetap terisi sebagai
    RINGKASAN/AGREGAT — destinasi_id = destinasi pertama, jumlah_/subtotal_*
    = total gabungan semua item), supaya data booking LAMA (sebelum fitur
    keranjang ini) tetap tampil normal tanpa migrasi ulang data.

    Harga (harga_dewasa/anak/asing) di-snapshot per item saat checkout, supaya
    kalau harga destinasi berubah setelah booking dibuat, struk pembayaran
    tetap menampilkan harga saat transaksi terjadi — bukan harga terbaru.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('destinasi_id')->constrained('destinasi')->cascadeOnDelete();

            $table->unsignedInteger('jumlah_dewasa')->default(0);
            $table->unsignedInteger('jumlah_anak')->default(0);
            $table->unsignedInteger('jumlah_asing')->default(0);

            $table->unsignedBigInteger('harga_dewasa')->default(0);
            $table->unsignedBigInteger('harga_anak')->default(0);
            $table->unsignedBigInteger('harga_asing')->default(0);

            $table->unsignedBigInteger('subtotal_dewasa')->default(0);
            $table->unsignedBigInteger('subtotal_anak')->default(0);
            $table->unsignedBigInteger('subtotal_asing')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};