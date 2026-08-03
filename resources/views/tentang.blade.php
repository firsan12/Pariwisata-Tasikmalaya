<?php
    // Path gambar hero & section "Tentang" — ganti di sini saja kalau mau pakai foto lain
    // Pastikan nama file PERSIS sama (huruf besar/kecil) dengan yang ada di folder /images
    $gambar_hero    = 'pantai-karang-tawulan.jpeg';
    $gambar_tentang = 'tata-letak4.jpg';
?>

@extends('layouts.app')
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
            Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun.
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
            <h2 class="tentang-judul">Sepenggal Cerita dari Tanah Tasikmalaya</h2>
            <p class="tentang-intro mx-auto">
                Daerah ini dikenal dengan keindahan alamnya yang masih asri, dipadukan dengan kekayaan budaya lokal yang diwariskan turun-temurun.
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
                <span class="tentang-sublabel">Kekayaan Alam & Budaya</span>
                <h3 class="mb-3 tentang-subjudul">Jejak Alam yang Tak Lekang Waktu</h3>
                <p class="tentang-text">
                    Berbagai destinasi wisata alam, sejarah, dan kuliner siap menyambut setiap wisatawan yang berkunjung. Dari kawah gunung yang megah, kampung adat yang masih menjaga tradisi leluhur, hingga pantai dengan pemandangan matahari terbenam yang memukau.
                </p>
                <p class="tentang-text mb-0">
                    Kami berkomitmen menjaga kelestarian alam sekaligus memperkenalkan budaya lokal kepada generasi masa kini.
                </p>
            </div>
        </div>

        {{-- Bagian 3: Kartu angka/statistik --}}
        <?php
            $statistik = array(
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
                        <h3><?php echo $s['angka']; ?></h3>
                        <p><?php echo $s['label']; ?></p>
                    </div>
                </div>
            <?php $i++; } ?>
        </div>

        {{-- Bagian 4: Visi & Misi --}}
        <?php
            $visi_misi = array(
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

@endsection