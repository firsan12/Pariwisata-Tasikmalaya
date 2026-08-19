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
use App\Http\Controllers\TentangController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\EventPromoController;
use App\Http\Controllers\AdminController;
use App\Models\Ulasan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Struktur file ini:
|   1. Route publik (bisa diakses siapa saja, termasuk tamu)
|   2. Route yang butuh login (customer biasa)
|   3. Route admin (butuh login + role admin) — SEMUA aksi tulis
|      (create/store/edit/update/destroy) untuk konten dikelola di sini.
|
| PENTING: jangan duplikasi route dengan URI/nama yang sama di luar grup
| admin di bawah. Sebelumnya banyak route admin didefinisikan dua kali
| (sekali publik tanpa middleware, sekali lagi dengan middleware admin)
| sehingga rawan bug/celah keamanan kalau urutan berubah. Sekarang setiap
| route hanya didefinisikan SATU KALI.
|
| CATATAN FIX: route publik dengan parameter dinamis seperti
| /destinasi/{id} HARUS dibatasi hanya menerima angka (->where('id',
| '[0-9]+')). Tanpa ini, path statis seperti /destinasi/create milik
| grup admin di bawah akan "tertangkap" duluan oleh route {id} ini
| (karena "create" dianggap sebagai nilai {id}), sehingga menyebabkan
| 404 dari findOrFail() alih-alih menampilkan form create.
|
*/

// =======================================================================
// 1. PUBLIK — tanpa login
// =======================================================================

Route::get('/', [DestinasiController::class, 'beranda'])->name('beranda');

Route::get('/tentang', [TentangController::class, 'index'])->name('tentang');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'send'])->name('kontak.send');

// Destinasi (baca saja)
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/{id}', [DestinasiController::class, 'show'])
    ->name('destinasi.detail')
    ->where('id', '[0-9]+');

// Ulasan — publik hanya boleh mengirim ulasan baru (menunggu moderasi admin)
Route::post('/destinasi/{destinasi}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

// Booking / Pesan Tiket — aksi pengunjung (guest checkout diperbolehkan)
Route::get('/pesan-tiket', [BookingController::class, 'create'])->name('pesan-tiket');
Route::post('/booking', [BookingController::class, 'store'])->name('pesan-tiket.store');
Route::get('/pembayaran/{kodeBooking}', [BookingController::class, 'show'])->name('pembayaran.show');
Route::post('/pembayaran/{kodeBooking}/klaim', [BookingController::class, 'claimPaid'])->name('pembayaran.klaim');

// Atraksi (baca saja)
Route::get('/atraksi', [AtraksiController::class, 'index'])->name('atraksi');

// Galeri (baca saja)
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');

// Kuliner (baca saja)
Route::get('/kuliner', [KulinerController::class, 'index'])->name('kuliner');
Route::get('/kuliner/katalog', [KulinerController::class, 'katalog'])->name('kuliner.katalog');
Route::get('/kuliner/{kuliner}', [KulinerController::class, 'show'])->name('kuliner.detail');

// Penginapan (baca saja)
Route::get('/penginapan', [PenginapanController::class, 'index'])->name('penginapan');

// Event & Promo (baca saja)
Route::get('/event', [EventPromoController::class, 'index'])->name('event.admin');
// Route publik ini WAJIB paling bawah supaya tidak "menangkap" path statis
// seperti /event/create milik grup admin di bawah.
Route::get('/event/{id}', [EventPromoController::class, 'show'])->name('event.detail');

require __DIR__.'/auth.php';

// =======================================================================
// 2. BUTUH LOGIN (customer biasa)
// =======================================================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tiket Saya — riwayat booking milik user yang login (dicocokkan lewat email)
    Route::get('/tiket-saya', [BookingController::class, 'myTickets'])->name('tiket.saya');
});

