@extends('layouts.app')
@section('title', ' Wisata Tasikmalaya - Destinasi')
@section('content')

<?php
    date_default_timezone_set("Asia/Jakarta");
    $nama = "Wisata Tasikmalaya";
?>

<style>
    .offcanvas-filter {
        width: 320px;
        background: linear-gradient(180deg, #0c4a6e 0%, #0369a1 100%);
        color: #fff;
    }

    .offcanvas-filter .offcanvas-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding: 1.5rem;
    }

    .offcanvas-filter .offcanvas-title {
        font-weight: 700;
    }

    .offcanvas-filter .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    .offcanvas-filter .offcanvas-body {
        padding: 1.5rem;
    }

    .offcanvas-filter label {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        opacity: 0.9;
    }

    .offcanvas-filter .form-control {
        border-radius: 10px;
        border: none;
        padding: 0.7rem 1rem;
    }

    .offcanvas-filter .btn-terapkan {
        background: rgba(255, 255, 255, 0.95);
        color: #0369a1;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.2s ease;
    }

    .offcanvas-filter .btn-terapkan:hover {
        background: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
    }

    .offcanvas-filter .btn-reset-filter {
        display: block;
        text-align: center;
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
        font-size: 0.85rem;
        margin-top: 0.9rem;
    }

    .offcanvas-filter .btn-reset-filter:hover {
        color: #fff;
        text-decoration: underline;
    }

    .btn-buka-filter {
        background: rgba(255, 255, 255, 0.95);
        color: #0369a1;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        padding: 0.65rem 1.4rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-buka-filter:hover {
        background: #fff;
        color: #0369a1;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

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
        animation: marqueeScroll var(--marquee-durasi, 40s) linear infinite;
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
</style>

<section class="destinasi-section py-5">
    <div class="destinasi-bg"></div>

    <div class="container position-relative" style="z-index: 2;">

        <div class="text-center mb-5 destinasi-heading">
            <span class="destinasi-label">Jelajahi</span>
            <h2 class="fw-bold text-white mb-2">Destinasi Unggulan</h2>
            <p class="destinasi-subtitle mx-auto">
                Cari destinasi favoritmu, cek slot tiket yang masih tersedia, dan rencanakan kunjunganmu sekarang.
            </p>
        </div>

        <div class="d-flex justify-content-center mb-4">
            <button type="button" class="btn-buka-filter" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-controls="offcanvasFilter">
                <i class="bi bi-sliders"></i> Filter / Cari Destinasi
            </button>
        </div>

        @if (!empty($keyword))
            <p class="text-center text-white mb-4">
                Menampilkan hasil pencarian untuk: <strong>"{{ $keyword }}"</strong>
                — <a href="{{ route('destinasi') }}" class="link-selengkapnya">Reset pencarian</a>
            </p>
        @endif

        @if ($destinasiList->count() > 0)

            <div class="marquee-outer" style="--marquee-durasi: {{ max($destinasiList->count() * 6, 20) }}s;">
                <div class="marquee-track">

                    {{-- Set pertama --}}
                    @foreach ($destinasiList as $destinasi)
                        @php
                            $jamBuka  = \Carbon\Carbon::parse($destinasi->jam_buka);
                            $jamTutup = \Carbon\Carbon::parse($destinasi->jam_tutup);
                        @endphp

                        <div class="kartu">
                            <div class="kartu-img-wrap">
                                <img src="{{ asset('images/' . $destinasi->gambar) }}" alt="Foto {{ $destinasi->nama }}">
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

                    {{-- Set kedua (duplikat, supaya loop terlihat mulus tanpa jeda) --}}
                    @foreach ($destinasiList as $destinasi)
                        @php
                            $jamBuka  = \Carbon\Carbon::parse($destinasi->jam_buka);
                            $jamTutup = \Carbon\Carbon::parse($destinasi->jam_tutup);
                        @endphp

                        <div class="kartu" aria-hidden="true">
                            <div class="kartu-img-wrap">
                                <img src="{{ asset('images/' . $destinasi->gambar) }}" alt="Foto {{ $destinasi->nama }}">
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
                                    <span class="slot-text tersedia">{{ $destinasi->sisa_slot }} slot tersedia</span>
                                @endif
                                <span class="slot-persen">{{ $destinasi->persen_terisi }}% terisi</span>
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
            <div class="text-center text-white py-5">
                @if (!empty($keyword))
                    <p class="mb-0">Tidak ditemukan destinasi dengan nama "{{ $keyword }}".</p>
                @else
                    <p class="mb-0">Belum ada destinasi yang ditambahkan.</p>
                @endif
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            {{ $destinasiList->appends(['cari' => $keyword])->links('pagination::bootstrap-5') }}
        </div>

    </div>
</section>

{{-- ===== OFFCANVAS FILTER (geser dari kanan) ===== --}}
<div class="offcanvas offcanvas-end offcanvas-filter" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasFilterLabel"><i class="bi bi-sliders me-2"></i>Filter Destinasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('destinasi') }}" method="GET">
            <label for="cariInput">Cari Nama Destinasi</label>
            <input type="text" id="cariInput" name="cari" class="form-control"
                   placeholder="Contoh: Masjid Agung..." value="{{ $keyword ?? '' }}">

            <button type="submit" class="btn-terapkan">
                <i class="bi bi-search"></i> Terapkan Filter
            </button>
        </form>

        @if (!empty($keyword))
            <a href="{{ route('destinasi') }}" class="btn-reset-filter">
                <i class="bi bi-x-circle"></i> Reset semua filter
            </a>
        @endif
    </div>
</div>

@endsection