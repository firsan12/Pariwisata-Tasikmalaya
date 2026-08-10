{{--
    Navbar publik — dibangun ulang total.
    Sebelumnya file ini memakai scaffold Breeze berbasis Tailwind + Alpine
    (x-data, class sm:flex, dsb). Proyek ini TIDAK meng-compile Tailwind
    (resources/css/app.css kosong, tidak ada tailwind.config.js) dan TIDAK
    memuat Alpine.js di layouts/site.blade.php, sehingga navbar lama tampil
    tanpa styling sama sekali dan tombol menu/dropdown-nya tidak berfungsi.

    Navbar baru ini memakai Bootstrap 5 (sudah dimuat di layouts/site.blade.php)
    dan class navbar-tasik / logo-ring / brand-logo yang SUDAH ADA di
    public/CSS/style.css tapi sebelumnya tidak pernah dipakai di markup manapun.
--}}
<nav class="navbar navbar-expand-lg navbar-dark navbar-tasik sticky-top" id="navbarTasik">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}">
            <span class="logo-ring">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Wisata Tasikmalaya" class="brand-logo">
            </span>
            <span class="fw-bold">Wisata Tasikmalaya</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTasikMenu"
                aria-controls="navbarTasikMenu" aria-expanded="false" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTasikMenu">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('destinasi') || request()->routeIs('destinasi.detail') ? 'active' : '' }}" href="{{ route('destinasi') }}">Destinasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pesan-tiket') || request()->routeIs('pembayaran.show') ? 'active' : '' }}" href="{{ route('pesan-tiket') }}">Pesan Tiket</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                </li>
            </ul>

            <form action="{{ route('destinasi') }}" method="GET" class="navbar-search-mini d-flex align-items-center me-3">
                <i class="bi bi-search"></i>
                <input type="text" name="cari" class="form-control form-control-sm border-0"
                       placeholder="Cari destinasi..." aria-label="Cari destinasi">
            </form>

            <div class="d-flex align-items-center gap-2 navbar-auth">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-navbar-user dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
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
