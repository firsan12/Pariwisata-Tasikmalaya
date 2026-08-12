<?php
    // Konten halaman Tentang sekarang dari TentangController (tabel
    // profil_situs). Nilai di bawah ini hanya fallback kalau datanya
    // belum di-seed, supaya halaman tetap aman ditampilkan.
    $adaProfil = isset($profilSitus) && $profilSitus->id;

    $gambar_hero    = $adaProfil && $profilSitus->tentang_gambar_hero ? $profilSitus->tentang_gambar_hero : 'pantai-karang-tawulan.jpeg';
    $gambar_tentang = $adaProfil && $profilSitus->tentang_gambar ? $profilSitus->tentang_gambar : 'tata-letak4.jpg';

    $heroDeskripsi = $adaProfil && $profilSitus->tentang_hero_deskripsi ? $profilSitus->tentang_hero_deskripsi
        : 'Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun.';

    $tentangJudul = $adaProfil && $profilSitus->tentang_judul ? $profilSitus->tentang_judul : 'Sepenggal Cerita dari Tanah Tasikmalaya';
    $tentangIntro = $adaProfil && $profilSitus->tentang_intro ? $profilSitus->tentang_intro
        : 'Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun.';

    $tentangSublabel  = $adaProfil && $profilSitus->tentang_sublabel ? $profilSitus->tentang_sublabel : 'Kekayaan Alam & Budaya';
    $tentangSubjudul  = $adaProfil && $profilSitus->tentang_subjudul ? $profilSitus->tentang_subjudul : 'Jejak Alam yang Tak Lekang Waktu';
    $tentangDeskripsi1 = $adaProfil && $profilSitus->tentang_deskripsi_1 ? $profilSitus->tentang_deskripsi_1
        : 'Berbagai destinasi wisata alam, sejarah, dan kuliner siap menyambut setiap wisatawan yang berkunjung. Dari kawah gunung yang megah, kampung adat yang masih menjaga tradisi leluhur, hingga pantai dengan pemandangan matahari terbenam yang memukau.';
    $tentangDeskripsi2 = $adaProfil && $profilSitus->tentang_deskripsi_2 ? $profilSitus->tentang_deskripsi_2
        : 'Kami berkomitmen menjaga kelestarian alam sekaligus memperkenalkan budaya lokal kepada generasi masa kini.';
?>

@extends('layouts.site')
@section('title', 'Wisata Tasikmalaya - Tentang')
@section('content')

<!-- ===== HERO TENTANG (background alam) ===== -->
<section class="tentang-hero d-flex align-items-center text-center text-white"
         style="--hero-tentang-bg: url('<?php echo asset('images/'.$gambar_hero); ?>');">
    <div class="tentang-hero-bg"></div>

    <div class="container position-relative tentang-hero-content" style="z-index: 2;">
        <span class="destinasi-label">Kenali Kami</span>
        <h1 class="fw-bold mb-3">Tentang Daerah Kami</h1>
        <p class="lead mx-auto" style="max-width: 600px;">
            {{ $heroDeskripsi }}
        </p>
    </div>
</section>

<!-- ===== Pemisah bergelombang ===== -->
<div class="tentang-divider">
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,30 Q150,0 300,30 T600,30 T900,30 T1200,30 V60 H0 Z" fill="#f4f8fb"></path>
    </svg>
</div>

