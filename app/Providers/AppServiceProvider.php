<?php

namespace App\Providers;

use App\Models\ProfilSitus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan info kontak (ProfilSitus) ke layout utama supaya footer
        // (yang tampil di SEMUA halaman) bisa pakai data dinamis yang sama
        // dengan section Kontak, tanpa perlu tiap Controller kirim variabel
        // ini satu-satu.
        View::composer('layouts.site', function ($view) {
            $view->with('footerProfil', ProfilSitus::current());
        });
    }
}