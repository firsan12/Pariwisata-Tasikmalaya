<!--
    layouts/app.blade.php — DIBANGUN ULANG.

    Sebelumnya file ini adalah scaffold Breeze berbasis Tailwind
    (class min-h-screen, bg-gray-100, dst) dan meng-include
    layouts/navigation.blade.php yang berbasis Alpine.js (x-data).
    Proyek ini TIDAK meng-compile Tailwind (resources/css/app.css
    kosong) dan TIDAK memuat Alpine.js, sehingga layout ini
    (dipakai oleh Dashboard & Profil) tampil sama sekali tanpa
    gaya dan dropdown/modal-nya tidak berfungsi — persis bug yang
    sama seperti navbar publik yang sudah diperbaiki sebelumnya.

    Sekarang layout ini memakai Bootstrap 5 dan navbar + footer
    situs yang SUDAH ADA & sudah berfungsi (layouts.navigation-site),
    supaya area Dashboard/Profil terasa jadi satu kesatuan dengan
    halaman publik lainnya, bukan area terpisah yang "polos".
-->
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Wisata Tasikmalaya') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&family=Fraunces:opsz,wght@9..144,700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

        <!-- Bootstrap 5 + Icons + stylesheet situs (sama seperti layouts.site) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

        <style>
           .app-header-bar{background:linear-gradient(135deg,#0ea5e9,#38bdf8 55%,#7dd3fc);padding:2.25rem 0 2rem;}
            .app-header-bar .breadcrumb-app .breadcrumb-item a{color:rgba(255,255,255,.8);text-decoration:none;font-weight:500;}
            .app-header-bar .breadcrumb-app .breadcrumb-item a:hover{color:#fff;}
            .app-header-bar .breadcrumb-app .breadcrumb-item.active{color:#fff;font-weight:600;}
            .app-header-bar .breadcrumb-app .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.6);}
        </style>
    </head>
    <body class="font-sans antialiased">

        @include('layouts.navigation-site')

        @if (isset($header))
            <div class="app-header-bar">
                <div class="container">
                    {{ $header }}
                </div>
            </div>
        @endif

        <main style="background:#F4F8FB; min-height:55vh;">
            {{ $slot }}
        </main>

        <footer class="footer-tasik">
            <div class="footer-wave">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#4a90c2" d="M0,32 C240,64 480,0 720,16 C960,32 1200,64 1440,32 L1440,60 L0,60 Z"></path>
                </svg>
            </div>

            <div class="container pt-5 pb-4">
                <div class="row gy-4">
                    <div class="col-12 col-md-4 footer-col" style="--delay:0s">
                        <div class="d-flex align-items-center mb-3">
                            <span class="logo-ring">
                                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Wisata Tasikmalaya" class="brand-logo">
                            </span>
                            <span class="fw-bold text-white fs-5">Wisata Tasikmalaya</span>
                        </div>
                        <p class="footer-text mb-3">
                            Panduan digital untuk menjelajahi pesona alam, budaya, dan kuliner Tasikmalaya —
                            mulai dari pegunungan hijau hingga pantai selatan yang memesona.
                        </p>
                        <div class="d-flex gap-2">
                            <a href="https://wa.me/6281261604202" target="_blank" rel="noopener" class="footer-social" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                            <a href="https://instagram.com" target="_blank" rel="noopener" class="footer-social" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="https://facebook.com" target="_blank" rel="noopener" class="footer-social" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://youtube.com" target="_blank" rel="noopener" class="footer-social" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>

                    <div class="col-6 col-md-2 footer-col" style="--delay:.1s">
                        <h6 class="text-white fw-bold mb-3">Navigasi</h6>
                        <ul class="list-unstyled d-grid gap-2">
                            <li><a href="{{ route('beranda') }}" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Beranda</a></li>
                            <li><a href="{{ route('destinasi') }}" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Destinasi</a></li>
                            <li><a href="{{ route('pesan-tiket') }}" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Pesan Tiket</a></li>
                            <li><a href="{{ route('tentang') }}" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Tentang</a></li>
                            <li><a href="{{ route('kontak') }}" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Kontak</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-md-3 footer-col" style="--delay:.2s">
                        <h6 class="text-white fw-bold mb-3">Kategori Wisata</h6>
                        <ul class="list-unstyled d-grid gap-2">
                            <li><a href="{{ route('destinasi') }}?cari=Pantai" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Pantai</a></li>
                            <li><a href="{{ route('destinasi') }}?cari=Gunung" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Gunung</a></li>
                            <li><a href="{{ route('destinasi') }}?cari=Religi" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Religi</a></li>
                            <li><a href="{{ route('destinasi') }}?cari=Budaya" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Budaya</a></li>
                            <li><a href="{{ route('destinasi') }}?cari=Kuliner" class="footer-link"><i class="bi bi-chevron-right footer-icon"></i>Kuliner</a></li>
                        </ul>
                    </div>

                    <div class="col-12 col-md-3 footer-col" style="--delay:.3s">
                        <h6 class="text-white fw-bold mb-3">Kontak</h6>
                        <ul class="list-unstyled d-grid gap-2">
                            <li class="footer-text"><i class="bi bi-geo-alt-fill footer-icon"></i>Dinas Pariwisata, Kota Tasikmalaya, Jawa Barat</li>
                            <li><a href="mailto:firmanihsan13@gmail.com" class="footer-link"><i class="bi bi-envelope-fill footer-icon"></i>firmanihsan13@gmail.com</a></li>
                            <li><a href="https://wa.me/6281261604202" target="_blank" rel="noopener" class="footer-link"><i class="bi bi-whatsapp footer-icon"></i>0812-6160-4202</a></li>
                            <li class="footer-text"><i class="bi bi-clock-fill footer-icon"></i>Senin – Jumat, 08.00 – 16.00 WIB</li>
                        </ul>
                    </div>
                </div>

                <hr class="footer-divider">

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                    <small class="footer-copy">&copy; {{ date('Y') }} Wisata Tasikmalaya. Seluruh hak cipta dilindungi.</small>
                    <small class="footer-copy">Dipersembahkan untuk pariwisata Tasikmalaya yang lebih maju.</small>
                </div>
            </div>
        </footer>

        <button type="button" class="btn-back-to-top" id="btnBackToTop" aria-label="Kembali ke atas">
            <i class="bi bi-arrow-up"></i>
        </button>

        <script>
            const navbarTasik = document.getElementById('navbarTasik');
            if (navbarTasik) {
                const toggleNavbarScrolled = function () {
                    navbarTasik.classList.toggle('navbar-scrolled', window.scrollY > 40);
                };
                window.addEventListener('scroll', toggleNavbarScrolled);
                toggleNavbarScrolled();
            }

            const btnBackToTop = document.getElementById('btnBackToTop');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 400) {
                    btnBackToTop.classList.add('tampil');
                } else {
                    btnBackToTop.classList.remove('tampil');
                }
            });
            btnBackToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>

        @stack('scripts')

    </body>
</html> 