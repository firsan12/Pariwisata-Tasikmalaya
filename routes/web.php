<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AtraksiController;
 use App\Http\Controllers\UlasanController;

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');


Route::get('/atraksi', [AtraksiController::class, 'index'])->name('atraksi');
Route::get('/atraksi/create', [AtraksiController::class, 'create'])->name('atraksi.create');
Route::post('/atraksi', [AtraksiController::class, 'store'])->name('atraksi.store');
Route::get('/atraksi/{id}/edit', [AtraksiController::class, 'edit'])->name('atraksi.edit');
Route::put('/atraksi/{id}', [AtraksiController::class, 'update'])->name('atraksi.update');
Route::delete('/atraksi/{id}', [AtraksiController::class, 'destroy'])->name('atraksi.destroy');


Route::get('/', function () {
    return redirect()->route('beranda');
});

Route::get('/beranda', [DestinasiController::class, 'beranda'])->name('beranda');

// ===== Destinasi =====
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/admin', [DestinasiController::class, 'admin'])->name('destinasi.admin');
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

Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
   Route::patch('/ulasan/{ulasan}/approve', [UlasanController::class, 'approve'])->name('ulasan.approve');
   Route::post('/ulasan/{ulasan}/balas', [UlasanController::class, 'balas'])->name('ulasan.balas');

   Route::post('/destinasi/{destinasi}/ulasan', [App\Http\Controllers\UlasanController::class, 'store'])
    ->name('ulasan.store');