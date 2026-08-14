{{--
    Navbar publik (redesign v2 -- platform wisata modern).
    Tetap pakai Bootstrap 5 (sudah dimuat di layouts/site.blade.php) dan
    class dasar navbar-tasik/logo-ring/brand-logo yang sudah ada di
    public/CSS/style.css, ditambah class baru "wt-*" (lihat blok CSS baru
    di akhir style.css) untuk elemen baru: menu Kuliner/Event, ikon
    favorit & keranjang dengan badge, dan dropdown profil yang dirapikan.

    CATATAN: fitur Favorit & Keranjang backend-nya BELUM dibangun (menyusul
    di tahap Kuliner/Cart). Ikonnya sudah tampil sesuai desain, tapi untuk
    sementara mengarah ke "#" (badge menampilkan 0) supaya tidak memicu
    error route sebelum controller-nya ada.
--}}
<nav class="navbar navbar-expand-lg navbar-dark navbar-tasik sticky-top" id="navbarTasik">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}">
            <span class="logo-ring">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Wisata Tasikmalaya" class="brand-logo">
            </span>
            <span class="fw-bold">Wisata Tasikmalaya</span>
        </a>

        <div class="d-flex align-items-center order-lg-3 wt-nav-mobile-actions">
            <a href="#" class="wt-icon-btn d-lg-none" title="Keranjang (segera hadir)">
                <i class="bi bi-cart3"></i>
                <span class="wt-badge" id="wtCartBadgeMobile">0</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTasikMenu"
                    aria-controls="navbarTasikMenu" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarTasikMenu">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('destinasi') || request()->routeIs('destinasi.detail') ? 'active' : '' }}" href="{{ route('destinasi') }}">Destinasi</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link {{ request()->routeIs('kuliner.katalog') || request()->routeIs('kuliner.detail') ? 'active' : '' }}" href="{{ route('kuliner.katalog') }}">Kuliner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pesan-tiket') || request()->routeIs('pembayaran.show') ? 'active' : '' }}" href="{{ route('pesan-tiket') }}">Tiket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('beranda') }}#event-promo">Event</a>
                </li>
            </ul>

            <form action="{{ route('destinasi') }}" method="GET" class="navbar-search-mini d-flex align-items-center me-3">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" class="form-control form-control-sm border-0"
                       placeholder="Cari destinasi..." aria-label="Cari destinasi">
            </form>

            <div class="d-flex align-items-center gap-2 navbar-auth">
                <a href="{{ route('destinasi') }}" class="wt-icon-btn d-none d-lg-inline-flex" title="Cari">
                    <i class="bi bi-search"></i>
                </a>
                <a href="#" class="wt-icon-btn" title="Favorit (segera hadir)">
                    <i class="bi bi-heart"></i>
                </a>
                <a href="#" class="wt-icon-btn d-none d-lg-inline-flex" title="Keranjang (segera hadir)">
                    <i class="bi bi-cart3"></i>
                    <span class="wt-badge" id="wtCartBadge">0</span>
                </a>

             @auth
    <div class="dropdown">
        <button class="btn btn-navbar-user dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
            <li><a class="dropdown-item disabled" href="#"><i class="bi bi-heart me-2"></i>Favorit <small class="text-muted">(segera hadir)</small></a></li>
            <li><a class="dropdown-item disabled" href="#"><i class="bi bi-cart3 me-2"></i>Keranjang <small class="text-muted">(segera hadir)</small></a></li>
            <li><a class="dropdown-item {{ request()->routeIs('tiket.saya') ? 'active' : '' }}" href="{{ route('tiket.saya') }}"><i class="bi bi-ticket-perforated me-2"></i>Tiket Saya</a></li>
            @if(Auth::user()->role === 'admin')
                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>
@else
    <a href="{{ route('login') }}" class="btn btn-navbar-outline">Masuk</a>
    <a href="{{ route('register') }}" class="btn btn-navbar-cta">Daftar</a>
@endauth
            </div>
        </div>
    </div>
</nav>