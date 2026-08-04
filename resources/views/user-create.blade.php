@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<style>
    .form-tambah-user-section {
        min-height: 85vh;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .form-tambah-user-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .form-tambah-user-section::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -8%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
    }

    .breadcrumb-tambah-user {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-tambah-user .breadcrumb {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-flex;
    }

    .breadcrumb-tambah-user .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-tambah-user .breadcrumb-item a:hover {
        color: #fff;
    }

    .breadcrumb-tambah-user .breadcrumb-item.active {
        color: #fff;
        font-weight: 600;
    }

    .breadcrumb-tambah-user .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .card-tambah-user {
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

    .card-tambah-user-header {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        padding: 2rem 2.5rem;
        color: #fff;
    }

    .card-tambah-user-header .icon-wrap {
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

    .card-tambah-user-header h2 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .card-tambah-user-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }

    .card-tambah-user-body {
        padding: 2.5rem;
        background: #fff;
    }

    .form-floating-icon {
        position: relative;
        margin-bottom: 1.4rem;
    }

    .form-floating-icon label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #4b5563;
        margin-bottom: 0.4rem;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .input-icon-group {
        position: relative;
    }

    .input-icon-group .icon-inside {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.1rem;
        pointer-events: none;
        transition: color 0.2s ease;
    }

    .input-icon-group .form-control,
    .input-icon-group .form-select {
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        background: #f9fafb;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .input-icon-group .form-control:focus,
    .input-icon-group .form-select:focus {
        border-color: #0ea5e9;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
    }

    .input-icon-group .form-control:focus ~ .icon-inside,
    .input-icon-group:focus-within .icon-inside {
        color: #0ea5e9;
    }

    .btn-simpan-user {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        border: none;
        color: #fff;
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        border-radius: 12px;
        transition: all 0.25s ease;
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
    }

    .btn-simpan-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(14, 165, 233, 0.4);
        color: #fff;
    }

    .btn-batal-user {
        border: 1.5px solid #e5e7eb;
        color: #6b7280;
        font-weight: 600;
        padding: 0.75rem 1.75rem;
        border-radius: 12px;
        transition: all 0.2s ease;
        background: #fff;
    }

    .btn-batal-user:hover {
        border-color: #d1d5db;
        background: #f9fafb;
        color: #374151;
    }
</style>

<div class="form-tambah-user-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="breadcrumb-tambah-user mb-4 text-center">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user') }}">User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-tambah-user">

                    <div class="card-tambah-user-header">
                        <div class="icon-wrap">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h2>Tambah User Baru</h2>
                        <p>Lengkapi data di bawah untuk menambahkan akun pengguna</p>
                    </div>

                    <div class="card-tambah-user-body">
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="form-floating-icon">
                                <label for="name">Nama</label>
                                <div class="input-icon-group">
                                    <i class="bi bi-person-fill icon-inside"></i>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <div class="form-floating-icon">
                                <label for="email">Email</label>
                                <div class="input-icon-group">
                                    <i class="bi bi-envelope-fill icon-inside"></i>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required>
                                </div>
                            </div>

                            <div class="form-floating-icon">
                                <label for="password">Password</label>
                                <div class="input-icon-group">
                                    <i class="bi bi-lock-fill icon-inside"></i>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required>
                                </div>
                            </div>

                            <div class="form-floating-icon mb-2">
                                <label for="role">Role</label>
                                <div class="input-icon-group">
                                    <i class="bi bi-shield-fill icon-inside"></i>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-simpan-user">
                                    <i class="bi bi-check-lg me-1"></i> Simpan User
                                </button>
                                <a href="{{ route('user') }}" class="btn btn-batal-user">Batal</a>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection