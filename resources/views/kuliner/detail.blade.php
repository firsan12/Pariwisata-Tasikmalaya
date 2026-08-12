@extends('layouts.site')

@section('title', $kuliner->nama . ' - Kuliner Tasikmalaya')

@section('content')

<style>
    .kd-wrap {
        background: #fbfcfe;
        padding: 35px 0 70px;
    }

    .kd-card {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 6px 28px rgba(13, 59, 122, .05);
    }

    .kd-img,
    .kd-img-placeholder {
        width: 100%;
        height: 100%;
        min-height: 460px;
        object-fit: cover;
    }

    .kd-img-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(160deg, #eaf3fa, #f9fbfd);
        color: #b7cbe0;
        font-size: 4.5rem;
    }

    .kd-body {
        padding: 46px;
    }

    .kd-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 50px;
        background: #eef5fb;
        color: #3b6ea5;
        font-weight: 600;
        font-size: .75rem;
        letter-spacing: .3px;
    }

    .kd-title {
        font-family: Poppins, sans-serif;
        font-weight: 700;
        font-size: clamp(1.9rem, 3.6vw, 3rem);
        color: #17324d;
        letter-spacing: -.5px;
    }

    .kd-desc {
        color: #8593a3;
        line-height: 1.9;
        font-size: 1rem;
        font-weight: 300;
    }

    .kd-info {
        background: #f9fbfd;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 16px 18px;
        height: 100%;
    }

    .kd-label {
        display: block;
        color: #9aa7b5;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .kd-value {
        font-weight: 700;
        color: #17324d;
    }

    .kd-rekom-card {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 18px;
        overflow: hidden;
        transition: .3s ease;
        box-shadow: 0 4px 16px rgba(13, 59, 122, .04);
    }

    .kd-rekom-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(13, 59, 122, .1);
        border-color: #dfe9f2;
    }

    .kd-rekom-img,
    .kd-rekom-img-placeholder {
        width: 100%;
        height: 170px;
        object-fit: cover;
    }

    .kd-rekom-img-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(160deg, #eaf3fa, #f9fbfd);
        color: #b7cbe0;
        font-size: 2rem;
    }

    @media (max-width: 991px) {
        .kd-img, .kd-img-placeholder { min-height: 320px; }
        .kd-body { padding: 30px; }
    }
</style>


<section class="kd-wrap">

    <div class="container">

        {{-- KEMBALI KE KATALOG --}}

        <a
            href="{{ route('kuliner.katalog') }}"
            class="btn btn-link text-decoration-none px-0 mb-3"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke katalog kuliner
        </a>


        {{-- DETAIL UTAMA --}}

        <article class="kd-card">

            <div class="row g-0">

                {{-- FOTO --}}

              <div class="col-lg-6">
    @if($kuliner->foto)
        <img class="kd-img" src="{{ $kuliner->foto_url }}" alt="{{ $kuliner->nama }}">
    @else
        <div class="kd-img-placeholder">
            <i class="bi bi-egg-fried"></i>
        </div>
    @endif
</div>


                {{-- INFORMASI --}}

                <div class="col-lg-6">

                    <div class="kd-body">

                        {{-- KATEGORI --}}

                        @if($kuliner->kategori)

                            <span class="kd-badge">
                                {{ $kuliner->kategori }}
                            </span>

                        @endif


                        {{-- NAMA --}}

                        <h1 class="kd-title mt-3">
                            {{ $kuliner->nama }}
                        </h1>


                        {{-- DESKRIPSI --}}

                        <p class="kd-desc">

                            {{
                                $kuliner->deskripsi
                                ?: 'Kuliner khas yang dapat dinikmati saat menjelajahi Tasikmalaya.'
                            }}

                        </p>


                        {{-- INFORMASI --}}

                        <div class="row g-3 my-3">

                            {{-- HARGA --}}

                            <div class="col-sm-6">

                                <div class="kd-info">

                                    <span class="kd-label">
                                        Harga mulai
                                    </span>

                                    <span class="kd-value">

                                        Rp
                                        {{
                                            $kuliner->harga_mulai
                                                ? number_format(
                                                    $kuliner->harga_mulai,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                                : '—'
                                        }}

                                    </span>

                                </div>

                            </div>


                            {{-- LOKASI --}}

                            <div class="col-sm-6">

                                <div class="kd-info">

                                    <span class="kd-label">
                                        Lokasi
                                    </span>

                                    <span class="kd-value">

                                        {{ $kuliner->alamat ?: 'Tasikmalaya' }}

                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- GOOGLE MAPS --}}

                        @if($kuliner->alamat)

                            <a
                                class="btn btn-outline-primary rounded-3"
                                target="_blank"
                                rel="noopener noreferrer"
                                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($kuliner->alamat . ', Tasikmalaya') }}"
                            >

                                <i class="bi bi-geo-alt me-1"></i>

                                Buka di Google Maps

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        </article>


        {{-- ================================================= --}}
        {{-- REKOMENDASI --}}
        {{-- ================================================= --}}

        @if($rekomendasi->count())

            <h2 class="h3 fw-bold mt-5 mb-4">
                Kuliner lainnya
            </h2>


            <div class="row g-4">

                @foreach($rekomendasi as $item)

                    <div class="col-12 col-sm-6 col-lg-3">

                        <a
                            href="{{ route('kuliner.detail', $item) }}"
                            class="text-decoration-none"
                        >

                            <div class="kd-rekom-card h-100">

                                {{-- FOTO --}}
@if($item->foto)
    <img class="kd-rekom-img" src="{{ $item->foto_url }}" alt="{{ $item->nama }}" loading="lazy">
@else
    <div class="kd-rekom-img-placeholder">
        <i class="bi bi-egg-fried"></i>
    </div>
@endif

                                {{-- INFO --}}

                                <div class="card-body">

                                    @if($item->kategori)

                                        <small class="text-primary fw-bold">
                                            {{ $item->kategori }}
                                        </small>

                                    @endif

                                    <h3 class="h6 fw-bold text-dark mt-1 mb-2">
                                        {{ $item->nama }}
                                    </h3>


                                    @if($item->harga_mulai)

                                        <div class="small fw-bold text-primary">

                                            Rp
                                            {{
                                                number_format(
                                                    $item->harga_mulai,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </div>

                                    @endif

                                </div>

                            </div>

                        </a>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection