@extends('layouts.app')

@section('title', 'Manajemen Destinasi')

@section('content')
<style>
    .admin-destinasi-section {
        min-height: 85vh;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .admin-destinasi-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .admin-destinasi-section::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -8%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
    }

    .breadcrumb-admin-destinasi {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-admin-destinasi .breadcrumb {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-flex;
    }

    .breadcrumb-admin-destinasi .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-admin-destinasi .breadcrumb-item a:hover {
        color: #fff;
    }

    .breadcrumb-admin-destinasi .breadcrumb-item.active {
        color: #fff;
        font-weight: 600;
    }

    .breadcrumb-admin-destinasi .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .card-admin-destinasi {
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

    .card-admin-destinasi-header {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        padding: 2rem 2.5rem;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-admin-destinasi-header .icon-wrap {
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

    .card-admin-destinasi-header h2 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .card-admin-destinasi-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }

    .btn-tambah-destinasi {
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

    .btn-tambah-destinasi:hover {
        background: #fff;
        color: #0369a1;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

    .card-admin-destinasi-body {
        padding: 2rem 2.5rem 2.5rem;
        background: #fff;
    }

    .admin-cari-form .form-control {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        padding: 0.6rem 1rem;
    }

    .admin-cari-form .btn-cari {
        background: #0369a1;
        color: #fff;
        border-radius: 10px;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border: none;
    }

    .admin-cari-form .btn-cari:hover {
        background: #0c4a6e;
    }

    .table-destinasi-admin {
        margin-bottom: 0;
    }

    .table-destinasi-admin thead th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: none;
        padding: 0.9rem 1rem;
        white-space: nowrap;
    }

    .table-destinasi-admin tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        border-color: #eef2f6;
        font-size: 0.88rem;
        color: #334155;
    }

    .table-destinasi-admin tbody tr:hover {
        background: #f8fafc;
    }

    .thumb-destinasi-admin {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        object-fit: cover;
        background: #f1f5f9;
    }

    .badge-status-admin {
        padding: 0.3rem 0.7rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.72rem;
        text-transform: uppercase;
    }

    .badge-status-admin.buka {
        background: #dcfce7;
        color: #16a34a;
    }

    .badge-status-admin.tutup {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-edit-destinasi {
        border: 1.5px solid #0ea5e9;
        color: #0369a1;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.82rem;
        transition: all 0.2s ease;
        background: #fff;
        white-space: nowrap;
    }

    .btn-edit-destinasi:hover {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9;
    }

    .btn-hapus-destinasi {
        border: 1.5px solid #fca5a5;
        color: #dc2626;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.82rem;
        transition: all 0.2s ease;
        background: #fff;
        white-space: nowrap;
    }

    .btn-hapus-destinasi:hover {
        background: #dc2626;
        color: #fff;
        border-color: #dc2626;
    }

    .empty-state-destinasi-admin {
        padding: 3rem 1rem;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state-destinasi-admin i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.75rem;
        color: #cbd5e1;
    }

    /* Modal Hapus (navy/teal theme, sama seperti Atraksi & User) */
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

<div class="admin-destinasi-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="breadcrumb-admin-destinasi mb-4 text-center">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Destinasi</li>
            </ol>
        </nav>

        @if (session('success'))
            <div class="alert alert-success position-relative" style="z-index: 2;">{{ session('success') }}</div>
        @endif

        <div class="card card-admin-destinasi">

            <div class="card-admin-destinasi-header">
                <div>
                    <div class="icon-wrap">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h2>Manajemen Destinasi</h2>
                    <p>Kelola seluruh destinasi wisata</p>
                </div>
                <a href="{{ route('destinasi.create') }}" class="btn-tambah-destinasi">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi
                </a>
            </div>

            <div class="card-admin-destinasi-body">

                <form action="{{ route('destinasi.admin') }}" method="GET" class="admin-cari-form d-flex gap-2 mb-4">
                    <input type="text" name="cari" class="form-control" placeholder="Cari nama destinasi..." value="{{ $keyword ?? '' }}">
                    <button type="submit" class="btn-cari"><i class="bi bi-search"></i></button>
                    @if (!empty($keyword))
                        <a href="{{ route('destinasi.admin') }}" class="btn btn-outline-navy px-3 d-flex align-items-center">Reset</a>
                    @endif
                </form>

                <div class="table-responsive">
                    <table class="table table-destinasi-admin align-middle">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Jam Operasional</th>
                                <th>Harga (Dewasa / Anak / Asing)</th>
                                <th>Kuota (D/A/As)</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($destinasiList as $destinasi)
                                <tr>
                                    <td>
                                        @if (!empty($destinasi->gambar))
                                            <img src="{{ asset('images/' . $destinasi->gambar) }}"
                                                 alt="{{ $destinasi->nama }}"
                                                 class="thumb-destinasi-admin"
                                                 onerror="this.src='https://via.placeholder.com/56?text=%20';">
                                        @else
                                            <div class="thumb-destinasi-admin d-flex align-items-center justify-content-center">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $destinasi->nama }}</td>
                                    <td>{{ Str::limit($destinasi->lokasi ?? '-', 30) }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($destinasi->jam_buka)->format('H:i') }}
                                        – {{ \Carbon\Carbon::parse($destinasi->jam_tutup)->format('H:i') }}
                                    </td>
                                    <td>
                                        Rp {{ number_format($destinasi->harga_dewasa, 0, ',', '.') }} /
                                        Rp {{ number_format($destinasi->harga_anak, 0, ',', '.') }} /
                                        Rp {{ number_format($destinasi->harga_asing, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{ $destinasi->kuota_dewasa }} / {{ $destinasi->kuota_anak }} / {{ $destinasi->kuota_asing }}
                                    </td>
                                    <td>
                                        <span class="badge-status-admin {{ $destinasi->is_buka ? 'buka' : 'tutup' }}">
                                            {{ $destinasi->is_buka ? 'Buka' : 'Tutup' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('destinasi.edit', $destinasi->id) }}" class="btn btn-edit-destinasi">
                                                <i class="bi bi-pencil-fill me-1"></i>Edit
                                            </a>
                                            <button type="button"
                                                    class="btn btn-hapus-destinasi"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalHapusDestinasi"
                                                    data-nama="{{ $destinasi->nama }}"
                                                    data-action="{{ route('destinasi.destroy', $destinasi->id) }}">
                                                <i class="bi bi-trash-fill me-1"></i>Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state-destinasi-admin">
                                            <i class="bi bi-inbox"></i>
                                            @if (!empty($keyword))
                                                Tidak ditemukan destinasi dengan nama "{{ $keyword }}".
                                            @else
                                                Belum ada destinasi yang ditambahkan.
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div class="modal fade" id="modalHapusDestinasi" tabindex="-1" aria-labelledby="modalHapusDestinasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-hapus-tasik">
            <div class="modal-body text-center pt-4 pb-3 px-4">
                <div class="modal-hapus-icon mx-auto mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="modal-hapus-title mb-2" id="modalHapusDestinasiLabel">Hapus Destinasi?</h5>
                <p class="modal-hapus-text mb-0">
                    Yakin ingin menghapus <strong id="modalHapusDestinasiNama">destinasi ini</strong>?
                    Tindakan ini tidak bisa dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-outline-navy px-4" data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="formHapusDestinasi" method="POST" action="" class="d-inline">
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
        var modalHapus = document.getElementById('modalHapusDestinasi');
        modalHapus.addEventListener('show.bs.modal', function (event) {
            var tombol = event.relatedTarget;
            var nama = tombol.getAttribute('data-nama');
            var aksi = tombol.getAttribute('data-action');
            modalHapus.querySelector('#modalHapusDestinasiNama').textContent = nama;
            modalHapus.querySelector('#formHapusDestinasi').setAttribute('action', aksi);
        });
    });
</script>
@endpush
@endsection