Route::get('/dashboard', function () {
    $totalUlasan   = Ulasan::count();
    $ulasanPending = Ulasan::where('status', 'pending')->count();

    return view('dashboard', compact('totalUlasan', 'ulasanPending'));
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

// =======================================================================
// 3. ADMIN — butuh login + role admin
//    Semua aksi tulis (create/store/edit/update/destroy) untuk seluruh
//    modul konten ada di sini, TIDAK ADA duplikat di luar grup ini.
// =======================================================================

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Destinasi
    Route::get('/admin/destinasi', [DestinasiController::class, 'admin'])->name('destinasi.admin');
    Route::get('/destinasi/create', [DestinasiController::class, 'create'])->name('destinasi.create');
    Route::post('/destinasi', [DestinasiController::class, 'store'])->name('destinasi.store');
    Route::get('/destinasi/{id}/edit', [DestinasiController::class, 'edit'])->name('destinasi.edit');
    Route::put('/destinasi/{id}', [DestinasiController::class, 'update'])->name('destinasi.update');
    Route::delete('/destinasi/{id}', [DestinasiController::class, 'destroy'])->name('destinasi.destroy');

    // User (manajemen akun — sepenuhnya admin-only)
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Atraksi
    Route::get('/atraksi/create', [AtraksiController::class, 'create'])->name('atraksi.create');
    Route::post('/atraksi', [AtraksiController::class, 'store'])->name('atraksi.store');
    Route::get('/atraksi/{id}/edit', [AtraksiController::class, 'edit'])->name('atraksi.edit');
    Route::put('/atraksi/{id}', [AtraksiController::class, 'update'])->name('atraksi.update');
    Route::delete('/atraksi/{id}', [AtraksiController::class, 'destroy'])->name('atraksi.destroy');

    // Galeri
    Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

    // Kuliner — pakai route model binding {kuliner} konsisten dengan
    // KulinerController::edit/update/destroy(Kuliner $kuliner).
    // (Sebelumnya ada duplikat route pakai {id} yang membuat form edit
    // kosong dan update/hapus tidak tersimpan — sudah dihapus.)
    Route::get('/kuliner/create', [KulinerController::class, 'create'])->name('kuliner.create');
    Route::post('/kuliner', [KulinerController::class, 'store'])->name('kuliner.store');
    Route::get('/kuliner/{kuliner}/edit', [KulinerController::class, 'edit'])->name('kuliner.edit');
    Route::put('/kuliner/{kuliner}', [KulinerController::class, 'update'])->name('kuliner.update');
    Route::delete('/kuliner/{kuliner}', [KulinerController::class, 'destroy'])->name('kuliner.destroy');

    // Penginapan
    Route::get('/penginapan/create', [PenginapanController::class, 'create'])->name('penginapan.create');
    Route::post('/penginapan', [PenginapanController::class, 'store'])->name('penginapan.store');
    Route::get('/penginapan/{id}/edit', [PenginapanController::class, 'edit'])->name('penginapan.edit');
    Route::put('/penginapan/{id}', [PenginapanController::class, 'update'])->name('penginapan.update');
    Route::delete('/penginapan/{id}', [PenginapanController::class, 'destroy'])->name('penginapan.destroy');

    // Event & Promo
    Route::get('/event/create', [EventPromoController::class, 'create'])->name('event.create');
    Route::post('/event', [EventPromoController::class, 'store'])->name('event.store');
    Route::get('/event/{id}/edit', [EventPromoController::class, 'edit'])->name('event.edit');
    Route::put('/event/{id}', [EventPromoController::class, 'update'])->name('event.update');
    Route::delete('/event/{id}', [EventPromoController::class, 'destroy'])->name('event.destroy');

    // Ulasan — moderasi/balas/hapus adalah aksi admin
    Route::get('/admin/ulasan', [UlasanController::class, 'index'])->name('ulasan.admin');
    Route::delete('/ulasan/{ulasan}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    Route::patch('/ulasan/{ulasan}/approve', [UlasanController::class, 'approve'])->name('ulasan.approve');
    Route::patch('/ulasan/{ulasan}/reject', [UlasanController::class, 'reject'])->name('ulasan.reject');
    Route::post('/ulasan/{ulasan}/balas', [UlasanController::class, 'balas'])->name('ulasan.balas');
});