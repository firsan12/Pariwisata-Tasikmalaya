@extends('layouts.site')

@section('title', $event->judul . ' - Event & Promo')

@section('content')
<style>
    .event-detail-hero {
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 2.5rem 0;
        color: #fff;
    }
    .event-detail-hero .breadcrumb-item a{ text-decoration:none; }
    .event-detail-hero .breadcrumb-item a:hover{ color:#fff; }
    .event-detail-hero .breadcrumb-item + .breadcrumb-item::before{ color: rgba(255,255,255,.5); }

    .event-detail-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        margin-top: -2.5rem;
        position: relative;
        z-index: 2;
    }
    .event-detail-media {
        position: relative;
        width: 100%;
        height: 220px;
    }
    .event-detail-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .event-detail-img-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.9);
        gap: .5rem;
    }
    .event-detail-img-placeholder .icon-circle{
        width: 64px; height: 64px; border-radius: 50%;
        background: rgba(255,255,255,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem;
    }
    .event-detail-img-placeholder span{ font-size: .85rem; font-weight: 600; letter-spacing: .02em; }
    .badge-promo-detail {
        position: absolute;
        top: 18px;
        right: 18px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        padding: 0.5rem 1.1rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        box-shadow: 0 6px 16px rgba(0,0,0,.2);
    }
    .event-detail-body {
        padding: 2rem 2.25rem 2.25rem;
    }
    .event-tanggal {
        color: #0369a1;
        font-weight: 600;
        font-size: .9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .event-tanggal.belum-ada{ color: #94a3b8; font-weight: 500; }
    .event-deskripsi {
        color: #475569;
        line-height: 1.8;
        padding-top: 1.25rem;
        border-top: 1px solid #eef2f7;
    }
</style>

<div class="event-detail-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}#event-promo" class="text-white-50">Event &amp; Promo</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $event->judul }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="event-detail-card mx-auto" style="max-width: 720px;">
        <div class="event-detail-media">
            @if (!empty($event->gambar))
                <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}" class="event-detail-img">
            @else
                <div class="event-detail-img-placeholder">
                    <span class="icon-circle"><i class="bi bi-calendar-event"></i></span>
                    <span>Belum ada foto untuk event ini</span>
                </div>
            @endif
            <span class="badge-promo-detail">{{ $event->promo }}</span>
        </div>

        <div class="event-detail-body">
            <h1 class="fw-bold mb-2" style="color: #0d3b7a; font-size: 1.9rem;">{{ $event->judul }}</h1>

            @if ($event->tanggal_mulai)
                <div class="event-tanggal">
                    <i class="bi bi-calendar3"></i>
                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}
                    @if ($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                        &ndash; {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}
                    @endif
                </div>
            @else
                <div class="event-tanggal belum-ada">
                    <i class="bi bi-calendar3"></i>
                    Jadwal belum ditentukan
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