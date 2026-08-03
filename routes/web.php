<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect()->route('beranda');
});

Route::get('/beranda', [DestinasiController::class, 'beranda'])->name('beranda');

// ===== Destinasi =====
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/create', [DestinasiController::class, 'create'])->name('destinasi.create');
Route::post('/destinasi', [DestinasiController::class, 'store'])->name('destinasi.store');
Route::get('/destinasi/{id}/edit', [DestinasiController::class, 'edit'])->name('destinasi.edit');
Route::put('/destinasi/{id}', [DestinasiController::class, 'update'])->name('destinasi.update');
Route::delete('/destinasi/{id}', [DestinasiController::class, 'destroy'])->name('destinasi.destroy');
Route::get('/destinasi/{id}', [DestinasiController::class, 'show'])->name('destinasi.detail');

Route::get('/tentang', fn () => view('tentang'))->name('tentang');
Route::get('/kontak', fn () => view('kontak'))->name('kontak');

// ===== Pesan Tiket & Pembayaran =====
Route::get('/pesan-tiket', fn () => view('pesan-tiket'))->name('pesan-tiket');
Route::post('/pesan-tiket', [BookingController::class, 'store'])->name('pesan-tiket.store');

Route::get('/pembayaran/{kodeBooking}', [BookingController::class, 'show'])->name('pembayaran.show');
Route::post('/pembayaran/{kodeBooking}/konfirmasi', [BookingController::class, 'confirm'])->name('pembayaran.konfirmasi');