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


@extends('layouts.app')
@section('title', ' Wisata Tasikmalaya - Beranda')
@section('content')

<style>
    /* ===== Marquee Destinasi (geser otomatis tanpa henti) ===== */
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
</style>

<!-- ===== HERO ===== -->
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

<!-- ===== TENTANG (ringkas) ===== -->
<section class="tentang">
    <div class="container tentang-content text-center">
        <span class="tentang-label">Kenali Kami</span>
        <h2>Tentang Daerah Kami</h2>
        <p class="tentang-intro mx-auto">
            Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun. Berbagai destinasi wisata alam, sejarah, dan kuliner siap menyambut setiap wisatawan yang berkunjung.
        </p>
        <a href="{{ route('tentang') }}" class="link-selengkapnya">Selengkapnya tentang kami →</a>
    </div>
</section>

<!-- ===== DESTINASI UNGGULAN (highlight, marquee geser otomatis) ===== -->
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
                    @foreach ($destinasiUnggulan as $d)
                        <div class="kartu">
                            @include('partials.destinasi-card', ['destinasi' => $d, 'ringkas' => true])
                        </div>
                    @endforeach

                    {{-- Set kedua (duplikat, supaya loop terlihat mulus tanpa jeda) --}}
                    @foreach ($destinasiUnggulan as $d)
                        <div class="kartu" aria-hidden="true">
                            @include('partials.destinasi-card', ['destinasi' => $d, 'ringkas' => true])
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

<!-- ===== KONTAK (ringkas) ===== -->
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

@endsection