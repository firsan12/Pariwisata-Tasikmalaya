@extends('layouts.site')

@section('title', 'Kuliner Tasikmalaya')

@section('content')

<style>
    .kul-hero {
        padding: 70px 0;
        background:
            linear-gradient(135deg, rgba(13, 59, 122, .88), rgba(74, 144, 194, .68)),
            url('{{ asset('images/logo.jpg') }}') center/cover;
        color: #fff;
    }

    .kul-hero h1 {
        font-family: Poppins, sans-serif;
        font-weight: 700;
        font-size: clamp(2rem, 5vw, 3.6rem);
        margin-bottom: 10px;
        letter-spacing: -.5px;
    }

    .kul-hero p {
        max-width: 720px;
        opacity: .88;
        font-weight: 300;
    }

    .kul-wrap {
        padding: 38px 0 70px;
        background: #fbfcfe;
    }

    .kul-filter {
        background: #fff;
        border: 1px solid #eef2f6;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(13, 59, 122, .05);
        margin-top: -55px;
        position: relative;
        z-index: 2;
    }

    .kul-filter .form-control,
    .kul-filter .form-select {
        min-height: 48px;
        border-radius: 12px;
        border-color: #e7edf3;
    }

    .kul-filter .form-control:focus,
    .kul-filter .form-select:focus {
        border-color: #4a90c2;
        box-shadow: 0 0 0 .2rem rgba(74, 144, 194, .12);
    }

    .kul-card {
        height: 100%;
        border: 1px solid #eef2f6;
        border-radius: 22px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 4px 18px rgba(13, 59, 122, .04);
        transition: .3s ease;
    }

    .kul-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 32px rgba(13, 59, 122, .1);
        border-color: #dfe9f2;
    }

    .kul-img,
    .kul-img-placeholder {
        height: 220px;
        width: 100%;
        object-fit: cover;
    }

    .kul-img-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #eaf3fa, #f7fafc);
        color: #a9c3dc;
        font-size: 2.6rem;
    }

    .kul-body {
        padding: 20px;
    }

    .kul-badge {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .3px;
        border-radius: 50px;
        padding: 5px 12px;
        background: #eef5fb;
        color: #3b6ea5;
    }

    .kul-title {
        font-family: Poppins, sans-serif;
        font-weight: 700;
        font-size: 1.05rem;
        margin: 12px 0 7px;
        letter-spacing: -.2px;
    }

    .kul-title a {
        color: #17324d;
        text-decoration: none;
    }

    .kul-title a:hover {
        color: #0d3b7a;
    }

    .kul-desc {
        color: #8593a3;
        font-size: .87rem;
        line-height: 1.7;
        min-height: 65px;
        font-weight: 300;
    }

    .kul-price {
        font-weight: 700;
        color: #0d3b7a;
        font-size: .95rem;
    }

    .kul-location {
        font-size: .82rem;
        color: #9aa7b5;
        font-weight: 300;
    }

    .kul-card .btn-primary {
        background: #0d3b7a;
        border: none;
        font-weight: 500;
    }

    .kul-card .btn-primary:hover {
        background: #4a90c2;
    }

    /* pagination — tetap sama seperti sebelumnya, hanya diperhalus */
    .kul-page {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e7edf3;
        border-radius: 10px;
        background: #fff;
        color: #4a5a6b;
        text-decoration: none;
        font-weight: 600;
        font-size: .88rem;
        transition: all .2s ease;
    }

    .kul-page:hover {
        background: #eef5fb;
        border-color: #4a90c2;
        color: #0d3b7a;
    }

    .kul-page.active {
        background: #0d3b7a;
        border-color: #0d3b7a;
        color: #fff;
    }

    .kul-page.disabled {
        background: #f7f9fb;
        color: #c4ccd4;
        border-color: #eef2f6;
    }
</style>

{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

<section class="kul-hero">

    <div class="container">

        <div class="row">

            <div class="col-lg-8">

                <div class="small fw-bold text-uppercase mb-2">
                    Wisata Tasikmalaya
                </div>

                <h1>
                    Jelajah Kuliner Tasikmalaya
                </h1>

                <p class="lead mb-0">
                    Temukan kuliner khas, jajanan, makanan tradisional,
                    minuman, dan oleh-oleh Tasikmalaya.
                </p>

            </div>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- KATALOG --}}
{{-- ========================================================= --}}

