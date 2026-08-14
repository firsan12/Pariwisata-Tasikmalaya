@extends('layouts.site')
@section('title', ' Wisata Tasikmalaya - Beranda')
@section('content')

{{--
    CATATAN DATA UNTUK SECTION BARU DI BAWAH:
    - $kategoriWisata : koleksi kategori wisata (fallback dummy jika belum dikirim dari controller)
    - $events         : koleksi event/promo (fallback dummy)
    - $testimonis     : koleksi testimoni (fallback dummy)
    - $profilSitus    : teks Hero & Kontak (dari tabel profil_situs, fallback teks lama)
    - $berandaStatistik : kartu statistik animasi (dari tabel beranda_statistik, fallback dummy)
    - $keunggulan     : poin "Mengapa Memilih Kami" (dari tabel keunggulan, fallback dummy)
    - $destinasiPeta  : destinasi yang punya latitude/longitude, untuk peta interaktif (Leaflet)
    Section Hero dan Kontak (ringkas) TETAP memakai class CSS & markup asli project
    (hero-tasik-foto, kontak-section) — hanya teksnya sekarang dari database.
--}}
@php
    $kategoriList = $kategoriWisata ?? collect([
        ['emoji'=>'🏖','nama'=>'Pantai'],
        ['emoji'=>'🌋','nama'=>'Gunung'],
        ['emoji'=>'🕌','nama'=>'Religi'],
        ['emoji'=>'🏛','nama'=>'Budaya'],
        ['emoji'=>'🍜','nama'=>'Kuliner'],
    ]);

   $eventList = $events ?? collect([
    ['judul'=>'Festival Budaya Tasikmalaya','promo'=>'Diskon 20%','gambar'=>null,'tanggal_mulai'=>null,'tanggal_selesai'=>null],
    ['judul'=>'Wisata Religi Ramadan','promo'=>'Diskon 15%','gambar'=>null,'tanggal_mulai'=>null,'tanggal_selesai'=>null],
]);

    $testimoniList = $testimonis ?? collect([
        ['nama'=>'Firman','isi'=>'Sangat mudah membeli tiket, prosesnya cepat.'],
        ['nama'=>'Andi','isi'=>'Tempat wisatanya bagus dan terawat.'],
        ['nama'=>'Sinta','isi'=>'Pelayanan ramah, akan booking lagi lain kali.'],
    ]);

    $statistikList = (isset($berandaStatistik) && count($berandaStatistik) > 0) ? $berandaStatistik : collect([
        ['ikon'=>'bi-geo-alt-fill','nilai'=>15,'desimal'=>0,'suffix'=>null,'label'=>'Destinasi'],
        ['ikon'=>'bi-people-fill','nilai'=>50000,'desimal'=>0,'suffix'=>'+','label'=>'Wisatawan'],
        ['ikon'=>'bi-star-fill','nilai'=>4.8,'desimal'=>1,'suffix'=>null,'label'=>'Rating'],
        ['ikon'=>'bi-ticket-perforated-fill','nilai'=>300,'desimal'=>0,'suffix'=>'+','label'=>'Tiket/Hari'],
    ]);

    $keunggulanList = (isset($keunggulan) && count($keunggulan) > 0) ? $keunggulan : collect([
        ['ikon'=>'bi-check-circle-fill','judul'=>'Booking Online'],
        ['ikon'=>'bi-lightning-charge-fill','judul'=>'Cepat'],
        ['ikon'=>'bi-shield-lock-fill','judul'=>'Aman'],
        ['ikon'=>'bi-star-fill','judul'=>'Rating Terpercaya'],
        ['ikon'=>'bi-geo-alt-fill','judul'=>'Destinasi Lengkap'],
        ['ikon'=>'bi-ticket-perforated-fill','judul'=>'Tiket Digital'],
    ]);

    $kontakJudul = (isset($profilSitus) && $profilSitus->kontak_judul) ? $profilSitus->kontak_judul : 'Ada Pertanyaan atau Saran?';
    $kontakIntro = (isset($profilSitus) && $profilSitus->kontak_intro) ? $profilSitus->kontak_intro : 'Kirimkan pesan Anda kepada kami, atau hubungi langsung lewat kontak yang tersedia.';

    $heroDeskripsi = (isset($profilSitus) && $profilSitus->hero_deskripsi) ? $profilSitus->hero_deskripsi
        : 'Temukan wisata, kuliner, budaya, dan pengalaman terbaik di Tasikmalaya.';
    $heroTrustDestinasi = (isset($profilSitus) && $profilSitus->hero_trust_destinasi) ? $profilSitus->hero_trust_destinasi : '🗺️ 15+ Destinasi Pilihan';
    $heroTrustWisatawan = (isset($profilSitus) && $profilSitus->hero_trust_wisatawan) ? $profilSitus->hero_trust_wisatawan : '⭐ Dipercaya 50K+ Wisatawan Setiap Tahun';
