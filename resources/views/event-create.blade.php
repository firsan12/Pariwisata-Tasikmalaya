@extends('layouts.site')

@section('title', 'Tambah Event & Promo')

@section('content')
<style>
    .form-event-section {
        min-height: 85vh;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
    }
    .card-form-event {
        border: none;
        border-radius: 24px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        max-width: 700px;
        margin: 0 auto;
    }
    .card-form-event-header {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        padding: 2rem 2.5rem;
        color: #fff;
    }
    .card-form-event-body {
        padding: 2.5rem;
        background: #fff;
    }
    .btn-simpan-event {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        color: #fff;
        font-weight: 600;
        padding: 0.7rem 1.8rem;
        border-radius: 10px;
        border: none;
    }
    .btn-simpan-event:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(3, 105, 161, 0.3);
    }
</style>

<div class="form-event-section">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4 text-center">
            <ol class="breadcrumb justify-content-center mb-0" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); padding: 0.6rem 1.2rem; border-radius: 50px; display: inline-flex;">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}" class="text-white-50">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('event.admin') }}" class="text-white-50">Event &amp; Promo</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Tambah</li>
            </ol>
        </nav>

        <div class="card card-form-event">
            <div class="card-form-event-header">
                <h2 class="fw-bold mb-1">Tambah Event &amp; Promo</h2>
                <p class="mb-0 opacity-75">Isi detail event atau promo baru</p>
            </div>

            <div class="card-form-event-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Event</label>
                        <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="promo" class="form-label fw-semibold">Label Promo</label>
                        <input type="text" name="promo" id="promo" class="form-control" placeholder="Contoh: Diskon 20%" value="{{ old('promo') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold">Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="urutan" class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="urutan" id="urutan" class="form-control" min="0" value="{{ old('urutan', 0) }}">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-simpan-event">
                            <i class="bi bi-check-lg me-1"></i> Simpan Event
                        </button>
                        <a href="{{ route('event.admin') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection