@extends('layouts.site')
@section('title', ' Wisata Tasikmalaya - Beranda')
@section('content')

<?php
    date_default_timezone_set("Asia/Jakarta");
    $nama = "Wisata Tasikmalaya";

    // Sebelumnya: date("H.I.S") -- "I" (kapital) itu bukan menit, tapi status DST (0/1),
    // jadi hasilnya bukan jam sungguhan. Dipakai hanya untuk sapaan di hero, jadi cukup
    // ambil jam (0-23) sebagai angka.
    $jamSekarang = (int) date("H");

    if ($jamSekarang < 10) {
        $ucapan  = "Selamat Pagi";
        $tagline = "Udara Sejuk Menyambut Langkah Pertamamu";
    } else if ($jamSekarang < 15) {
        $ucapan  = "Selamat Siang";
        $tagline = "Saatnya Menjelajah di Bawah Langit Tasikmalaya";
    } else if ($jamSekarang < 18) {
        $ucapan  = "Selamat Sore";
        $tagline = "Senja Terbaik Menanti di Ujung Perjalanan";
    } else {
        $ucapan  = "Selamat Malam";
        $tagline = "Kisah Perjalanan Dimulai dari Sini";
    }
?>

{{--
    CATATAN DATA UNTUK SECTION BARU DI BAWAH:
    - $kategoriWisata : koleksi kategori wisata (fallback dummy jika belum dikirim dari controller)
    - $events         : koleksi event/promo (fallback dummy)
    - $testimonis     : koleksi testimoni (fallback dummy)
    Section Hero, Tentang, dan Kontak TIDAK diubah — tetap memakai data & class CSS asli project
    (hero-tasik-foto, tentang, kontak-section).

    PEMBARUAN:
    - Section "Destinasi Unggulan" SEKARANG DINAMIS PENUH, disamakan dengan kartu di
      destinasi.blade.php: badge status buka/tutup, badge harga termurah, jam operasional,
      info slot tiket (ket_slot / sisa_slot / persen_terisi) + progress bar, dan tombol
      "Pesan Tiket" / "Tiket Habis" kondisional. Partial 'partials.destinasi-card' TIDAK
      dipakai lagi di sini — markup kartu ditulis langsung (inline), persis pola di halaman
      Destinasi, supaya kedua halaman konsisten.
    - Layout diganti ke layouts.site (khusus halaman publik), karena layouts.app
      adalah layout Breeze berbasis komponen (<x-app-layout>) untuk area dashboard,
      dan tidak cocok dipakai lewat @extends.
    - Footer "jt-footer" DIHAPUS karena layouts/site.blade.php sudah punya footer sendiri
      (footer-tasik) yang tampil di semua halaman publik.
    - Class "col-md-2-4" (tidak valid di Bootstrap) diganti "col-md-4 col-lg".
    - Palet warna section baru (jt-*) disamakan dengan palet asli situs — navy #0d3b7a,
      sky blue #4a90c2, aksen emas #D4A857 — menggantikan biru generik sebelumnya, supaya
      menyatu dengan Hero/Destinasi/Tentang/Kontak dan tetap terkesan mewah.
    - Section Statistik sekarang pakai latar gradient navy dengan kartu glass/frosted,
      supaya transisi dari foto Hero tidak langsung "jatuh" ke putih polos.
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
        ['judul'=>'Festival Budaya Tasikmalaya','promo'=>'Diskon 20%'],
        ['judul'=>'Wisata Religi Ramadan','promo'=>'Diskon 15%'],
    ]);

    $testimoniList = $testimonis ?? collect([
        ['nama'=>'Firman','isi'=>'Sangat mudah membeli tiket, prosesnya cepat.'],
        ['nama'=>'Andi','isi'=>'Tempat wisatanya bagus dan terawat.'],
        ['nama'=>'Sinta','isi'=>'Pelayanan ramah, akan booking lagi lain kali.'],
    ]);
