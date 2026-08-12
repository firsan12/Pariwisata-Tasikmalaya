@extends('layouts.site')

@section('title', $event->judul . ' - Event & Promo')

@section('content')
<style>
    .event-detail-hero {
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
        color: #fff;
    }
    .event-detail-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        margin-top: -3rem;
        position: relative;
        z-index: 2;
    }
    .event-detail-img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        background: #f1f5f9;
    }
    .event-detail-img-placeholder {
        width: 100%;
        height: 320px;
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
    }
    .event-detail-body {
        padding: 2.5rem;
    }
    .badge-promo-detail {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        padding: 0.5rem 1.1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 1rem;
    }
    .event-tanggal {
        color: #0369a1;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .event-deskripsi {
        color: #475569;
        line-height: 1.8;
    }
</style>

<div class="event-detail-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $event->judul }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="event-detail-card mx-auto" style="max-width: 800px;">
        @if (!empty($event->gambar))
            <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}" class="event-detail-img">
        @else
            <div class="event-detail-img-placeholder">
                <i class="bi bi-calendar-event"></i>
            </div>
        @endif

        <div class="event-detail-body">
            <span class="badge-promo-detail">{{ $event->promo }}</span>
            <h1 class="fw-bold mb-3" style="color: #0d3b7a;">{{ $event->judul }}</h1>

            @if ($event->tanggal_mulai)
                <div class="event-tanggal">
                    <i class="bi bi-calendar3"></i>
                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                    @if ($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                        &ndash; {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                    @endif
                </div>
            @endif

            <div class="event-deskripsi">
                {{ $event->deskripsi ?? 'Belum ada deskripsi lebih lanjut untuk event ini.' }}
            </div>

            <div class="mt-4">
                <a href="{{ route('beranda') }}#event-promo" class="btn-lihat-semua">
                    <i class="bi bi-arrow-left"></i> Kembali ke Event Lainnya
                </a>
            </div>
        </div>
    </div>

    <div style="height: 3rem;"></div>
</div>
@endsection