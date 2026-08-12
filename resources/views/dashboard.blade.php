<x-app-layout>
    {{-- =========================
         DASHBOARD PARIWISATA
    ========================== --}}

    <x-slot name="header">
        <div class="dashboard-header">
            <div>
                <span class="dashboard-badge">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </span>
                <h2>Panel Pariwisata Tasikmalaya</h2>
                <p>Kelola dan pantau informasi pariwisata dengan mudah.</p>
            </div>

            <div class="header-date">
                <i class="bi bi-calendar3"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="dashboard-wrapper">

        {{-- =========================
             HERO WELCOME
        ========================== --}}
        <section class="welcome-section">
            <div class="welcome-overlay"></div>

            <div class="welcome-content">
                <div class="welcome-icon">
                    <i class="bi bi-person-check-fill"></i>
                </div>

                <div>
                    <span class="welcome-label">Selamat datang kembali</span>

                    <h1>
                        {{ Auth::user()->name }}
                    </h1>

                    <p>
                        Jelajahi dan kelola potensi wisata Tasikmalaya
                        dari satu dashboard.
                    </p>

                    <div class="welcome-actions">
                        <a href="{{ route('destinasi') }}" class="btn-primary-dashboard">
                            <i class="bi bi-map"></i>
                            Lihat Destinasi
                        </a>

                        <a href="{{ route('destinasi.create') }}" class="btn-light-dashboard">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Destinasi
                        </a>
                    </div>
                </div>
            </div>

            <div class="welcome-decoration">
                <i class="bi bi-compass"></i>
            </div>
        </section>


        {{-- =========================
             STATISTIK
        ========================== --}}
        <section class="dashboard-section">

            <div class="section-heading">
                <div>
                    <span class="section-label">RINGKASAN</span>
                    <h3>Statistik Pariwisata</h3>
                </div>
            </div>

            <div class="statistics-grid">

                <a href="{{ route('destinasi.admin') }}" class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="stat-content">
                        <span>Total Destinasi</span>
                        <strong>{{ $totalDestinasi ?? 125 }}</strong>
                        <small>
                            <i class="bi bi-arrow-up"></i>
                            Data wisata
                        </small>
                    </div>
                </a>


                <a href="{{ route('destinasi.admin') }}" class="stat-card">
                    <div class="stat-icon green">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div class="stat-content">
                        <span>Destinasi Aktif</span>
                        <strong>{{ $destinasiAktif ?? 118 }}</strong>
                        <small>
                            <i class="bi bi-check2"></i>
                            Terpublikasi
                        </small>
                    </div>
                </a>


                <a href="{{ route('penginapan') }}" class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bi bi-building"></i>
                    </div>

                    <div class="stat-content">
                        <span>Penginapan</span>
                        <strong>{{ $totalPenginapan ?? 32 }}</strong>
                        <small>
                            <i class="bi bi-house-check"></i>
                            Terdaftar
                        </small>
                    </div>
                </a>


                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <div class="stat-content">
                        <span>Total Ulasan</span>
                        <strong>{{ $totalUlasan ?? 486 }}</strong>
                        <small>
                            <i class="bi bi-chat-square-text"></i>
                            Dari pengunjung
                        </small>
                    </div>
                </div>

            </div>
        </section>


        {{-- =========================
             AKSES CEPAT
        ========================== --}}
        <section class="dashboard-section">

            <div class="section-heading">
                <div>
                    <span class="section-label">NAVIGASI</span>
                    <h3>Akses Cepat</h3>
                </div>

                <span class="section-description">
                    Kelola informasi utama
                </span>
            </div>


            <div class="quick-menu-grid">

                <a href="{{ route('destinasi.admin') }}" class="quick-card">
                    <div class="quick-icon blue">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h4>Destinasi</h4>
                        <p>Kelola tempat wisata</p>
                    </div>
                    <i class="bi bi-arrow-right quick-arrow"></i>
                </a>


                <a href="{{ route('galeri') }}" class="quick-card">
                    <div class="quick-icon pink">
                        <i class="bi bi-images"></i>
                    </div>
                    <div>
                        <h4>Galeri</h4>
                        <p>Kelola foto wisata</p>
                    </div>
                    <i class="bi bi-arrow-right quick-arrow"></i>
                </a>


                <a href="{{ route('kuliner') }}" class="quick-card">
                    <div class="quick-icon orange">
                        <i class="bi bi-cup-hot-fill"></i>
                    </div>
                    <div>
                        <h4>Kuliner</h4>
                        <p>Informasi kuliner</p>
                    </div>
                    <i class="bi bi-arrow-right quick-arrow"></i>
                </a>


                <a href="{{ route('penginapan') }}" class="quick-card">
                    <div class="quick-icon green">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <h4>Penginapan</h4>
                        <p>Kelola akomodasi</p>
                    </div>
                    <i class="bi bi-arrow-right quick-arrow"></i>
                </a>


                <a href="{{ route('atraksi') }}" class="quick-card">
                    <div class="quick-icon purple">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                        <h4>Event</h4>
                        <p>Kelola agenda wisata</p>
                    </div>
                    <i class="bi bi-arrow-right quick-arrow"></i>
                </a>


                <a href="{{ route('user') }}" class="quick-card">
                    <div class="quick-icon teal">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h4>Pengguna</h4>
                        <p>Kelola pengguna</p>
                    </div>
                    <i class="bi bi-arrow-right quick-arrow"></i>
                </a>

            </div>
        </section>


        {{-- =========================
             DESTINASI POPULER + AKTIVITAS
        ========================== --}}
        <div class="dashboard-columns">

            {{-- Destinasi --}}
            <section class="dashboard-panel">

                <div class="panel-header">
                    <div>
                        <span class="section-label">WISATA</span>
                        <h3>Destinasi Populer</h3>
                    </div>

                    <a href="{{ route('destinasi') }}">
                        Lihat semua
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>


                <div class="destination-list">

                    @forelse (($destinasiPopuler ?? []) as $destinasi)
                        <a href="{{ route('destinasi.detail', $destinasi->id) }}" class="destination-item">
                            <div class="destination-image">
                                @if($destinasi->foto ?? false)
                                    <img src="{{ asset('storage/' . $destinasi->foto) }}" alt="{{ $destinasi->nama }}">
                                @else
                                    <i class="bi bi-image"></i>
                                @endif
                            </div>

                            <div class="destination-info">
                                <h4>{{ $destinasi->nama }}</h4>
                                <span>
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $destinasi->lokasi ?? 'Tasikmalaya' }}
                                </span>

                                <div class="rating">
                                    <i class="bi bi-star-fill"></i>
                                    <strong>{{ number_format($destinasi->rating ?? 0, 1) }}</strong>
                                    <small> • {{ $destinasi->kategori ?? 'Wisata' }}</small>
                                </div>
                            </div>

                            <i class="bi bi-chevron-right destination-arrow"></i>
                        </a>
                    @empty
                        {{-- Fallback statis selama data belum tersedia dari controller --}}
                        <a href="{{ route('destinasi') }}" class="destination-item">
                            <div class="destination-image">
                                <i class="bi bi-image"></i>
                            </div>

                            <div class="destination-info">
                                <h4>Gunung Galunggung</h4>
                                <span>
                                    <i class="bi bi-geo-alt"></i>
                                    Tasikmalaya
                                </span>

                                <div class="rating">
                                    <i class="bi bi-star-fill"></i>
                                    <strong>4.8</strong>
                                    <small> • Populer</small>
                                </div>
                            </div>

                            <i class="bi bi-chevron-right destination-arrow"></i>
                        </a>


                        <a href="{{ route('destinasi') }}" class="destination-item">
                            <div class="destination-image">
                                <i class="bi bi-image"></i>
                            </div>

                            <div class="destination-info">
                                <h4>Kampung Naga</h4>
                                <span>
                                    <i class="bi bi-geo-alt"></i>
                                    Tasikmalaya
                                </span>

                                <div class="rating">
                                    <i class="bi bi-star-fill"></i>
                                    <strong>4.7</strong>
                                    <small> • Budaya</small>
                                </div>
                            </div>

                            <i class="bi bi-chevron-right destination-arrow"></i>
                        </a>


                        <a href="{{ route('destinasi') }}" class="destination-item">
                            <div class="destination-image">
                                <i class="bi bi-image"></i>
                            </div>

                            <div class="destination-info">
                                <h4>Pantai Selatan</h4>
                                <span>
                                    <i class="bi bi-geo-alt"></i>
                                    Tasikmalaya
                                </span>

                                <div class="rating">
                                    <i class="bi bi-star-fill"></i>
                                    <strong>4.6</strong>
                                    <small> • Alam</small>
                                </div>
                            </div>

                            <i class="bi bi-chevron-right destination-arrow"></i>
                        </a>
                    @endforelse

                </div>

            </section>


            {{-- Aktivitas --}}
            <section class="dashboard-panel">

                <div class="panel-header">
                    <div>
                        <span class="section-label">AKTIVITAS</span>
                        <h3>Aktivitas Terbaru</h3>
                    </div>

                    <i class="bi bi-three-dots"></i>
                </div>


                <div class="activity-list">

                    <div class="activity-item">
                        <div class="activity-icon blue">
                            <i class="bi bi-plus-lg"></i>
                        </div>

                        <div class="activity-text">
                            <h4>Destinasi baru</h4>
                            <p>Informasi destinasi berhasil ditambahkan.</p>
                            <span>Baru saja</span>
                        </div>
                    </div>


                    <div class="activity-item">
                        <div class="activity-icon pink">
                            <i class="bi bi-images"></i>
                        </div>

                        <div class="activity-text">
                            <h4>Galeri diperbarui</h4>
                            <p>Foto destinasi berhasil diperbarui.</p>
                            <span>1 jam yang lalu</span>
                        </div>
                    </div>


                    <div class="activity-item">
                        <div class="activity-icon orange">
                            <i class="bi bi-star-fill"></i>
                        </div>

                        <div class="activity-text">
                            <h4>Ulasan baru</h4>
                            <p>Pengunjung memberikan ulasan baru.</p>
                            <span>3 jam yang lalu</span>
                        </div>
                    </div>


                    <div class="activity-item">
                        <div class="activity-icon green">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>

                        <div class="activity-text">
                            <h4>Pengguna baru</h4>
                            <p>Pengguna baru telah terdaftar.</p>
                            <span>Hari ini</span>
                        </div>
                    </div>

                </div>

            </section>

        </div>


        {{-- =========================
             FOOTER INFO
        ========================== --}}
        <section class="dashboard-info">

            <div class="info-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>

            <div>
                <h4>Kelola Pariwisata Tasikmalaya</h4>
                <p>
                    Gunakan dashboard ini untuk mengelola destinasi,
                    galeri, kuliner, penginapan, event, dan informasi
                    pariwisata lainnya.
                </p>
            </div>

            <i class="bi bi-compass info-decoration"></i>

        </section>

    </div>


    {{-- =========================
         STYLE
    ========================== --}}
    <style>

        :root {
    --primary: #0ea5e9;
    --primary-dark: #0369a1;
            --blue: #2563eb;
            --green: #16a34a;
            --orange: #ea580c;
            --purple: #7c3aed;
            --pink: #db2777;
            --teal: #0f766e;
            --text: #172033;
            --muted: #64748b;
            --border: #e8edf4;
            --bg: #f5f7fb;
            --white: #ffffff;
        }


        .dashboard-wrapper {
            background: var(--bg);
            min-height: calc(100vh - 80px);
            padding: 30px 0 50px;
        }


        /* HEADER */

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .dashboard-header h2 {
            margin: 7px 0 3px;
            font-size: 25px;
            font-weight: 800;
            color: var(--text);
        }

        .dashboard-header p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .dashboard-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 11px;
            border-radius: 30px;
            background: #e9f1ff;
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
        }

        .header-date {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--muted);
            font-size: 13px;
        }


        /* HERO */

        .welcome-section {
    position: relative;
    overflow: hidden;
    max-width: 1280px;
    margin: 0 auto 32px;
    min-height: 260px;
    padding: 42px;
    border-radius: 24px;
    background:
        linear-gradient(110deg, rgba(3,105,161,.92), rgba(14,165,233,.80)),
        url('/images/dashboard-wisata.jpg') center/cover;
    box-shadow: 0 18px 40px rgba(14,165,233,.22);
    color: white;
}
        .welcome-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 22px;
            max-width: 720px;
        }

        .welcome-icon {
            width: 62px;
            height: 62px;
            flex: 0 0 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: rgba(255,255,255,.16);
            backdrop-filter: blur(8px);
            font-size: 27px;
        }

        .welcome-label {
            font-size: 13px;
            opacity: .82;
        }

        .welcome-content h1 {
            margin: 3px 0 7px;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -.7px;
        }

        .welcome-content p {
            margin: 0;
            max-width: 580px;
            font-size: 15px;
            line-height: 1.7;
            opacity: .88;
        }

        .welcome-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .btn-primary-dashboard,
        .btn-light-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 17px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: .25s ease;
        }

        .btn-primary-dashboard {
            color: var(--primary);
            background: white;
        }

        .btn-light-dashboard {
            color: white;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
        }

        .btn-primary-dashboard:hover,
        .btn-light-dashboard:hover {
            transform: translateY(-2px);
        }

        .welcome-decoration {
            position: absolute;
            right: -45px;
            bottom: -80px;
            color: rgba(255,255,255,.07);
            font-size: 300px;
            transform: rotate(-15deg);
        }


        /* SECTION */

        .dashboard-section {
            max-width: 1280px;
            margin: 0 auto 32px;
            padding: 0 20px;
        }

        .section-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 17px;
        }

        .section-label {
            display: block;
            margin-bottom: 3px;
            color: var(--primary);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .section-heading h3,
        .panel-header h3 {
            margin: 0;
            color: var(--text);
            font-size: 20px;
            font-weight: 800;
        }

        .section-description {
            color: var(--muted);
            font-size: 12px;
        }


        /* STATISTICS */

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 17px;
            box-shadow: 0 6px 20px rgba(15,23,42,.035);
            transition: .25s ease;
            text-decoration: none;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(15,23,42,.08);
        }

        .stat-icon,
        .quick-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            font-size: 21px;
        }

        .stat-icon.blue,
        .quick-icon.blue,
        .activity-icon.blue {
            background: #eaf2ff;
            color: #2563eb;
        }

        .stat-icon.green,
        .quick-icon.green,
        .activity-icon.green {
            background: #eaf9ef;
            color: #16a34a;
        }

        .stat-icon.orange,
        .quick-icon.orange,
        .activity-icon.orange {
            background: #fff3e9;
            color: #ea580c;
        }

        .stat-icon.purple,
        .quick-icon.purple {
            background: #f2edff;
            color: #7c3aed;
        }

        .quick-icon.pink,
        .activity-icon.pink {
            background: #fff0f7;
            color: #db2777;
        }

        .quick-icon.teal {
            background: #e8f8f6;
            color: #0f766e;
        }

        .stat-content span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 3px;
        }

        .stat-content strong {
            display: block;
            color: var(--text);
            font-size: 26px;
            line-height: 1;
            font-weight: 800;
        }

        .stat-content small {
            display: block;
            margin-top: 5px;
            color: #64748b;
            font-size: 10px;
        }


        /* QUICK MENU */

        .quick-menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 13px;
        }

        .quick-card {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 17px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            color: var(--text);
            text-decoration: none;
            transition: .25s ease;
        }

        .quick-card:hover {
            transform: translateY(-3px);
            border-color: #cbd8eb;
            box-shadow: 0 12px 25px rgba(15,23,42,.07);
        }

        .quick-icon {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            font-size: 19px;
        }

        .quick-card h4 {
            margin: 0 0 3px;
            font-size: 14px;
            font-weight: 750;
        }

        .quick-card p {
            margin: 0;
            color: var(--muted);
            font-size: 11px;
        }

        .quick-arrow {
            margin-left: auto;
            color: #94a3b8;
            transition: .2s;
        }

        .quick-card:hover .quick-arrow {
            transform: translateX(4px);
            color: var(--primary);
        }


        /* COLUMNS */

        .dashboard-columns {
            max-width: 1280px;
            margin: 0 auto 32px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            gap: 18px;
        }

        .dashboard-panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 6px 20px rgba(15,23,42,.035);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .panel-header a {
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
        }


        /* DESTINATION */

        .destination-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .destination-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 10px;
            border-radius: 13px;
            transition: .2s;
            text-decoration: none;
            color: inherit;
        }

        .destination-item:hover {
            background: #f7f9fc;
        }

        .destination-image {
            width: 66px;
            height: 58px;
            flex: 0 0 66px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: linear-gradient(135deg,#dcecff,#edf4ff);
            color: #7a9ac5;
            font-size: 20px;
            overflow: hidden;
        }

        .destination-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .destination-info {
            min-width: 0;
            flex: 1;
        }

        .destination-info h4 {
            margin: 0 0 4px;
            font-size: 13px;
            font-weight: 750;
        }

        .destination-info span {
            display: block;
            color: var(--muted);
            font-size: 10px;
        }

        .destination-info .rating {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 4px;
            color: #f59e0b;
        }

        .destination-info .rating strong {
            color: #475569;
            font-size: 10px;
        }

        .destination-info .rating small {
            color: #94a3b8;
            font-size: 9px;
        }

        .destination-arrow {
            color: #c0c9d6;
        }


        /* ACTIVITY */

        .activity-list {
            display: flex;
            flex-direction: column;
        }

        .activity-item {
            display: flex;
            gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid #f0f2f6;
        }

        .activity-item:last-child {
            border-bottom: 0;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 13px;
        }

        .activity-text h4 {
            margin: 0 0 2px;
            font-size: 12px;
            font-weight: 750;
        }

        .activity-text p {
            margin: 0;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .activity-text span {
            display: block;
            margin-top: 3px;
            color: #94a3b8;
            font-size: 9px;
        }


        /* INFO */

        .dashboard-info {
            position: relative;
            overflow: hidden;
            max-width: 1280px;
            margin: 0 auto;
            padding: 22px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            background: #eaf2ff;
            border: 1px solid #d6e5ff;
            border-radius: 17px;
        }

        .info-icon {
            width: 45px;
            height: 45px;
            flex: 0 0 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: white;
            color: var(--primary);
            font-size: 18px;
        }

        .dashboard-info h4 {
            margin: 0 0 4px;
            color: var(--primary-dark);
            font-size: 14px;
        }

        .dashboard-info p {
            margin: 0;
            max-width: 850px;
            color: #52657f;
            font-size: 11px;
            line-height: 1.6;
        }

        .info-decoration {
            position: absolute;
            right: 25px;
            color: rgba(13,59,122,.06);
            font-size: 100px;
        }


        /* RESPONSIVE */

        @media (max-width: 1000px) {

            .statistics-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .quick-menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-columns {
                grid-template-columns: 1fr;
            }

            .welcome-section {
                margin-left: 20px;
                margin-right: 20px;
            }

            .dashboard-info {
                margin-left: 20px;
                margin-right: 20px;
            }
        }


        @media (max-width: 640px) {

            .dashboard-wrapper {
                padding-top: 20px;
            }

            .dashboard-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-date {
                display: none;
            }

            .welcome-section {
                min-height: auto;
                padding: 28px 22px;
                border-radius: 18px;
            }

            .welcome-content {
                align-items: flex-start;
                flex-direction: column;
            }

            .welcome-content h1 {
                font-size: 28px;
            }

            .welcome-actions {
                flex-direction: column;
            }

            .btn-primary-dashboard,
            .btn-light-dashboard {
                justify-content: center;
                width: 100%;
            }

            .statistics-grid,
            .quick-menu-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-panel {
                padding: 17px;
            }

            .destination-image {
                width: 56px;
                height: 52px;
                flex-basis: 56px;
            }

            .dashboard-info {
                align-items: flex-start;
                padding: 18px;
            }

            .info-decoration {
                display: none;
            }
        }

    </style>
</x-app-layout>