@endphp

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
       Palet disamakan dengan palet asli situs (lihat style.css):
       navy #0d3b7a, sky blue #4a90c2, light blue #a8d8f0, tambah aksen emas
       untuk kesan mewah.
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

    /* ===== Statistik — latar gradient navy + kartu glass/frosted ===== */
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

    /* Kategori */
    .jt-kategori-card{
        background:#fff; border-radius:20px; padding:36px 16px; text-align:center; cursor:pointer;
        box-shadow:0 8px 20px rgba(13,59,122,.08); border-top:3px solid transparent;
        transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    .jt-kategori-card:hover{ transform:scale(1.05); box-shadow:var(--jt-shadow); border-top-color:var(--jt-accent); }
    .jt-kategori-card .jt-emoji{ font-size:2.4rem; margin-bottom:10px; display:block; }
    .jt-kategori-card .jt-nama{ font-weight:600; color:var(--jt-primary); }

    /* Mengapa Memilih Kami */
    .jt-alasan-item{ display:flex; align-items:center; gap:16px; padding:20px 0; border-bottom:1px dashed #dbe6f0; }
    .jt-alasan-item i{ font-size:1.5rem; color:var(--jt-primary); width:44px; height:44px; border-radius:12px; background:#eaf1ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .jt-alasan-item .jt-judul{ font-weight:600; }

    /* Event slider — gradient navy→sky-blue senada situs, badge emas */
    .jt-slider-track{ display:flex; gap:20px; overflow-x:auto; scroll-snap-type:x mandatory; padding-bottom:10px; scrollbar-width:none; }
    .jt-slider-track::-webkit-scrollbar{ display:none; }
    .jt-slider-track > *{ scroll-snap-align:start; flex-shrink:0; }
    .jt-event-card{ width:340px; border-radius:20px; overflow:hidden; position:relative; height:200px; background:linear-gradient(135deg,var(--jt-primary),var(--jt-secondary)); color:#fff; padding:24px; display:flex; flex-direction:column; justify-content:flex-end; box-shadow:0 14px 30px rgba(13,59,122,.25); }
    .jt-event-card .jt-promo-badge{ position:absolute; top:16px; right:16px; background:var(--jt-accent); color:#0d3b7a; font-size:.75rem; font-weight:700; padding:5px 12px; border-radius:20px; }
    .jt-event-card h5{ font-weight:700; margin-bottom:14px; }
    .jt-event-card a{ align-self:flex-start; background:#fff; color:var(--jt-primary); font-weight:600; padding:8px 18px; border-radius:10px; text-decoration:none; font-size:.85rem; }
    .jt-slider-nav{ display:flex; gap:10px; justify-content:center; margin-top:16px; }
    .jt-slider-nav button{ width:38px; height:38px; border-radius:50%; border:1.5px solid #dbe6f0; background:#fff; color:var(--jt-primary); cursor:pointer; }
    .jt-slider-nav button:hover{ border-color:var(--jt-primary); color:var(--jt-primary); background:#eaf1ff; }

    /* Testimoni — bintang & aksen emas */
    .jt-testi-card{ width:340px; background:#fff; border-radius:20px; box-shadow:var(--jt-shadow); padding:28px; border-top:3px solid var(--jt-accent); }
    .jt-testi-card .jt-stars{ color:var(--jt-accent); margin-bottom:12px; }
    .jt-testi-card p{ color:#475569; font-style:italic; margin-bottom:16px; }
    .jt-testi-card .jt-nama{ font-weight:700; color:var(--jt-primary); }

    /* CTA — gradient navy→sky-blue senada Hero/Destinasi/Tentang */
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
</style>

<!-- ===== HERO (tidak diubah) ===== -->
<section class="hero-tasik-foto d-flex align-items-center text-center text-white">
    <div class="hero-overlay"></div>

    <div class="container position-relative hero-content" style="z-index: 2;">
        <span class="hero-tagline"><?php echo $tagline; ?></span>

        <h1 class="display-4 fw-bold mb-3 hero-judul">
            <?php echo $ucapan; ?>, Selamat Datang di<br>
            <span class="hero-nama"><?php echo $nama; ?></span>
        </h1>

        <p class="lead mx-auto hero-deskripsi" style="max-width: 620px;">
            Di antara kabut pegunungan, kesunyian kampung adat, dan debur ombak yang memeluk karang —
            keindahan Tasikmalaya menanti untuk diceritakan lewat langkahmu sendiri.
        </p>

        <a href="{{ route('destinasi') }}" class="btn-hero-cta">Mulai Perjalananmu ↓</a>

        <div class="hero-trust">
            <span>🗺️ 15+ Destinasi Pilihan</span>
            <span class="hero-trust-dot">•</span>
            <span>⭐ Dipercaya 50K+ Wisatawan Setiap Tahun</span>
        </div>
    </div>

    <div class="scroll-indicator">
        <span></span>
    </div>
</section>

<!-- ===== STATISTIK (baru) — latar navy + kartu glass, jembatan visual dari foto Hero ===== -->
<section class="jt-section-navy">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3 jt-fade-up">
                <div class="jt-stat-card"><i class="bi bi-geo-alt-fill"></i>
                    <div class="jt-num" data-jt-count="15">0</div><div class="jt-label">Destinasi</div></div>
            </div>
            <div class="col-6 col-md-3 jt-fade-up">
                <div class="jt-stat-card"><i class="bi bi-people-fill"></i>
                    <div class="jt-num" data-jt-count="50000" data-jt-suffix="+">0</div><div class="jt-label">Wisatawan</div></div>
            </div>
            <div class="col-6 col-md-3 jt-fade-up">
                <div class="jt-stat-card"><i class="bi bi-star-fill"></i>
                    <div class="jt-num" data-jt-count="4.8" data-jt-decimal="1">0</div><div class="jt-label">Rating</div></div>
            </div>
            <div class="col-6 col-md-3 jt-fade-up">
                <div class="jt-stat-card"><i class="bi bi-ticket-perforated-fill"></i>
                    <div class="jt-num" data-jt-count="300" data-jt-suffix="+">0</div><div class="jt-label">Tiket/Hari</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ===== KATEGORI WISATA (baru) ===== -->
<section class="jt-section jt-bg-soft">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Kategori Wisata</h2>
            <p>Pilih jenis wisata sesuai keinginanmu</p>
        </div>
        <div class="row g-3">
            @foreach ($kategoriList as $kat)
                <div class="col-6 col-md-4 col-lg jt-fade-up">
                    <div class="jt-kategori-card">
                        <span class="jt-emoji">{{ is_array($kat) ? $kat['emoji'] : $kat->emoji }}</span>
                        <div class="jt-nama">{{ is_array($kat) ? $kat['nama'] : $kat->nama }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== DESTINASI UNGGULAN (dinamis penuh, mengikuti pola destinasi.blade.php) ===== -->
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

<!-- ===== MENGAPA MEMILIH KAMI (baru) ===== -->
<section class="jt-section jt-bg-soft">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Mengapa Memilih Kami</h2>
            <p>Alasan wisatawan mempercayakan liburannya bersama kami</p>
        </div>
        <div class="row">
            <div class="col-md-4 jt-fade-up">
                <div class="jt-alasan-item"><i class="bi bi-check-circle-fill"></i><div class="jt-judul">Booking Online</div></div>
            </div>
            <div class="col-md-4 jt-fade-up">
                <div class="jt-alasan-item"><i class="bi bi-lightning-charge-fill"></i><div class="jt-judul">Cepat</div></div>
            </div>
            <div class="col-md-4 jt-fade-up">
                <div class="jt-alasan-item"><i class="bi bi-shield-lock-fill"></i><div class="jt-judul">Aman</div></div>
            </div>
            <div class="col-md-4 jt-fade-up">
                <div class="jt-alasan-item"><i class="bi bi-star-fill"></i><div class="jt-judul">Rating Terpercaya</div></div>
            </div>
            <div class="col-md-4 jt-fade-up">
                <div class="jt-alasan-item"><i class="bi bi-geo-alt-fill"></i><div class="jt-judul">Destinasi Lengkap</div></div>
            </div>
            <div class="col-md-4 jt-fade-up">
                <div class="jt-alasan-item"><i class="bi bi-ticket-perforated-fill"></i><div class="jt-judul">Tiket Digital</div></div>
            </div>
        </div>
    </div>
</section>

<!-- ===== EVENT / PROMO (baru) ===== -->
<section class="jt-section">
    <div class="container">
        <div class="jt-head jt-fade-up">
            <h2>Event &amp; Promo</h2>
            <p>Jangan lewatkan penawaran spesial dari kami</p>
        </div>
        <div class="jt-slider-track" id="jtEventSlider">
            @foreach ($eventList as $event)
                <div class="jt-event-card jt-fade-up">
                    <span class="jt-promo-badge">{{ is_array($event) ? $event['promo'] : $event->promo }}</span>
                    <h5>{{ is_array($event) ? $event['judul'] : $event->judul }}</h5>
                    <a href="#">Lihat</a>
                </div>
            @endforeach
        </div>
        <div class="jt-slider-nav">
            <button onclick="document.getElementById('jtEventSlider').scrollBy({left:-360,behavior:'smooth'})"><i class="bi bi-chevron-left"></i></button>
            <button onclick="document.getElementById('jtEventSlider').scrollBy({left:360,behavior:'smooth'})"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- ===== TESTIMONI (baru) ===== -->
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

<!-- ===== KONTAK (ringkas) — TIDAK DIUBAH ===== -->
<section class="kontak-section py-5">
    <div class="kontak-bg"></div>

    <div class="container kontak-content position-relative" style="z-index: 2;">
        <div class="text-center mb-5">
            <span class="kontak-label">Hubungi Kami</span>
            <h2 class="fw-bold text-white mb-2">Ada Pertanyaan atau Saran?</h2>
            <p class="kontak-intro mx-auto">
                Kirimkan pesan Anda kepada kami, atau hubungi langsung lewat kontak yang tersedia.
            </p>
        </div>

        <div class="kontak-card mx-auto" style="max-width: 600px;">
            <form>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                    <label for="nama">Nama</label>
                </div>

                <div class="mb-3 form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    <label for="email">Email</label>
                </div>

                <div class="mb-3 form-floating">
                    <textarea class="form-control" id="pesan" name="pesan" placeholder="Pesan" style="height: 120px"></textarea>
                    <label for="pesan">Pesan</label>
                </div>

                <button type="submit" class="btn btn-kirim w-100">
                    <span>Kirim Pesan</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ===== CTA BOOKING (baru) ===== -->
<section class="jt-section">
    <div class="container">
        <div class="jt-cta-section jt-fade-up">
            <h2>Siap Berlibur?</h2>
            <p>Pesan tiket sekarang dan nikmati pengalaman wisata terbaik.</p>
            <a href="{{ route('destinasi') }}" class="jt-btn-cta">Pesan Sekarang</a>
        </div>
    </div>
</section>

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
});
</script>

@endsection