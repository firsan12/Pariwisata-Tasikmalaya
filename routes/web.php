<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UlasanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AtraksiController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\PenginapanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DestinasiController::class, 'beranda'])->name('beranda');

Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/kontak', 'kontak')->name('kontak');

Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/create', [DestinasiController::class, 'create'])->name('destinasi.create');
Route::post('/destinasi', [DestinasiController::class, 'store'])->name('destinasi.store');
Route::get('/destinasi/{id}', [DestinasiController::class, 'show'])->name('destinasi.detail');
Route::get('/destinasi/{id}/edit', [DestinasiController::class, 'edit'])->name('destinasi.edit');
Route::put('/destinasi/{id}', [DestinasiController::class, 'update'])->name('destinasi.update');
Route::delete('/destinasi/{id}', [DestinasiController::class, 'destroy'])->name('destinasi.destroy');
Route::get('/admin/destinasi', [DestinasiController::class, 'admin'])->name('destinasi.admin');

// Ulasan
Route::post('/destinasi/{destinasi}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
Route::patch('/ulasan/{ulasan}/approve', [UlasanController::class, 'approve'])->name('ulasan.approve');
Route::post('/ulasan/{ulasan}/balas', [UlasanController::class, 'balas'])->name('ulasan.balas');

// Booking / Pesan Tiket
Route::get('/pesan-tiket', [BookingController::class, 'create'])->name('pesan-tiket');
Route::post('/booking', [BookingController::class, 'store'])->name('pesan-tiket.store');
Route::get('/pembayaran/{kodeBooking}', [BookingController::class, 'show'])->name('pembayaran.show');
Route::post('/pembayaran/{kodeBooking}/klaim', [BookingController::class, 'claimPaid'])->name('pembayaran.klaim');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

route::get('/user', [UserController::class, 'index'])->name('user');
route::get('/user/create', [UserController::class, 'create'])->name('user.create');
route::post('/user', [UserController::class, 'store'])->name('user.store');
route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');


route::get('/atraksi', [AtraksiController::class, 'index'])->name('atraksi');
route::get('/atraksi/create', [AtraksiController::class, 'create'])->name('atraksi.create');
route::post('/atraksi', [AtraksiController::class, 'store'])->name('atraksi.store');
route::get('/atraksi/{id}/edit', [AtraksiController::class, 'edit'])->name('atraksi.edit');
route::put('/atraksi/{id}', [AtraksiController::class, 'update'])->name('atraksi.update');
route::delete('/atraksi/{id}', [AtraksiController::class, 'destroy'])->name('atraksi.destroy'); 

require __DIR__.'/auth.php';

// Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
Route::get('/galeri/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

// Kuliner
Route::get('/kuliner', [KulinerController::class, 'index'])->name('kuliner');
Route::get('/kuliner/create', [KulinerController::class, 'create'])->name('kuliner.create');
Route::post('/kuliner', [KulinerController::class, 'store'])->name('kuliner.store');
Route::get('/kuliner/{id}/edit', [KulinerController::class, 'edit'])->name('kuliner.edit');
Route::put('/kuliner/{id}', [KulinerController::class, 'update'])->name('kuliner.update');
Route::delete('/kuliner/{id}', [KulinerController::class, 'destroy'])->name('kuliner.destroy');

// Penginapan
Route::get('/penginapan', [PenginapanController::class, 'index'])->name('penginapan');
Route::get('/penginapan/create', [PenginapanController::class, 'create'])->name('penginapan.create');
Route::post('/penginapan', [PenginapanController::class, 'store'])->name('penginapan.store');
Route::get('/penginapan/{id}/edit', [PenginapanController::class, 'edit'])->name('penginapan.edit');
Route::put('/penginapan/{id}', [PenginapanController::class, 'update'])->name('penginapan.update');
Route::delete('/penginapan/{id}', [PenginapanController::class, 'destroy'])->name('penginapan.destroy');