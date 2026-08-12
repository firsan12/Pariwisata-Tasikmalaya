<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KulinerController;

/*
|--------------------------------------------------------------------------
| ROUTE KULINER
|--------------------------------------------------------------------------
| Tambahkan isi file ini ke routes/web.php.
|
| Admin tetap menggunakan route lama:
|   /kuliner
|
| Katalog publik:
|   /kuliner-wisata
|   /kuliner-wisata/{kuliner}
|--------------------------------------------------------------------------
*/

Route::get('/kuliner-wisata', [KulinerController::class, 'katalog'])
    ->name('kuliner.katalog');

Route::get('/kuliner-wisata/{kuliner}', [KulinerController::class, 'detail'])
    ->name('kuliner.detail');

/*
| Jika Anda ingin katalog publik menjadi /kuliner,
| pindahkan route admin lama ke prefix /admin/kuliner terlebih dahulu.
*/