<section class="kul-wrap">

    <div class="container">


        {{-- FILTER & PENCARIAN --}}

        <form
            class="kul-filter mb-5"
            method="GET"
            action="{{ route('kuliner.katalog') }}"
        >

            <div class="row g-2">

                {{-- Pencarian --}}

                <div class="col-lg-5">

                    <input
                        type="text"
                        class="form-control"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari nama, lokasi, atau deskripsi..."
                    >

                </div>


                {{-- Kategori --}}

                <div class="col-lg-3">

                    <select
                        class="form-select"
                        name="kategori"
                    >

                        <option value="">
                            Semua kategori
                        </option>

                        @foreach($kategoris as $kategori)

                            <option
                                value="{{ $kategori }}"
                                @selected(request('kategori') === $kategori)
                            >
                                {{ $kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Sorting --}}

                <div class="col-lg-2">

                    <select
                        class="form-select"
                        name="sort"
                    >

                        <option
                            value="nama"
                            @selected(request('sort', 'nama') === 'nama')
                        >
                            Nama A–Z
                        </option>

                        <option
                            value="harga"
                            @selected(request('sort') === 'harga')
                        >
                            Harga termurah
                        </option>

                        <option
                            value="harga_desc"
                            @selected(request('sort') === 'harga_desc')
                        >
                            Harga termahal
                        </option>

                        <option
                            value="nama_desc"
                            @selected(request('sort') === 'nama_desc')
                        >
                            Nama Z–A
                        </option>

                    </select>

                </div>


                {{-- Tombol --}}

                <div class="col-lg-2 d-grid">

                    <button
                        class="btn btn-primary rounded-3 fw-bold"
                        type="submit"
                    >
                        <i class="bi bi-search me-1"></i>
                        Cari
                    </button>

                </div>

            </div>

        </form>


        {{-- ================================================= --}}
        {{-- HEADER HASIL --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="h4 fw-bold mb-0">
                {{ $kuliners->total() }} Kuliner
            </h2>


            @if(request()->hasAny(['q', 'kategori', 'sort']))

                <a
                    href="{{ route('kuliner.katalog') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    Reset
                </a>

            @endif

        </div>


        {{-- ================================================= --}}
        {{-- CARD KULINER --}}
        {{-- ================================================= --}}

        <div class="row g-4">

            @forelse($kuliners as $kuliner)

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">

                    <article class="kul-card">


                        {{-- FOTO --}}

                      {{-- FOTO --}}
<a href="{{ route('kuliner.detail', $kuliner) }}">
    @if($kuliner->foto)
        <img
            class="kul-img"
            src="{{ $kuliner->foto_url }}"
            alt="{{ $kuliner->nama }}"
            loading="lazy"
        >
    @else
        <div class="kul-img-placeholder">
            <i class="bi bi-egg-fried"></i>
        </div>
    @endif
</a>
                        {{-- BODY --}}

                        <div class="kul-body">


                            {{-- KATEGORI --}}

                            @if($kuliner->kategori)

                                <span class="kul-badge">
                                    {{ $kuliner->kategori }}
                                </span>

                            @endif


                            {{-- NAMA --}}

                            <h3 class="kul-title h5">

                                <a
                                    href="{{ route('kuliner.detail', ['kuliner' => $kuliner->id]) }}"
                                >
                                    {{ $kuliner->nama }}
                                </a>

                            </h3>


                            {{-- DESKRIPSI --}}

                            <p class="kul-desc">

                                {{
                                    \Illuminate\Support\Str::limit(
                                        $kuliner->deskripsi
                                            ?: 'Kuliner khas yang dapat dinikmati di Tasikmalaya.',
                                        120
                                    )
                                }}

                            </p>


                            {{-- HARGA --}}

                            <div class="kul-price mb-1">

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

                            </div>


                            {{-- LOKASI --}}

                            <div class="kul-location mb-3">

                                <i class="bi bi-geo-alt me-1"></i>

                                {{ $kuliner->alamat ?: 'Tasikmalaya' }}

                            </div>


                            {{-- DETAIL --}}

                            <a
                              href="{{ route('kuliner.detail', ['kuliner' => $kuliner->id]) }}"
                                class="btn btn-primary w-100 rounded-3 fw-bold"
                            >
                                Lihat Detail
                            </a>

                        </div>

                    </article>

                </div>

            @empty

                {{-- TIDAK ADA DATA --}}

                <div class="col-12">

                    <div class="text-center bg-white rounded-4 p-5">

                        <i class="bi bi-cup-hot display-4 text-secondary"></i>

                        <h3 class="fw-bold mt-3">
                            Kuliner tidak ditemukan
                        </h3>

                        <p class="text-secondary">
                            Coba kata kunci atau kategori lain.
                        </p>

                        <a
                            href="{{ route('kuliner.katalog') }}"
                            class="btn btn-primary rounded-3"
                        >
                            Lihat Semua Kuliner
                        </a>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- ================================================= --}}
        {{-- PAGINATION --}}
        {{-- ================================================= --}}

      @if ($kuliners->hasPages())
    <div class="kul-pagination mt-5">
        <div class="kul-pagination-info">
            Menampilkan
            <strong>{{ $kuliners->firstItem() }}</strong>
            –
            <strong>{{ $kuliners->lastItem() }}</strong>
            dari
            <strong>{{ $kuliners->total() }}</strong>
            kuliner
        </div>

        <div class="kul-pagination-buttons">

            {{-- Previous --}}
            @if ($kuliners->onFirstPage())
                <span class="kul-page disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $kuliners->previousPageUrl() }}" class="kul-page">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($kuliners->getUrlRange(1, $kuliners->lastPage()) as $page => $url)
                @if ($page == $kuliners->currentPage())
                    <span class="kul-page active">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="kul-page">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($kuliners->hasMorePages())
                <a href="{{ $kuliners->nextPageUrl() }}" class="kul-page">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="kul-page disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif

        </div>
    </div>
@endif

    </div>

</section>

@endsection