@extends('layouts.site')

@section('title', 'Daftar Atraksi')

@section('content')
<style>
    .daftar-atraksi-section {
        min-height: 85vh;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .daftar-atraksi-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .daftar-atraksi-section::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -8%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
    }

    .breadcrumb-daftar-atraksi {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-daftar-atraksi .breadcrumb {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-flex;
    }

    .breadcrumb-daftar-atraksi .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-daftar-atraksi .breadcrumb-item a:hover {
        color: #fff;
    }

    .breadcrumb-daftar-atraksi .breadcrumb-item.active {
        color: #fff;
        font-weight: 600;
    }

    .breadcrumb-daftar-atraksi .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .card-daftar-atraksi {
        border: none;
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
        position: relative;
        z-index: 2;
        overflow: hidden;
        animation: fadeSlideUp 0.5s ease;
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card-daftar-atraksi-header {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        padding: 2rem 2.5rem;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-daftar-atraksi-header .icon-wrap {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .card-daftar-atraksi-header h2 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .card-daftar-atraksi-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }

    .btn-tambah-atraksi {
        background: rgba(255, 255, 255, 0.95);
        color: #0369a1;
        font-weight: 600;
        padding: 0.65rem 1.4rem;
        border-radius: 12px;
        border: none;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-tambah-atraksi:hover {
        background: #fff;
        color: #0369a1;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

    .card-daftar-atraksi-body {
        padding: 2rem 2.5rem 2.5rem;
        background: #fff;
    }

    .kartu-atraksi {
        border: 1px solid #eef2f6;
        border-radius: 16px;
        overflow: hidden;
        height: 100%;
        transition: all 0.2s ease;
        background: #fff;
    }

    .kartu-atraksi:hover {
        box-shadow: 0 12px 28px rgba(3, 105, 161, 0.12);
        transform: translateY(-3px);
        border-color: #bae6fd;
    }

    .kartu-atraksi-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        display: block;
        background: #f1f5f9;
    }

    .kartu-atraksi-img-placeholder {
        width: 100%;
        height: 160px;
        background: #f1f5f9;
        color: #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .kartu-atraksi-body {
        padding: 1.4rem;
    }

    .badge-kategori {
        background: #e0f2fe;
        color: #0369a1;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        display: inline-block;
        margin-bottom: 0.75rem;
    }

    .kartu-atraksi-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .kartu-atraksi-desc {
        color: #64748b;
        font-size: 0.88rem;
        margin-bottom: 0.9rem;
    }

    .kartu-atraksi-jam {
        color: #0369a1;
        font-size: 0.82rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .kartu-atraksi-harga {
        color: #0369a1;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .btn-edit-atraksi {
        border: 1.5px solid #0ea5e9;
        color: #0369a1;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.82rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .btn-edit-atraksi:hover {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9;
    }

    .btn-hapus-atraksi {
        border: 1.5px solid #fca5a5;
        color: #dc2626;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.82rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .btn-hapus-atraksi:hover {
        background: #dc2626;
        color: #fff;
        border-color: #dc2626;
    }

    .empty-state-atraksi {
        padding: 3rem 1rem;
        text-align: center;
        color: #94a3b8;
        width: 100%;
    }

    .empty-state-atraksi i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.75rem;
        color: #cbd5e1;
    }

    /* Modal Hapus Atraksi (navy/teal theme) */
    .modal-hapus-tasik {
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-hapus-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #fecaca, #fca5a5);
        color: #dc2626;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .modal-hapus-title {
        font-weight: 700;
        color: #1e293b;
    }

    .modal-hapus-text {
        color: #64748b;
        font-size: 0.92rem;
    }

    .btn-outline-navy {
        border: 1.5px solid #e5e7eb;
        color: #6b7280;
        font-weight: 600;
        border-radius: 10px;
        background: #fff;
        transition: all 0.2s ease;
    }

    .btn-outline-navy:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #6b7280;
    }

    .btn-navy {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s ease;
        box-shadow: 0 8px 18px rgba(220, 38, 38, 0.3);
    }

    .btn-navy:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.4);
        color: #fff;
    }
</style>

<div class="daftar-atraksi-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="breadcrumb-daftar-atraksi mb-4 text-center">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Atraksi</li>
            </ol>
        </nav>

        <div class="card card-daftar-atraksi">

            <div class="card-daftar-atraksi-header">
                <div>
                    <div class="icon-wrap">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h2>Daftar Atraksi</h2>
                    <p>Kelola seluruh atraksi wisata</p>
                </div>
                <a href="{{ route('atraksi.create') }}" class="btn-tambah-atraksi">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Atraksi
                </a>
            </div>

            <div class="card-daftar-atraksi-body">
                <div class="row g-4">
                    @forelse ($atraksiList as $atraksi)
                        <div class="col-md-4">
                            <div class="kartu-atraksi">
                                @if (!empty($atraksi->gambar))
                                    <img src="{{ asset('images/' . $atraksi->gambar) }}"
                                         alt="{{ $atraksi->nama }}"
                                         class="kartu-atraksi-img"
                                         onerror="this.onerror=null;this.replaceWith(Object.assign(document.createElement('div'),{className:'kartu-atraksi-img-placeholder',innerHTML:'<i class=&quot;bi bi-image&quot;></i>'}));">
                                @else
                                    <div class="kartu-atraksi-img-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif

                                <div class="kartu-atraksi-body">
                                    <span class="badge-kategori">{{ $atraksi->kategori }}</span>
                                    <h5 class="kartu-atraksi-title">{{ $atraksi->nama }}</h5>
                                    <p class="kartu-atraksi-desc">{{ Str::limit($atraksi->deskripsi ?? '', 80) }}</p>

                                    @if (!empty($atraksi->jam_operasional))
                                        <p class="kartu-atraksi-jam">
                                            <i class="bi bi-clock"></i>
                                            {{ $atraksi->jam_operasional }}
                                        </p>
                                    @endif

                                    <p class="kartu-atraksi-harga">
                                        {{ $atraksi->harga == 0 ? 'Gratis' : 'Rp ' . number_format($atraksi->harga, 0, ',', '.') }}
                                    </p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('atraksi.edit', $atraksi->id) }}" class="btn btn-edit-atraksi">
                                            <i class="bi bi-pencil-fill me-1"></i>Edit
                                        </a>

                                        <button type="button"
                                                class="btn btn-hapus-atraksi"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusAtraksi"
                                                data-nama="{{ $atraksi->nama }}"
                                                data-action="{{ route('atraksi.destroy', $atraksi->id) }}">
                                            <i class="bi bi-trash-fill me-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-atraksi">
                            <i class="bi bi-inbox"></i>
                            Belum ada atraksi yang ditambahkan.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

{{-- ===== MODAL KONFIRMASI HAPUS (center, tema navy + teal) ===== --}}
<div class="modal fade" id="modalHapusAtraksi" tabindex="-1" aria-labelledby="modalHapusAtraksiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-hapus-tasik">
            <div class="modal-body text-center pt-4 pb-3 px-4">
                <div class="modal-hapus-icon mx-auto mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="modal-hapus-title mb-2" id="modalHapusAtraksiLabel">Hapus Atraksi?</h5>
                <p class="modal-hapus-text mb-0">
                    Yakin ingin menghapus <strong id="modalHapusAtraksiNama">atraksi ini</strong>?
                    Tindakan ini tidak bisa dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-outline-navy px-4" data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="formHapusAtraksi" method="POST" action="" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-navy px-4">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalHapus = document.getElementById('modalHapusAtraksi');
        modalHapus.addEventListener('show.bs.modal', function (event) {
            var tombol = event.relatedTarget;
            var nama = tombol.getAttribute('data-nama');
            var aksi = tombol.getAttribute('data-action');
            modalHapus.querySelector('#modalHapusAtraksiNama').textContent = nama;
            modalHapus.querySelector('#formHapusAtraksi').setAttribute('action', aksi);
        });
    });
</script>
@endpush
@endsection