@endphp

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    /* ===== Marquee Destinasi (geser otomatis tanpa henti) — TIDAK DIUBAH ===== */
    .marquee-outer {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    .marquee-track {
        display: flex;
        gap: 1.5rem;
        width: max-content;
        animation: marqueeScroll var(--marquee-durasi, 30s) linear infinite;
    }
    .marquee-track:hover {
        animation-play-state: paused;
    }
    .marquee-track .kartu {
        flex: 0 0 300px;
        width: 300px;
    }
    @keyframes marqueeScroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }
    @media (max-width: 576px) {
        .marquee-track .kartu {
            flex: 0 0 260px;
            width: 260px;
        }
    }

    /* ===== Info slot tiket pada kartu destinasi — disamakan dengan destinasi.blade.php ===== */
    .slot-info-ringkas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
        font-size: 0.85rem;
    }

    .slot-info-ringkas .slot-text {
        font-weight: 600;
        color: #1e3a8a;
    }

    .slot-info-ringkas .slot-text.hampir-habis { color: #ea580c; }
    .slot-info-ringkas .slot-text.habis { color: #dc2626; }

    .slot-info-ringkas .slot-persen {
        color: #94a3b8;
        font-size: 0.8rem;
    }

    .progress-slot {
        height: 6px;
        width: 100%;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
        margin-top: 0.4rem;
    }

    .progress-slot-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #1e3a8a, #3b82f6);
        transition: width 0.5s ease;
    }

    .progress-slot-bar.hampir-habis {
        background: linear-gradient(90deg, #ea580c, #f59e0b);
    }

    .progress-slot-bar.habis {
        background: linear-gradient(90deg, #991b1b, #dc2626);
    }

    /* =====================================================================
       SECTION BARU — dinamespace "jt-" agar tidak bentrok dengan CSS project.
       ===================================================================== */
    :root{
        --jt-primary:#0d3b7a; --jt-primary-dark:#092a58; --jt-secondary:#4a90c2;
        --jt-light:#a8d8f0; --jt-accent:#D4A857; --jt-accent-dark:#B4863A;
        --jt-bg:#F4F8FB; --jt-text:#1E293B;
        --jt-radius-card:24px; --jt-radius-btn:16px;
        --jt-shadow:0 20px 40px rgba(13,59,122,.12);
    }
    .jt-section{ font-family:'Inter',sans-serif; color:var(--jt-text); padding:80px 0; }
    .jt-section h2,.jt-section h3{ font-family:'Poppins',sans-serif; }
    .jt-bg-soft{ background:var(--jt-bg); }
    .jt-head{ text-align:center; max-width:600px; margin:0 auto 44px; }
    .jt-head h2{ font-size:36px; font-weight:700; margin-bottom:10px; color:var(--jt-primary); }
    .jt-head p{ color:#5b7391; font-size:16px; }

    .jt-fade-up{ opacity:0; transform:translateY(40px); transition:all .8s cubic-bezier(.2,.8,.2,1); }
    .jt-fade-up.jt-in-view{ opacity:1; transform:translateY(0); }

    .jt-section-navy{
        position:relative;
        overflow:hidden;
        padding:70px 0;
        background:
            radial-gradient(ellipse at center, rgba(0,0,0,0) 40%, rgba(9,42,88,.35) 100%),
            linear-gradient(160deg, var(--jt-primary) 0%, var(--jt-secondary) 55%, var(--jt-primary-dark) 100%);
    }
    .jt-stat-card{
        background:rgba(255,255,255,.10);
        backdrop-filter:blur(14px);
        -webkit-backdrop-filter:blur(14px);
        border:1px solid rgba(255,255,255,.22);
        border-radius:var(--jt-radius-card);
        box-shadow:0 20px 40px rgba(0,0,0,.18);
        padding:32px 20px;
        text-align:center;
    }
    .jt-stat-card i{ font-size:1.8rem; color:var(--jt-accent); margin-bottom:10px; display:block; }
    .jt-stat-card .jt-num{ font-size:2.2rem; font-weight:800; color:#ffffff; }
    .jt-stat-card .jt-label{ color:#dceaf5; font-size:.9rem; }

    .jt-kategori-card{
    background:#fff; border-radius:20px; padding:36px 16px; text-align:center; cursor:pointer;
    box-shadow:0 8px 20px rgba(13,59,122,.08); border-top:3px solid transparent;
    transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    display:block; text-decoration:none;

    }
    .jt-kategori-card:hover{ transform:scale(1.05); box-shadow:var(--jt-shadow); border-top-color:var(--jt-accent); }
    .jt-kategori-card .jt-emoji{ font-size:2.4rem; margin-bottom:10px; display:block; }
    .jt-kategori-card .jt-nama{ font-weight:600; color:var(--jt-primary); }

    .jt-alasan-item{ display:flex; align-items:center; gap:16px; padding:20px 0; border-bottom:1px dashed #dbe6f0; }
    .jt-alasan-item i{ font-size:1.5rem; color:var(--jt-primary); width:44px; height:44px; border-radius:12px; background:#eaf1ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .jt-alasan-item .jt-judul{ font-weight:600; }

    .jt-slider-track{ display:flex; gap:20px; overflow-x:auto; scroll-snap-type:x mandatory; padding-bottom:10px; scrollbar-width:none; }
.jt-slider-track::-webkit-scrollbar{ display:none; }
.jt-slider-track > *{ scroll-snap-align:start; flex-shrink:0; }

.jt-event-card{
    width:300px; border-radius:20px; overflow:hidden; position:relative;
    background:#fff; text-decoration:none; display:block; color:inherit;
    box-shadow:0 10px 26px rgba(13,59,122,.12); border:1px solid #eaf1f8;
    transition:transform .3s ease, box-shadow .3s ease;
}
.jt-event-card:hover{ transform:translateY(-6px); box-shadow:0 18px 36px rgba(13,59,122,.2); }
.jt-event-media{
    height:150px; background:linear-gradient(135deg,var(--jt-primary),var(--jt-secondary)); background-size:cover; background-position:center;
    display:flex; align-items:center; justify-content:center; color:#fff; font-size:2rem;
}
.jt-event-card .jt-promo-badge{
    position:absolute; top:14px; right:14px; background:var(--jt-accent); color:#0d3b7a;
    font-size:.75rem; font-weight:700; padding:5px 12px; border-radius:20px; box-shadow:0 4px 10px rgba(0,0,0,.15);
}
.jt-event-body{ padding:18px 20px 22px; }
.jt-event-tanggal{ display:flex; align-items:center; gap:6px; font-size:.78rem; color:#5b7391; font-weight:600; margin-bottom:8px; }
.jt-event-body h5{ font-weight:700; color:var(--jt-primary); margin-bottom:14px; min-height:44px; }
.jt-event-cta{ color:var(--jt-secondary); font-weight:600; font-size:.85rem; display:inline-flex; align-items:center; gap:6px; }
.jt-event-card:hover .jt-event-cta{ gap:10px; }

.jt-event-empty{ width:100%; text-align:center; padding:50px 20px; color:#5b7391; }
.jt-event-empty i{ font-size:2.2rem; display:block; margin-bottom:12px; color:var(--jt-secondary); }

.jt-slider-nav{ display:flex; gap:10px; justify-content:center; margin-top:16px; }
.jt-slider-nav button{ width:38px; height:38px; border-radius:50%; border:1.5px solid #dbe6f0; background:#fff; color:var(--jt-primary); cursor:pointer; }
.jt-slider-nav button:hover{ border-color:var(--jt-primary); color:var(--jt-primary); background:#eaf1ff; }

    .jt-testi-card{ width:340px; background:#fff; border-radius:20px; box-shadow:var(--jt-shadow); padding:28px; border-top:3px solid var(--jt-accent); }
    .jt-testi-card .jt-stars{ color:var(--jt-accent); margin-bottom:12px; }
    .jt-testi-card p{ color:#475569; font-style:italic; margin-bottom:16px; }
    .jt-testi-card .jt-nama{ font-weight:700; color:var(--jt-primary); }

    .jt-cta-section{
        background:
            radial-gradient(ellipse at center, rgba(0,0,0,0) 40%, rgba(9,42,88,.3) 100%),
            linear-gradient(135deg,var(--jt-primary),var(--jt-secondary));
        color:#fff; text-align:center; padding:70px 20px; border-radius:32px; margin:0 20px;
        box-shadow:0 20px 45px rgba(13,59,122,.3);
    }
    .jt-cta-section h2{ font-size:2.2rem; font-weight:800; margin-bottom:10px; }
    .jt-cta-section p{ opacity:.9; margin-bottom:26px; }
    .jt-btn-cta{ background:#fff; color:var(--jt-primary); font-weight:700; padding:15px 36px; border-radius:var(--jt-radius-btn); text-decoration:none; transition:.25s ease; display:inline-block; }
    .jt-btn-cta:hover{ transform:scale(1.04); color:var(--jt-primary-dark); }

    /* ===== Peta interaktif "Explore Tasikmalaya" ===== */
    .wt-peta-tasik {
        width: 100%;
        height: 480px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(13,59,122,.12);
        border: 1px solid #e2e8f0;
    }

    .wt-peta-marker i {
        font-size: 32px;
        color: #0d3b7a;
        text-shadow: 0 2px 4px rgba(0,0,0,.25);
    }

    .leaflet-popup-content-wrapper {
        border-radius: 12px;
    }
</style>

<!-- ===== HERO ===== -->
<section class="hero-tasik-foto d-flex align-items-center text-center text-white">
    <div class="hero-overlay"></div>

    <div class="container position-relative hero-content" style="z-index: 2;">
        <span class="hero-tagline">Platform Wisata, Kuliner & Tiket</span>

        <h1 class="display-4 fw-bold mb-3 hero-judul">
            Jelajahi Pesona <span class="hero-nama">Tasikmalaya</span>
        </h1>

        <p class="lead mx-auto hero-deskripsi" style="max-width: 620px;">
            {{ $heroDeskripsi }}
        </p>

        <form action="{{ route('destinasi') }}" method="GET" class="wt-hero-search mx-auto">
            <i class="bi bi-search"></i>
            <input type="text" name="cari" class="form-control border-0" placeholder="Cari destinasi, kuliner, atau pengalaman...">
            <button type="submit" class="btn-hero-cta wt-hero-search-btn">Cari</button>
        </form>

        <div class="wt-hero-quicklinks">
            <a href="{{ route('destinasi') }}"><span>🏔️</span> Wisata</a>
           <a href="{{ route('kuliner.katalog') }}"><span>🍜</span> Kuliner</a>
            <a href="{{ route('pesan-tiket') }}"><span>🎟️</span> Tiket</a>
            <a href="{{ route('beranda') }}#event-promo"><span>🎉</span> Event</a>
        </div>

        <div class="hero-trust">
            <span>{{ $heroTrustDestinasi }}</span>
            <span class="hero-trust-dot">•</span>
            <span>{{ $heroTrustWisatawan }}</span>
        </div>
    </div>

    <div class="scroll-indicator">
        <span></span>
    </div>
</section>

<!-- ===== STATISTIK ===== -->
<section class="jt-section-navy">
    <div class="container">
        <div class="row g-4">
            @foreach ($statistikList as $stat)
                @php
                    $statIkon    = is_array($stat) ? $stat['ikon'] : $stat->ikon;
                    $statNilai   = is_array($stat) ? $stat['nilai'] : $stat->nilai;
                    $statDesimal = is_array($stat) ? ($stat['desimal'] ?? 0) : $stat->desimal;
                    $statSuffix  = is_array($stat) ? ($stat['suffix'] ?? '') : $stat->suffix;
                    $statLabel   = is_array($stat) ? $stat['label'] : $stat->label;
                @endphp
                <div class="col-6 col-md-3 jt-fade-up">
                    <div class="jt-stat-card"><i class="bi {{ $statIkon }}"></i>
                        <div class="jt-num" data-jt-count="{{ $statNilai }}" data-jt-decimal="{{ $statDesimal }}" data-jt-suffix="{{ $statSuffix }}">0</div>
                        <div class="jt-label">{{ $statLabel }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== KATEGORI WISATA ===== -->
<section class="jt-section jt-bg-soft">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Kategori Wisata</h2>
            <p>Pilih jenis wisata sesuai keinginanmu</p>
        </div>
        <div class="row g-3">
           @foreach ($kategoriList as $kat)
    @php
        $namaKat = is_array($kat) ? $kat['nama'] : $kat->nama;
        $emojiKat = is_array($kat) ? $kat['emoji'] : $kat->emoji;
        $urlKat = strtolower($namaKat) === 'kuliner'
            ? route('kuliner.katalog')
            : route('destinasi') . '?cari=' . urlencode($namaKat);
    @endphp
    <div class="col-6 col-md-4 col-lg jt-fade-up">
        <a href="{{ $urlKat }}" class="jt-kategori-card">
            <span class="jt-emoji">{{ $emojiKat }}</span>
            <div class="jt-nama">{{ $namaKat }}</div>
        </a>
    </div>
@endforeach
        </div>
    </div>
</section>

<!-- ===== DESTINASI UNGGULAN ===== -->
<section class="destinasi-section py-5">
    <div class="destinasi-bg"></div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="text-center mb-5 destinasi-heading">
            <span class="destinasi-label">Jelajahi</span>
            <h2 class="fw-bold text-white mb-2">Destinasi Wisata Pilihan</h2>
            <p class="destinasi-subtitle mx-auto">
                Beberapa destinasi favorit yang paling banyak dikunjungi wisatawan.
            </p>
        </div>

        @if ($destinasiUnggulan->count() > 0)

            <div class="marquee-outer" style="--marquee-durasi: {{ max($destinasiUnggulan->count() * 6, 20) }}s;">
                <div class="marquee-track">

                    {{-- Set pertama --}}
                    @foreach ($destinasiUnggulan as $destinasi)
                        @php
                            $jamBuka  = \Carbon\Carbon::parse($destinasi->jam_buka);
                            $jamTutup = \Carbon\Carbon::parse($destinasi->jam_tutup);
                        @endphp

                        <div class="kartu">
                            <div class="kartu-img-wrap">
                                <img src="{{ asset('storage/' . $destinasi->gambar) }}" alt="Foto {{ $destinasi->nama }}">
                                <span class="badge-status {{ $destinasi->is_buka ? 'buka' : 'tutup' }}">
                                    <span class="badge-dot"></span> {{ $destinasi->is_buka ? 'Sedang buka' : 'Sedang tutup' }}
                                </span>
                                <span class="badge-harga">Mulai Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</span>
                            </div>

                            <h3>{{ $destinasi->nama }}</h3>
                            <p>{{ Str::limit($destinasi->deskripsi, 100) }}</p>
                            <p class="jam-info">
                                Jam operasional: {{ $jamBuka->format('H:i') }} – {{ $jamTutup->format('H:i') }} WIB
                            </p>

                            <div class="slot-info-ringkas">
                                @if ($destinasi->ket_slot === 'habis')
                                    <span class="slot-text habis">Tiket habis</span>
                                @elseif ($destinasi->ket_slot === 'hampir_habis')
                                    <span class="slot-text hampir-habis">Tersisa {{ $destinasi->sisa_slot }} slot lagi!</span>
                                @else
                                    <span class="slot-text">{{ $destinasi->sisa_slot }} slot tersedia</span>
                                @endif
                                <span class="slot-persen">{{ $destinasi->persen_terisi }}% terisi</span>
                            </div>
                            <div class="progress-slot">
                                <div class="progress-slot-bar {{ str_replace('_', '-', $destinasi->ket_slot) }}"
                                     style="width: {{ max($destinasi->persen_terisi, 2) }}%"></div>
                            </div>

                            <div class="kartu-aksi">
                                <a href="{{ route('destinasi.detail', $destinasi->id) }}" class="btn-detail">Lihat Detail</a>
                                @if ($destinasi->ket_slot === 'habis')
                                    <span class="btn-pesan disabled" aria-disabled="true">Tiket Habis</span>
                                @else
                                    <a href="{{ route('pesan-tiket') }}?d={{ $destinasi->id }}" class="btn-pesan">Pesan Tiket</a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Set kedua (duplikat, supaya loop marquee terlihat mulus tanpa jeda) --}}
                    @foreach ($destinasiUnggulan as $destinasi)
                        @php
                            $jamBuka  = \Carbon\Carbon::parse($destinasi->jam_buka);
                            $jamTutup = \Carbon\Carbon::parse($destinasi->jam_tutup);
                        @endphp

                        <div class="kartu" aria-hidden="true">
                            <div class="kartu-img-wrap">
                                <img src="{{ asset('storage/' . $destinasi->gambar) }}" alt="Foto {{ $destinasi->nama }}">
                                <span class="badge-status {{ $destinasi->is_buka ? 'buka' : 'tutup' }}">
                                    <span class="badge-dot"></span> {{ $destinasi->is_buka ? 'Sedang buka' : 'Sedang tutup' }}
                                </span>
                                <span class="badge-harga">Mulai Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</span>
                            </div>

                            <h3>{{ $destinasi->nama }}</h3>
                            <p>{{ Str::limit($destinasi->deskripsi, 100) }}</p>
                            <p class="jam-info">
                                Jam operasional: {{ $jamBuka->format('H:i') }} – {{ $jamTutup->format('H:i') }} WIB
                            </p>

                            <div class="slot-info-ringkas">
                                @if ($destinasi->ket_slot === 'habis')
                                    <span class="slot-text habis">Tiket habis</span>
                                @elseif ($destinasi->ket_slot === 'hampir_habis')
                                    <span class="slot-text hampir-habis">Tersisa {{ $destinasi->sisa_slot }} slot lagi!</span>
                                @else
                                    <span class="slot-text">{{ $destinasi->sisa_slot }} slot tersedia</span>
                                @endif
                                <span class="slot-persen">{{ $destinasi->persen_terisi }}% terisi</span>
                            </div>
                            <div class="progress-slot">
                                <div class="progress-slot-bar {{ str_replace('_', '-', $destinasi->ket_slot) }}"
                                     style="width: {{ max($destinasi->persen_terisi, 2) }}%"></div>
                            </div>

                            <div class="kartu-aksi">
                                <a href="{{ route('destinasi.detail', $destinasi->id) }}" class="btn-detail" tabindex="-1">Lihat Detail</a>
                                @if ($destinasi->ket_slot === 'habis')
                                    <span class="btn-pesan disabled" aria-disabled="true">Tiket Habis</span>
                                @else
                                    <a href="{{ route('pesan-tiket') }}?d={{ $destinasi->id }}" class="btn-pesan" tabindex="-1">Pesan Tiket</a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        @else
            <p class="text-center text-white mb-0">Belum ada destinasi untuk ditampilkan.</p>
        @endif

        <div class="text-center mt-5">
            <a href="{{ route('destinasi') }}" class="btn-lihat-semua">Lihat Semua Destinasi & Cari Tiket →</a>
        </div>
    </div>
</section>

<!-- ===== KULINER POPULER ===== -->
<section class="py-5 wt-kuliner-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="destinasi-label">Cita Rasa Lokal</span>
            <h2 class="fw-bold">Kuliner Populer</h2>
            <p class="text-muted">Cicipi kelezatan khas Tasikmalaya</p>
        </div>

        @if (isset($kulinerPopuler) && count($kulinerPopuler) > 0)
            <div class="row g-4">
                @foreach ($kulinerPopuler as $kuliner)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('kuliner.detail', $kuliner) }}" class="wt-kuliner-card">
                            <div class="wt-kuliner-img">
                               <img src="{{ $kuliner->foto_url ?: asset('images/placeholder-kuliner.jpg') }}" alt="{{ $kuliner->nama }}" loading="lazy">
                            </div>
                            <div class="wt-kuliner-body">
                                <h6>{{ $kuliner->nama }}</h6>
                                <p class="wt-kuliner-alamat"><i class="bi bi-geo-alt"></i> {{ Str::limit($kuliner->alamat, 28) }}</p>
                                <span class="wt-kuliner-harga">Mulai Rp{{ number_format($kuliner->harga_mulai, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted mb-0">Belum ada kuliner untuk ditampilkan.</p>
        @endif

        <div class="text-center mt-5">
           <a href="{{ route('kuliner.katalog') }}" class="btn-lihat-semua">Lihat Semua Kuliner →</a>
        </div>
    </div>
</section>

<!-- ===== EXPLORE TASIKMALAYA — peta interaktif Leaflet ===== -->
<section class="py-5 wt-explore-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="destinasi-label">Jelajahi Peta</span>
            <h2 class="fw-bold">Explore Tasikmalaya</h2>
            <p class="text-muted">Lihat sebaran destinasi di berbagai penjuru Tasikmalaya</p>
        </div>

        @if (isset($destinasiPeta) && $destinasiPeta->count() > 0)
            <div id="peta-tasik" class="wt-peta-tasik"></div>
        @else
            <div class="wt-explore-placeholder">
                <i class="bi bi-map"></i>
                <p class="mb-1 fw-semibold">Peta belum tersedia</p>
                <p class="text-muted mb-3">Koordinat destinasi belum ditambahkan. Sementara itu, jelajahi destinasi lewat daftar lengkap kami.</p>
                <a href="{{ route('destinasi') }}" class="btn-lihat-semua">Lihat Daftar Destinasi →</a>
            </div>
        @endif
    </div>
</section>

<!-- ===== MENGAPA MEMILIH KAMI ===== -->
<section class="jt-section jt-bg-soft">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Mengapa Memilih Kami</h2>
            <p>Alasan wisatawan mempercayakan liburannya bersama kami</p>
        </div>
        <div class="row">
            @foreach ($keunggulanList as $item)
                <div class="col-md-4 jt-fade-up">
                    <div class="jt-alasan-item">
                        <i class="bi {{ is_array($item) ? $item['ikon'] : $item->ikon }}"></i>
                        <div class="jt-judul">{{ is_array($item) ? $item['judul'] : $item->judul }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== EVENT / PROMO ===== -->
<section class="jt-section" id="event-promo">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Event &amp; Promo</h2>
            <p>Jangan lewatkan penawaran spesial dari kami</p>
        </div>
       <div class="jt-slider-track" id="jtEventSlider">
    @forelse ($eventList as $event)
        @php
            $judul      = is_array($event) ? $event['judul'] : $event->judul;
            $promo      = is_array($event) ? $event['promo'] : $event->promo;
            $gambar     = is_array($event) ? ($event['gambar'] ?? null) : $event->gambar;
            $tglMulai   = is_array($event) ? ($event['tanggal_mulai'] ?? null) : $event->tanggal_mulai;
            $tglSelesai = is_array($event) ? ($event['tanggal_selesai'] ?? null) : $event->tanggal_selesai;
            $eventId    = is_array($event) ? ($event['id'] ?? null) : $event->id;
        @endphp
        <a href="{{ $eventId ? route('event.detail', $eventId) : '#' }}" class="jt-event-card jt-fade-up">
            <div class="jt-event-media" @if($gambar) style="background-image:url('{{ asset('storage/' . $gambar) }}');" @endif>
                @unless ($gambar)
                    <i class="bi bi-calendar-event"></i>
                @endunless
            </div>
            <span class="jt-promo-badge">{{ $promo }}</span>
            <div class="jt-event-body">
                @if ($tglMulai)
                    <span class="jt-event-tanggal">
                        <i class="bi bi-calendar3"></i>
                        {{ \Carbon\Carbon::parse($tglMulai)->translatedFormat('d M Y') }}
                        @if ($tglSelesai && $tglSelesai != $tglMulai)
                            &ndash; {{ \Carbon\Carbon::parse($tglSelesai)->translatedFormat('d M Y') }}
                        @endif
                    </span>
                @endif
                <h5>{{ $judul }}</h5>
                <span class="jt-event-cta">Lihat Detail <i class="bi bi-arrow-right"></i></span>
            </div>
        </a>
    @empty
        <div class="jt-event-empty">
            <i class="bi bi-calendar-x"></i>
            <p class="mb-0">Belum ada event atau promo saat ini. Nantikan info terbaru dari kami!</p>
        </div>
    @endforelse
</div>
        <div class="jt-slider-nav">
            <button onclick="document.getElementById('jtEventSlider').scrollBy({left:-360,behavior:'smooth'})"><i class="bi bi-chevron-left"></i></button>
            <button onclick="document.getElementById('jtEventSlider').scrollBy({left:360,behavior:'smooth'})"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- ===== TESTIMONI ===== -->
<section class="jt-section jt-bg-soft">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Testimoni</h2>
            <p>Apa kata mereka yang sudah berkunjung</p>
        </div>
        <div class="jt-slider-track" id="jtTestiSlider">
            @foreach ($testimoniList as $testi)
                <div class="jt-testi-card jt-fade-up">
                    <div class="jt-stars">@for($i=1;$i<=5;$i++)<i class="bi bi-star-fill"></i>@endfor</div>
                    <p>"{{ is_array($testi) ? $testi['isi'] : $testi->isi }}"</p>
                    <div class="jt-nama">{{ is_array($testi) ? $testi['nama'] : $testi->nama }}</div>
                </div>
            @endforeach
        </div>
        <div class="jt-slider-nav">
            <button onclick="document.getElementById('jtTestiSlider').scrollBy({left:-360,behavior:'smooth'})"><i class="bi bi-chevron-left"></i></button>
            <button onclick="document.getElementById('jtTestiSlider').scrollBy({left:360,behavior:'smooth'})"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- ===== KONTAK (ringkas) ===== -->
<section class="kontak-section py-5">
    <div class="kontak-bg"></div>

    <div class="container kontak-content position-relative" style="z-index: 2;">
        <div class="text-center mb-5">
            <span class="kontak-label">Hubungi Kami</span>
            <h2 class="fw-bold text-white mb-2">{{ $kontakJudul }}</h2>
            <p class="kontak-intro mx-auto">
                {{ $kontakIntro }}
            </p>
        </div>

        <div class="kontak-card mx-auto" style="max-width: 600px;">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kontak.send') }}" method="POST" id="formKontakBeranda">
                @csrf

                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="namaBeranda" name="nama" placeholder="Nama" required>
                    <label for="namaBeranda">Nama</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="email" class="form-control" id="emailBeranda" name="email" placeholder="Email" required>
                    <label for="emailBeranda">Email</label>
                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" id="pesanBeranda" name="pesan" placeholder="Pesan" style="height: 120px" required></textarea>
                    <label for="pesanBeranda">Pesan</label>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">
                    <button type="button" id="btnWhatsappBeranda" class="btn btn-kirim w-100">
                        <i class="bi bi-whatsapp"></i> <span>Kirim via WhatsApp</span>
                    </button>

                    <button type="submit" class="btn btn-kirim w-100">
                        <i class="bi bi-send-fill"></i> <span>Kirim ke Email</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var nomorWhatsapp = '{{ $kontakWhatsapp ?? ($profilSitus->kontak_whatsapp ?? "6281261604202") }}';

    var namaInput  = document.getElementById('namaBeranda');
    var emailInput = document.getElementById('emailBeranda');
    var pesanInput = document.getElementById('pesanBeranda');
    var btnWa      = document.getElementById('btnWhatsappBeranda');

    if (btnWa) {
        btnWa.addEventListener('click', function () {
            if (!namaInput.value.trim() || !emailInput.value.trim() || !pesanInput.value.trim()) {
                alert('Mohon lengkapi semua field terlebih dahulu.');
                return;
            }

            var teks = `Halo, saya ${namaInput.value}%0A` +
                       `Email: ${emailInput.value}%0A` +
                       `Pesan: ${pesanInput.value}`;

            window.open(`https://wa.me/${nomorWhatsapp}?text=${teks}`, '_blank');
        });
    }
});
</script>

<!-- ===== CTA BOOKING ===== -->
<section class="jt-section">
    <div class="container">
        <div class="jt-cta-section jt-fade-up">
            <h2>Siap Berlibur?</h2>
            <p>Pesan tiket sekarang dan nikmati pengalaman wisata terbaik.</p>
            <a href="{{ route('destinasi') }}" class="jt-btn-cta">Pesan Sekarang</a>
        </div>
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fade-up saat section baru terlihat di viewport
    var jtFadeEls = document.querySelectorAll('.jt-fade-up');
    var jtFadeObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('jt-in-view');
                jtFadeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    jtFadeEls.forEach(function (el) { jtFadeObserver.observe(el); });

    // Counter animasi untuk section Statistik
    var jtCounters = document.querySelectorAll('[data-jt-count]');
    var jtCounterObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var el = entry.target;
            var target = parseFloat(el.dataset.jtCount);
            var decimal = parseInt(el.dataset.jtDecimal || '0', 10);
            var suffix = el.dataset.jtSuffix || '';
            var duration = 1400;
            var start = performance.now();

            function tick(now) {
                var progress = Math.min((now - start) / duration, 1);
                var value = target * progress;
                el.textContent = (decimal > 0 ? value.toFixed(decimal) : Math.floor(value).toLocaleString('id-ID')) + suffix;
                if (progress < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
            jtCounterObserver.unobserve(el);
        });
    }, { threshold: 0.4 });
    jtCounters.forEach(function (el) { jtCounterObserver.observe(el); });

    // Peta interaktif "Explore Tasikmalaya"
    @if (isset($destinasiPeta) && $destinasiPeta->count() > 0)
    var destinasiData = @json($destinasiPeta);
    var petaEl = document.getElementById('peta-tasik');

    if (petaEl && destinasiData.length > 0) {
        var avgLat = destinasiData.reduce((sum, d) => sum + parseFloat(d.latitude), 0) / destinasiData.length;
        var avgLng = destinasiData.reduce((sum, d) => sum + parseFloat(d.longitude), 0) / destinasiData.length;

        var map = L.map('peta-tasik').setView([avgLat, avgLng], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        var markerIcon = L.divIcon({
            className: 'wt-peta-marker',
            html: '<i class="bi bi-geo-alt-fill"></i>',
            iconSize: [32, 32],
            iconAnchor: [16, 32]
        });

        destinasiData.forEach(function (d) {
            var marker = L.marker([parseFloat(d.latitude), parseFloat(d.longitude)], { icon: markerIcon }).addTo(map);
            marker.bindPopup(
                '<strong>' + d.nama + '</strong><br>' +
                '<a href="/destinasi/' + d.id + '" style="color:#0d3b7a;font-weight:600;">Lihat Detail →</a>'
            );
        });
    }
    @endif
});
</script>

@endsection