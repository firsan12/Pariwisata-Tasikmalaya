<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wisata Tasikmalaya - Beranda')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>
<body>
   <header>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-tasik shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('beranda') }}">
                <span class="logo-ring">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo Wisata Tasikmalaya" class="brand-logo">
                </span>
                <span>Wisata Tasikmalaya</span>
            </a>

            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarMenu"
                    aria-controls="navbarMenu" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}"
                           @if (request()->routeIs('beranda')) aria-current="page" @endif
                           href="{{ route('beranda') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('destinasi*') ? 'active' : '' }}"
                           @if (request()->routeIs('destinasi*')) aria-current="page" @endif
                           href="{{ route('destinasi') }}">Destinasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}"
                           @if (request()->routeIs('tentang')) aria-current="page" @endif
                           href="{{ route('tentang') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}"
                           @if (request()->routeIs('kontak')) aria-current="page" @endif
                           href="{{ route('kontak') }}">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>

        
        <div class="navbar-decor">
            <svg viewBox="0 0 1200 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,90 Q150,70 300,90 T600,90 T900,90 T1200,90 V100 H0 Z" fill="#a8d8f0" opacity="0.6"/>
                <polygon points="50,90 130,25 210,90" fill="#5b8fb0" opacity="0.7"/>
                <polygon points="180,90 260,10 340,90" fill="#4a7a99" opacity="0.7"/>
                <polygon points="950,90 1000,45 1010,55 1010,90" fill="#3f6b85" opacity="0.8"/>
                <polygon points="1010,90 1050,35 1090,90" fill="#3f6b85" opacity="0.8"/>
                <rect x="1000" y="55" width="70" height="35" fill="#345a72" opacity="0.8"/>
            </svg>
        </div>
    </nav>
</header>

    @yield('content')

 <footer class="footer-tasik text-white pt-5 pb-3 footer-content">
    <!-- Gelombang dekoratif di bagian atas footer -->
    <div class="footer-wave">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 Q150,0 300,30 T600,30 T900,30 T1200,30 V60 H0 Z" fill="#f4f8fb"></path>
        </svg>
    </div>

    <div class="container">
        <div class="row gy-4">
            <div class="col-12 col-md-4 footer-col" style="--delay: 0.1s;">
                <h4 class="fw-bold mb-3">Wisata Tasikmalaya</h4>
                <p class="footer-text mb-0">
                    Menyajikan keindahan alam, budaya, dan kuliner khas daerah untuk setiap perjalanan wisata Anda.
                </p>
            </div>

            <div class="col-12 col-md-4 footer-col" style="--delay: 0.25s;">
                <h4 class="fw-bold mb-3">Navigasi</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('beranda') }}" class="footer-link">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('destinasi') }}" class="footer-link">Destinasi</a></li>
                    <li class="mb-2"><a href="{{ route('tentang') }}" class="footer-link">Tentang</a></li>
                    <li class="mb-2"><a href="{{ route('kontak') }}" class="footer-link">Kontak</a></li>
                </ul>
            </div>

          <div class="col-12 col-md-4 footer-col" style="--delay: 0.4s;">
    <h4 class="fw-bold mb-3">Hubungi Kami</h4>

    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=firmanihsan13@gmail.com&su=Pertanyaan%20Seputar%20Wisata%20Tasikmalaya" 
       target="_blank" rel="noopener" 
       class="contact-link mb-2">
        <span class="contact-icon"><i class="bi bi-envelope-fill"></i></span>
        <span>firmanihsan13@gmail.com</span>
    </a>

    <a href="https://wa.me/6281261604202?text=Halo%2C%20saya%20ingin%20bertanya%20tentang%20Wisata%20Tasikmalaya" 
       target="_blank" rel="noopener" 
       class="contact-link">
        <span class="contact-icon"><i class="bi bi-whatsapp"></i></span>
        <span>0812-6160-4202</span>
    </a>
</div>
        <hr class="footer-divider">

        <p class="text-center footer-copy mb-0">
            &copy; 2026 Wisata Tasikmalaya. Dibuat untuk keperluan pelatihan pemrograman web pariwisata.
        </p>
    </div>

    <!-- Tombol kembali ke atas -->
    <button class="btn-back-to-top" id="backToTop" aria-label="Kembali ke atas">↑</button>
</footer>

<script>
    // Tombol "kembali ke atas" muncul hanya setelah discroll agak jauh
    window.addEventListener('scroll', function () {
        const tombol = document.getElementById('backToTop');
        if (window.scrollY > 400) {
            tombol.classList.add('tampil');
        } else {
            tombol.classList.remove('tampil');
        }
    });

    document.getElementById('backToTop').addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>