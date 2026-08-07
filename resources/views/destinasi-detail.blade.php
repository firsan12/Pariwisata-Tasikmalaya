@extends('layouts.app')

@section('title', $destinasi->nama . ' - Detail Destinasi')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root{
        --primary:#2563EB;
        --primary-dark:#1D4ED8;
        --secondary:#0EA5E9;
        --accent:#F59E0B;
        --bg:#F8FAFC;
        --text:#1E293B;
        --radius-card:20px;
        --radius-btn:16px;
        --radius-input:14px;
        --shadow-soft:0 10px 30px rgba(0,0,0,.08);
        --sp-1:8px; --sp-2:16px; --sp-3:24px; --sp-4:32px; --sp-5:48px; --sp-6:64px;
    }
    .destinasi-page{ font-family:'Inter',sans-serif; color:var(--text); background:var(--bg); }
    .destinasi-page h1,.destinasi-page h2,.destinasi-page h3,.destinasi-page h4{ font-family:'Poppins',sans-serif; }

    /* ===== HERO FULLSCREEN ===== */
    .hero-full{
        position:relative; width:100%; min-height:100vh;
        background-size:cover; background-position:center;
        display:flex; flex-direction:column; justify-content:flex-end;
        color:#fff;
    }
    .hero-full::after{
        content:""; position:absolute; inset:0;
        background:linear-gradient(180deg, rgba(15,23,42,.15) 0%, rgba(15,23,42,.85) 100%);
    }
    .hero-full .hero-content{ position:relative; z-index:2; padding:var(--sp-6) var(--sp-4) var(--sp-5); max-width:900px; }
    .hero-full h1{ font-size:2.75rem; font-weight:800; margin-bottom:var(--sp-2); text-shadow:0 4px 18px rgba(0,0,0,.35); }
    .hero-meta{ display:flex; flex-wrap:wrap; align-items:center; gap:var(--sp-3); margin-bottom:var(--sp-2); font-weight:500; }
    .hero-meta .stars i{ color:var(--accent); }
    .hero-price{ font-size:1.5rem; font-weight:700; margin-bottom:var(--sp-3); }
    .hero-actions{ display:flex; gap:var(--sp-2); flex-wrap:wrap; }

    /* ===== BUTTONS ===== */
    .btn-primary-grad{
        background:var(--primary); color:#fff; border:none; border-radius:var(--radius-btn);
        padding:14px 28px; font-weight:600; font-size:1rem; transition:all .2s ease; display:inline-flex;
        align-items:center; gap:8px; text-decoration:none;
    }
    .btn-primary-grad:hover{ background:linear-gradient(135deg, var(--primary), var(--primary-dark)); transform:scale(1.03); color:#fff; box-shadow:var(--shadow-soft); }
    .btn-outline-white{
        background:rgba(255,255,255,.12); color:#fff; border:1.5px solid rgba(255,255,255,.6);
        border-radius:var(--radius-btn); padding:14px 28px; font-weight:600; backdrop-filter:blur(6px);
        text-decoration:none; transition:all .2s ease;
    }
    .btn-outline-white:hover{ background:rgba(255,255,255,.25); color:#fff; }

    /* ===== INFO CARDS (5 kartu) ===== */
    .info-cards-wrap{ margin-top:-56px; position:relative; z-index:3; padding:0 var(--sp-3); }
    .info-cards{
        background:#fff; border-radius:var(--radius-card); box-shadow:var(--shadow-soft);
        display:grid; grid-template-columns:repeat(5,1fr); gap:0; overflow:hidden;
    }
    .info-cards .info-cell{ padding:var(--sp-3) var(--sp-2); text-align:center; border-right:1px solid #eef1f5; }
    .info-cards .info-cell:last-child{ border-right:none; }
    .info-cell .info-label{ font-size:.78rem; color:#8a93a3; margin-bottom:4px; font-weight:500; }
    .info-cell .info-value{ font-size:1.05rem; font-weight:700; color:var(--text); }
    .info-cell i{ color:var(--primary); font-size:1.3rem; margin-bottom:6px; display:block; }
    @media (max-width:900px){ .info-cards{ grid-template-columns:repeat(2,1fr); } .info-cards .info-cell{ border-bottom:1px solid #eef1f5; } }

    /* ===== LAYOUT UTAMA (konten + sidebar sticky) ===== */
    .detail-main-grid{ display:grid; grid-template-columns:1fr 360px; gap:var(--sp-4); align-items:start; padding:var(--sp-5) var(--sp-3); }
    @media (max-width:992px){ .detail-main-grid{ grid-template-columns:1fr; } }

    .content-section{ background:#fff; border-radius:var(--radius-card); box-shadow:var(--shadow-soft); padding:var(--sp-4); margin-bottom:var(--sp-4); }
    .content-section h2{ font-size:1.35rem; font-weight:700; margin-bottom:var(--sp-2); }

    .fasilitas-check{ list-style:none; padding:0; margin:var(--sp-2) 0 0; display:grid; grid-template-columns:repeat(2,1fr); gap:10px; }
    .fasilitas-check li{ display:flex; align-items:center; gap:8px; color:#475569; }
    .fasilitas-check i{ color:var(--primary); }

    /* ===== KUOTA HARI INI ===== */
    .kuota-bar-track{ height:12px; border-radius:20px; background:#e2e8f0; overflow:hidden; margin:var(--sp-2) 0 6px; }
    .kuota-bar-fill{ height:100%; background:linear-gradient(90deg,var(--primary),var(--secondary)); border-radius:20px; }
    .kuota-total-text{ font-weight:600; color:var(--primary); margin-bottom:var(--sp-3); }
    .kuota-kategori-list{ display:grid; gap:12px; }
    .kuota-kategori-item{
        display:flex; justify-content:space-between; align-items:center; padding:14px 16px;
        border:1px solid #eef1f5; border-radius:var(--radius-input); background:#fafcff;
    }
    .kuota-kategori-item .nama{ font-weight:600; }
    .kuota-kategori-item .harga{ color:#8a93a3; font-size:.85rem; }
    .kuota-kategori-item .sisa{ color:var(--primary); font-weight:700; }

    /* ===== GALERI MASONRY ===== */
    .galeri-masonry{ columns:3 200px; column-gap:12px; }
    .galeri-masonry img{ width:100%; margin-bottom:12px; border-radius:14px; display:block; cursor:pointer; transition:transform .2s ease; }
    .galeri-masonry img:hover{ transform:scale(1.02); }
    .galeri-empty{ text-align:center; padding:var(--sp-5) var(--sp-2); color:#8a93a3; }
    .galeri-empty i{ font-size:2.5rem; color:#cbd5e1; margin-bottom:var(--sp-2); display:block; }

    /* ===== ATRAKSI ===== */
    .atraksi-card{ border-radius:var(--radius-card); overflow:hidden; box-shadow:var(--shadow-soft); background:#fff; transition:transform .2s ease; height:100%; }
    .atraksi-card:hover{ transform:translateY(-8px); }
    .atraksi-card img{ height:170px; object-fit:cover; width:100%; }
    .atraksi-card .body{ padding:16px; }
    .atraksi-card .kategori-tag{ font-size:.75rem; font-weight:600; color:var(--primary); background:#eaf1ff; padding:3px 10px; border-radius:20px; }
    .atraksi-card .lihat-detail{ color:var(--primary); font-weight:600; font-size:.9rem; text-decoration:none; }

    /* ===== REVIEW ===== */
    .review-summary{ display:flex; align-items:center; gap:var(--sp-2); margin-bottom:var(--sp-3); }
    .review-summary .avg{ font-size:2.2rem; font-weight:800; }
    .review-summary .stars i{ color:var(--accent); }

    /* ===== MAPS ===== */
    .maps-frame{ width:100%; height:320px; border:0; border-radius:var(--radius-card); }

    /* ===== SIDEBAR STICKY BOOKING ===== */
    .booking-sidebar{ position:sticky; top:24px; }
    .booking-card{ background:#fff; border-radius:var(--radius-card); box-shadow:var(--shadow-soft); padding:var(--sp-3); }
    .booking-card .mulai-label{ font-size:.8rem; color:#8a93a3; }
    .booking-card .mulai-harga{ font-size:1.6rem; font-weight:800; color:var(--primary); margin-bottom:var(--sp-3); }
    .kategori-opsi{ display:flex; flex-direction:column; gap:10px; margin-bottom:var(--sp-3); }
    .kategori-opsi label{
        display:flex; justify-content:space-between; align-items:center; border:1.5px solid #e2e8f0;
        border-radius:var(--radius-input); padding:12px 14px; cursor:pointer; transition:.15s ease;
    }
    .kategori-opsi label:has(input:checked){ border-color:var(--primary); background:#f0f6ff; }
    .jumlah-stepper{ display:flex; align-items:center; justify-content:space-between; margin-bottom:var(--sp-3); }
    .stepper-btn{
        width:36px; height:36px; border-radius:50%; border:1.5px solid #e2e8f0; background:#fff;
        font-weight:700; font-size:1.1rem; display:flex; align-items:center; justify-content:center; cursor:pointer;
    }
    .stepper-btn:hover{ border-color:var(--primary); color:var(--primary); }
    .total-row{ display:flex; justify-content:space-between; align-items:center; padding-top:var(--sp-2); border-top:1px dashed #e2e8f0; margin-bottom:var(--sp-3); }
    .total-row .label{ color:#8a93a3; }
    .total-row .value{ font-size:1.3rem; font-weight:800; color:var(--text); }
    .btn-pesan-sekarang{ width:100%; text-align:center; justify-content:center; }

    /* ===== FOOTER ===== */
    .footer-destinasi{ background:#0f172a; color:#cbd5e1; padding:var(--sp-5) var(--sp-3) var(--sp-3); margin-top:var(--sp-5); }
    .footer-destinasi h5{ color:#fff; font-weight:700; margin-bottom:var(--sp-2); }
    .footer-destinasi a{ color:#cbd5e1; text-decoration:none; display:block; margin-bottom:8px; }
    .footer-destinasi a:hover{ color:#fff; }
    .footer-social{ display:flex; gap:12px; margin-top:var(--sp-2); }
    .footer-social a{ width:36px; height:36px; border-radius:50%; background:#1e293b; display:flex; align-items:center; justify-content:center; }
    .footer-bottom{ text-align:center; padding-top:var(--sp-3); margin-top:var(--sp-3); border-top:1px solid #1e293b; font-size:.85rem; color:#64748b; }
</style>

<div class="destinasi-page">

    {{-- ===== HERO FULLSCREEN ===== --}}
    <section class="hero-full" style="background-image:url('{{ asset('images/' . $destinasi->gambar) }}')">
        <div class="hero-content">
            <h1>{{ $destinasi->nama }}</h1>
            <div class="hero-meta">
                <span class="stars">
                    @php $r = round($destinasi->rating ?? 0); @endphp
                    @for ($i=1;$i<=5;$i++)<i class="bi {{ $i <= $r ? 'bi-star-fill' : 'bi-star' }}"></i>@endfor
                    {{ number_format($destinasi->rating ?? 0, 1) }} ({{ $destinasi->ulasan_count ?? ($destinasi->ulasan->count() ?? 0) }} Ulasan)
                </span>
                <span><i class="bi bi-geo-alt-fill"></i> {{ $destinasi->lokasi ?? '-' }}</span>
                <span><i class="bi bi-building"></i> {{ $destinasi->kategori ?? 'Wisata' }}</span>
            </div>
            <div class="hero-price">Mulai Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</div>
            <div class="hero-actions">
                @if ($destinasi->ket_slot === 'habis')
                    <span class="btn-primary-grad disabled" aria-disabled="true" style="opacity:.6;">Tiket Habis</span>
                @else
                    <a href="#booking" class="btn-primary-grad"><i class="bi bi-ticket-perforated-fill"></i> Pesan Tiket</a>
                @endif
                <a href="#galeri" class="btn-outline-white"><i class="bi bi-images"></i> Lihat Galeri</a>
            </div>
        </div>
    </section>

    @if(session('success'))
        <div class="container mt-3"><div class="alert alert-success">{{ session('success') }}</div></div>
    @endif

    {{-- ===== INFORMASI SINGKAT (5 CARD) ===== --}}
    <div class="info-cards-wrap">
        <div class="info-cards">
            <div class="info-cell">
                <i class="bi bi-ticket-perforated-fill"></i>
                <div class="info-label">Harga</div>
                <div class="info-value">Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</div>
            </div>
            <div class="info-cell">
                <i class="bi bi-clock-fill"></i>
                <div class="info-label">Jam Operasional</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($destinasi->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($destinasi->jam_tutup)->format('H:i') }}</div>
            </div>
            <div class="info-cell">
                <i class="bi bi-geo-alt-fill"></i>
                <div class="info-label">Lokasi</div>
                <div class="info-value">{{ $destinasi->lokasi ?? '-' }}</div>
            </div>
            <div class="info-cell">
                <i class="bi bi-star-fill"></i>
                <div class="info-label">Rating</div>
                <div class="info-value">{{ number_format($destinasi->rating ?? 0, 1) }}</div>
            </div>
            <div class="info-cell">
                <i class="bi bi-people-fill"></i>
                <div class="info-label">Kuota</div>
                <div class="info-value">{{ $destinasi->sisa_slot }} tersedia</div>
            </div>
        </div>
    </div>

    {{-- ===== LAYOUT UTAMA: KONTEN + SIDEBAR BOOKING STICKY ===== --}}
    <div class="detail-main-grid">

        <div class="main-content">

            {{-- TENTANG DESTINASI --}}
            <div class="content-section">
                <h2>Tentang Destinasi</h2>
                <p style="color:#475569; line-height:1.7;">{{ $destinasi->deskripsi }}</p>
                <ul class="fasilitas-check">
                    <li><i class="bi bi-check-circle-fill"></i> Parkiran luas</li>
                    <li><i class="bi bi-check-circle-fill"></i> Toilet</li>
                    <li><i class="bi bi-check-circle-fill"></i> Mushola</li>
                    <li><i class="bi bi-check-circle-fill"></i> Area Foto</li>
                    <li><i class="bi bi-check-circle-fill"></i> Taman</li>
                </ul>
            </div>

            {{-- KUOTA HARI INI --}}
            <div class="content-section" id="kuota">
                <h2>Kuota Hari Ini</h2>
                <div class="kuota-bar-track">
                    <div class="kuota-bar-fill" style="width:{{ $destinasi->persen_terisi }}%"></div>
                </div>
                <div class="kuota-total-text">{{ $destinasi->sisa_slot }} Tiket Tersedia</div>
                <div class="kuota-kategori-list">
                    <div class="kuota-kategori-item">
                        <div>
                            <div class="nama">Dewasa</div>
                            <div class="harga">Rp {{ number_format($destinasi->harga_dewasa, 0, ',', '.') }}</div>
                        </div>
                        <div class="sisa">{{ $destinasi->sisa_dewasa }} tiket</div>
                    </div>
                    <div class="kuota-kategori-item">
                        <div>
                            <div class="nama">Anak-anak</div>
                            <div class="harga">Rp {{ number_format($destinasi->harga_anak, 0, ',', '.') }}</div>
                        </div>
                        <div class="sisa">{{ $destinasi->sisa_anak }} tiket</div>
                    </div>
                    <div class="kuota-kategori-item">
                        <div>
                            <div class="nama">Wisatawan Asing</div>
                            <div class="harga">Rp {{ number_format($destinasi->harga_asing, 0, ',', '.') }}</div>
                        </div>
                        <div class="sisa">{{ $destinasi->sisa_asing }} tiket</div>
                    </div>
                </div>
            </div>

            {{-- GALERI MASONRY --}}
            <div class="content-section" id="galeri">
                <h2>Galeri</h2>
                @forelse ($destinasi->galeri ?? [] as $foto)
                    @if ($loop->first)<div class="galeri-masonry">@endif
                        <img src="{{ asset('images/' . $foto->gambar) }}" alt="Galeri {{ $destinasi->nama }}">
                    @if ($loop->last)</div>@endif
                @empty
                    <div class="galeri-empty">
                        <i class="bi bi-camera"></i>
                        <p class="mb-3">Belum ada foto</p>
                        <a href="#" class="btn-primary-grad">Upload Foto Pertama</a>
                    </div>
                @endforelse
            </div>

            {{-- ATRAKSI --}}
            <div class="content-section" id="atraksi">
                <h2>Atraksi</h2>
                <div class="row g-3 mt-1">
                    @forelse ($destinasi->atraksi as $atraksi)
                        <div class="col-md-4">
                            <div class="atraksi-card">
                                <img src="{{ asset('images/' . $atraksi->gambar) }}">
                                <div class="body">
                                    <span class="kategori-tag">{{ $atraksi->kategori }}</span>
                                    <h6 class="mt-2 mb-1">{{ $atraksi->nama }}</h6>
                                    <div class="mb-2" style="color:var(--accent);">
                                        @for ($i=1;$i<=5;$i++)<i class="bi bi-star-fill"></i>@endfor
                                    </div>
                                    <a href="#" class="lihat-detail">Lihat Detail →</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada atraksi untuk destinasi ini.</p>
                    @endforelse
                </div>
            </div>

            {{-- REVIEW --}}
            <div class="content-section" id="review">
                <h2>Review</h2>
                <div class="review-summary">
                    <div class="avg">{{ number_format($destinasi->rating ?? 0, 1) }}</div>
                    <div>
                        <div class="stars">@for ($i=1;$i<=5;$i++)<i class="bi bi-star-fill"></i>@endfor</div>
                        <div style="color:#8a93a3; font-size:.85rem;">{{ $destinasi->ulasan_count ?? ($destinasi->ulasan->count() ?? 0) }} Ulasan</div>
                    </div>
                </div>
                {{-- Daftar ulasan & form ulasan tetap memakai partial yang sudah ada --}}
                @include('partials.ulasan-section', ['destinasi' => $destinasi])
            </div>

            {{-- MAPS --}}
            <div class="content-section" id="maps">
                <h2>Lokasi di Peta</h2>
                <iframe class="maps-frame" loading="lazy"
                    src="https://www.google.com/maps?q={{ urlencode($destinasi->nama . ' ' . ($destinasi->lokasi ?? '')) }}&output=embed">
                </iframe>
            </div>

            {{-- AKSI ADMIN --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('destinasi.create') }}" class="btn btn-navy">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi
                </a>
                <form action="{{ route('destinasi.destroy', $destinasi->id) }}" method="POST"
                      onsubmit="return confirm('Hapus dia sekarang!!! karena dia tidak akan kembali👍🏻.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus Destinasi
                    </button>
                </form>
            </div>

        </div>

        {{-- ===== SIDEBAR BOOKING STICKY ===== --}}
        <aside class="booking-sidebar" id="booking">
            <div class="booking-card">
                <div class="mulai-label">Mulai</div>
                <div class="mulai-harga">Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</div>

                <div class="mb-2" style="font-weight:600;">Kategori</div>
                <div class="kategori-opsi" id="kategoriOpsi">
                    <label>
                        <span><input type="radio" name="kategori" value="dewasa" data-harga="{{ $destinasi->harga_dewasa }}" checked> Dewasa</span>
                        <span class="harga-label">Rp {{ number_format($destinasi->harga_dewasa, 0, ',', '.') }}</span>
                    </label>
                    <label>
                        <span><input type="radio" name="kategori" value="anak" data-harga="{{ $destinasi->harga_anak }}"> Anak</span>
                        <span class="harga-label">Rp {{ number_format($destinasi->harga_anak, 0, ',', '.') }}</span>
                    </label>
                    <label>
                        <span><input type="radio" name="kategori" value="asing" data-harga="{{ $destinasi->harga_asing }}"> Asing</span>
                        <span class="harga-label">Rp {{ number_format($destinasi->harga_asing, 0, ',', '.') }}</span>
                    </label>
                </div>

                <div class="mb-2" style="font-weight:600;">Jumlah</div>
                <div class="jumlah-stepper">
                    <button type="button" class="stepper-btn" id="jumlahMin">-</button>
                    <span id="jumlahVal" style="font-weight:700; font-size:1.1rem;">2</span>
                    <button type="button" class="stepper-btn" id="jumlahPlus">+</button>
                </div>

                <div class="total-row">
                    <span class="label">Total</span>
                    <span class="value" id="totalHarga">Rp 0</span>
                </div>

                @if ($destinasi->ket_slot === 'habis')
                    <span class="btn-primary-grad btn-pesan-sekarang disabled" aria-disabled="true" style="opacity:.6;">Tiket Habis</span>
                @else
                    <a href="{{ route('pesan-tiket') }}?d={{ $destinasi->id }}" class="btn-primary-grad btn-pesan-sekarang" id="pesanSekarangBtn">
                        <i class="bi bi-ticket-perforated-fill"></i> Pesan Sekarang
                    </a>
                @endif
            </div>
        </aside>

    </div>

   
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const jumlahVal = document.getElementById('jumlahVal');
    const totalHarga = document.getElementById('totalHarga');
    const pesanBtn = document.getElementById('pesanSekarangBtn');
    let jumlah = 2;

    function hargaTerpilih() {
        const checked = document.querySelector('input[name="kategori"]:checked');
        return checked ? parseInt(checked.dataset.harga, 10) : 0;
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function updateTotal() {
        const total = hargaTerpilih() * jumlah;
        totalHarga.textContent = formatRupiah(total);
        if (pesanBtn) {
            const url = new URL(pesanBtn.href, window.location.origin);
            url.searchParams.set('jumlah', jumlah);
            url.searchParams.set('kategori', document.querySelector('input[name="kategori"]:checked').value);
            pesanBtn.href = url.toString();
        }
    }

    document.getElementById('jumlahMin').addEventListener('click', function () {
        if (jumlah > 1) { jumlah--; jumlahVal.textContent = jumlah; updateTotal(); }
    });
    document.getElementById('jumlahPlus').addEventListener('click', function () {
        jumlah++; jumlahVal.textContent = jumlah; updateTotal();
    });
    document.querySelectorAll('input[name="kategori"]').forEach(function (radio) {
        radio.addEventListener('change', updateTotal);
    });

    updateTotal();
});
</script>

@endsection