<section class="tentang">
    <div class="container tentang-content">

        {{-- Bagian 1: Judul & Pengantar --}}
        <div class="text-center mb-5 tentang-fade">
            <span class="tentang-label">Kenali Kami</span>
            <h2 class="tentang-judul">{{ $tentangJudul }}</h2>
            <p class="tentang-intro mx-auto">
                {{ $tentangIntro }}
            </p>
        </div>

        {{-- Bagian 2: Gambar + Deskripsi berdampingan --}}
        <div class="row align-items-center gy-4 mb-5">
            <div class="col-12 col-md-6">
                <div class="tentang-gambar-wrap">
                    <img src="<?php echo asset('images/'.$gambar_tentang); ?>"
                         alt="Pemandangan daerah wisata Tasikmalaya"
                         class="tentang-gambar img-fluid"
                         loading="lazy">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <span class="tentang-sublabel">{{ $tentangSublabel }}</span>
                <h3 class="mb-3 tentang-subjudul">{{ $tentangSubjudul }}</h3>
                <p class="tentang-text">
                    {{ $tentangDeskripsi1 }}
                </p>
                <p class="tentang-text mb-0">
                    {{ $tentangDeskripsi2 }}
                </p>
            </div>
        </div>

        {{-- Bagian 3: Kartu angka/statistik --}}
        <?php
            // $statistik sekarang datang dari TentangController (tabel `statistik`).
            // Array di bawah ini hanya fallback kalau datanya belum di-seed.
            $statistik = (isset($statistik) && count($statistik) > 0) ? $statistik : array(
                array("ikon" => "bi-map-fill", "angka" => "15+", "label" => "Destinasi Wisata"),
                array("ikon" => "bi-houses-fill", "angka" => "8",   "label" => "Desa Wisata"),
                array("ikon" => "bi-people-fill", "angka" => "50K+", "label" => "Pengunjung / Tahun"),
                array("ikon" => "bi-egg-fried", "angka" => "20+", "label" => "Kuliner Khas"),
            );
        ?>

        <div class="row text-center gy-4 mb-5">
            <?php $i = 0; ?>
            <?php foreach ($statistik as $s) { ?>
                <div class="col-6 col-md-3">
                    <div class="tentang-stat" style="animation-delay: <?php echo ($i * 0.12); ?>s">
                        <i class="bi <?php echo $s['ikon']; ?> tentang-stat-ikon"></i>
                        <h3>
                            <span class="tentang-angka" data-target="<?php echo $s['angka']; ?>">0</span>
                        </h3>
                        <p><?php echo $s['label']; ?></p>
                    </div>
                </div>
            <?php $i++; } ?>
        </div>

        {{-- Bagian 4: Visi & Misi --}}
        <?php
            // $visi_misi sekarang datang dari TentangController (tabel `visi_misi`).
            // Array di bawah ini hanya fallback kalau datanya belum di-seed.
            $visi_misi = (isset($visi_misi) && count($visi_misi) > 0) ? $visi_misi : array(
                array(
                    "ikon"  => "bi-bullseye",
                    "judul" => "Visi",
                    "isi"   => "Menjadi destinasi wisata unggulan yang melestarikan alam dan budaya sambil meningkatkan kesejahteraan masyarakat lokal."
                ),
                array(
                    "ikon"  => "bi-tree-fill",
                    "judul" => "Misi",
                    "isi"   => "Mengembangkan pariwisata berkelanjutan, memberdayakan masyarakat sekitar, dan memperkenalkan kekayaan budaya kepada dunia."
                ),
            );
        ?>

        <div class="row gy-4">
            <?php foreach ($visi_misi as $vm) { ?>
                <div class="col-12 col-md-6">
                    <div class="tentang-card">
                        <span class="tentang-card-ikon"><i class="bi <?php echo $vm['ikon']; ?>"></i></span>
                        <h4><?php echo $vm['judul']; ?></h4>
                        <p class="mb-0"><?php echo $vm['isi']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>

<style>
    .tentang-angka {
        display: inline-block;
        transition: transform 0.2s ease;
    }

    .tentang-angka.selesai-hitung {
        animation: bounceAngka 0.4s ease;
    }

    @keyframes bounceAngka {
        0%   { transform: scale(1); }
        40%  { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const elemenAngka = document.querySelectorAll('.tentang-angka');

    function animasiHitung(elemen) {
        const target = elemen.getAttribute('data-target');

        const angkaBersih = parseFloat(target.replace(/[^0-9.]/g, ''));
        const suffix = target.replace(/[0-9.]/g, '');

        if (isNaN(angkaBersih)) {
            elemen.textContent = target;
            return;
        }

        const durasi = 1500;
        const mulai = performance.now();

        function frame(waktuSekarang) {
            const progres = Math.min((waktuSekarang - mulai) / durasi, 1);
            const easeOut = 1 - Math.pow(1 - progres, 3);
            const nilaiSekarang = Math.floor(easeOut * angkaBersih);

            elemen.textContent = nilaiSekarang + suffix;

            if (progres < 1) {
                requestAnimationFrame(frame);
            } else {
                elemen.textContent = angkaBersih + suffix;
                elemen.classList.add('selesai-hitung');
            }
        }

        requestAnimationFrame(frame);
    }

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                animasiHitung(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });

    elemenAngka.forEach(function (elemen) {
        observer.observe(elemen);
    });
});
</script>

@endsection