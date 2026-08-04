@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<style>
    .daftar-user-section {
        min-height: 85vh;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .daftar-user-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .daftar-user-section::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -8%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
    }

    .breadcrumb-daftar-user {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-daftar-user .breadcrumb {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-flex;
    }

    .breadcrumb-daftar-user .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-daftar-user .breadcrumb-item a:hover {
        color: #fff;
    }

    .breadcrumb-daftar-user .breadcrumb-item.active {
        color: #fff;
        font-weight: 600;
    }

    .breadcrumb-daftar-user .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .card-daftar-user {
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

    .card-daftar-user-header {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        padding: 2rem 2.5rem;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .card-daftar-user-header .icon-wrap {
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

    .card-daftar-user-header h2 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .card-daftar-user-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }

    .btn-tambah-user {
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

    .btn-tambah-user:hover {
        background: #fff;
        color: #0369a1;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
    }

    .card-daftar-user-body {
        padding: 2rem 2.5rem 2.5rem;
        background: #fff;
    }

    .table-user {
        margin-bottom: 0;
    }

    .table-user thead th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-bottom: none;
        padding: 0.9rem 1rem;
    }

    .table-user tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        border-color: #eef2f6;
        font-size: 0.92rem;
        color: #334155;
    }

    .table-user tbody tr {
        transition: background 0.15s ease;
    }

    .table-user tbody tr:hover {
        background: #f8fafc;
    }

    .badge-role-admin {
        background: linear-gradient(135deg, #dc2626, #ef4444);
        padding: 0.4rem 0.75rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        color: #fff;
    }

    .badge-role-user {
        background: #e2e8f0;
        color: #475569;
        padding: 0.4rem 0.75rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .btn-edit-user {
        border: 1.5px solid #0ea5e9;
        color: #0369a1;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.82rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .btn-edit-user:hover {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9;
    }

    .btn-hapus-user {
        border: 1.5px solid #fca5a5;
        color: #dc2626;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.35rem 0.8rem;
        font-size: 0.82rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .btn-hapus-user:hover {
        background: #dc2626;
        color: #fff;
        border-color: #dc2626;
    }

    .empty-state-user {
        padding: 3rem 1rem;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state-user i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.75rem;
        color: #cbd5e1;
    }

    /* Modal Hapus User (navy/teal theme) */
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

<div class="daftar-user-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="breadcrumb-daftar-user mb-4 text-center">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>

        <div class="card card-daftar-user">

            <div class="card-daftar-user-header">
                <div>
                    <div class="icon-wrap">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2>Daftar User</h2>
                    <p>Kelola seluruh akun pengguna sistem</p>
                </div>
                <a href="{{ route('user.create') }}" class="btn-tambah-user">
                    <i class="bi bi-plus-lg me-1"></i> Tambah User
                </a>
            </div>

            <div class="card-daftar-user-body">
                <div class="table-responsive">
                    <table class="table table-user align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center" style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($userList as $user)
                                <tr>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="{{ $user->role == 'admin' ? 'badge-role-admin' : 'badge-role-user' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-edit-user">
                                            <i class="bi bi-pencil-fill me-1"></i>Edit
                                        </a>

                                        <button type="button"
                                                class="btn btn-hapus-user"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapusUser"
                                                data-nama="{{ $user->name }}"
                                                data-action="{{ route('user.destroy', $user->id) }}">
                                            <i class="bi bi-trash-fill me-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state-user">
                                            <i class="bi bi-inbox"></i>
                                            Belum ada user yang ditambahkan.
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

{{-- ===== MODAL KONFIRMASI HAPUS (center, tema navy + teal) ===== --}}
<div class="modal fade" id="modalHapusUser" tabindex="-1" aria-labelledby="modalHapusUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-hapus-tasik">
            <div class="modal-body text-center pt-4 pb-3 px-4">
                <div class="modal-hapus-icon mx-auto mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="modal-hapus-title mb-2" id="modalHapusUserLabel">Hapus User?</h5>
                <p class="modal-hapus-text mb-0">
                    Yakin ingin menghapus <strong id="modalHapusUserNama">user ini</strong>?
                    Tindakan ini tidak bisa dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-outline-navy px-4" data-bs-dismiss="modal">
                    Batal
                </button>
                <form id="formHapusUser" method="POST" action="" class="d-inline">
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
        var modalHapus = document.getElementById('modalHapusUser');
        modalHapus.addEventListener('show.bs.modal', function (event) {
            var tombol = event.relatedTarget;
            var nama = tombol.getAttribute('data-nama');
            var aksi = tombol.getAttribute('data-action');
            modalHapus.querySelector('#modalHapusUserNama').textContent = nama;
            modalHapus.querySelector('#formHapusUser').setAttribute('action', aksi);
        });
    });
</script>
@endpush
@endsection