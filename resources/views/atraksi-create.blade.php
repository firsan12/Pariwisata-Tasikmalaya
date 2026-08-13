@extends('layouts.site')

@section('title', 'Tambah Atraksi')

@section('content')
<style>
    .form-atraksi-section {
        min-height: 85vh;
        background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .form-atraksi-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .form-atraksi-section::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -8%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
    }

    .breadcrumb-form-atraksi {
        position: relative;
        z-index: 2;
    }

    .breadcrumb-form-atraksi .breadcrumb {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        display: inline-flex;
    }

    .breadcrumb-form-atraksi .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-form-atraksi .breadcrumb-item a:hover {
        color: #fff;
    }

    .breadcrumb-form-atraksi .breadcrumb-item.active {
        color: #fff;
        font-weight: 600;
    }

    .breadcrumb-form-atraksi .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    .card-form-atraksi {
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

    .card-form-atraksi-header {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        padding: 2rem 2.5rem;
        color: #fff;
    }

    .card-form-atraksi-header .icon-wrap {
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

    .card-form-atraksi-header h2 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .card-form-atraksi-header p {
        margin: 0;
        opacity: 0.85;
        font-size: 0.9rem;
    }

    .card-form-atraksi-body {
        padding: 2rem 2.5rem 2.5rem;
        background: #fff;
    }

    .form-atraksi-label {
        font-weight: 600;
        color: #334155;
        font-size: 0.88rem;
        margin-bottom: 0.4rem;
    }

    .form-atraksi-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.92rem;
        transition: all 0.2s ease;
    }

    .form-atraksi-control:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
    }

    .form-atraksi-control.is-invalid {
        border-color: #fca5a5;
    }

    .form-atraksi-hint {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }

    .btn-simpan-atraksi {
        background: linear-gradient(135deg, #0369a1, #0ea5e9);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.65rem 1.6rem;
        transition: all 0.2s ease;
        box-shadow: 0 8px 18px rgba(3, 105, 161, 0.3);
    }

    .btn-simpan-atraksi:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(3, 105, 161, 0.4);
        color: #fff;
    }

    .btn-batal-atraksi {
        border: 1.5px solid #e5e7eb;
        color: #6b7280;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.65rem 1.6rem;
        background: #fff;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-batal-atraksi:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #6b7280;
    }
</style>

<div class="form-atraksi-section">
    <div class="container">

        <nav aria-label="breadcrumb" class="breadcrumb-form-atraksi mb-4 text-center">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('atraksi') }}" style="color: rgba(255,255,255,0.85); text-decoration: none;">Atraksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Atraksi</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-form-atraksi">

                    <div class="card-form-atraksi-header">
                        <div class="icon-wrap">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <h2>Tambah Atraksi Baru</h2>
                        <p>Lengkapi informasi atraksi wisata di bawah ini</p>
                    </div>

                    <div class="card-form-atraksi-body">
                        <form action="{{ route('atraksi.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="destinasi_id" class="form-atraksi-label">Destinasi</label>
                                <select name="destinasi_id" id="destinasi_id" class="form-select form-atraksi-control @error('destinasi_id') is-invalid @enderror">
                                    <option value="" selected disabled>-- Pilih Destinasi --</option>
                                    @foreach ($destinasiList as $destinasi)
                                        <option value="{{ $destinasi->id }}"
                                            {{ old('destinasi_id') == $destinasi->id ? 'selected' : '' }}>
                                            {{ $destinasi->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destinasi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-atraksi-label">Nama Atraksi</label>
                                <input type="text" name="nama" id="nama"
                                       class="form-control form-atraksi-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-atraksi-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                          class="form-control form-atraksi-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kategori" class="form-atraksi-label">Kategori</label>
                                <select name="kategori" id="kategori" class="form-select form-atraksi-control @error('kategori') is-invalid @enderror">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="Budaya" {{ old('kategori') == 'Budaya' ? 'selected' : '' }}>Budaya</option>
                                    <option value="Alam" {{ old('kategori') == 'Alam' ? 'selected' : '' }}>Alam</option>
                                    <option value="Kuliner" {{ old('kategori') == 'Kuliner' ? 'selected' : '' }}>Kuliner</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="harga" class="form-atraksi-label">Harga (Rp)</label>
                                <input type="number" name="harga" id="harga"
                                       class="form-control form-atraksi-control @error('harga') is-invalid @enderror"
                                       value="{{ old('harga') }}">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-atraksi-hint">Isi 0 kalau gratis.</div>
                            </div>

                            <div class="mb-3">
                                <label for="jam_operasional" class="form-atraksi-label">Jam Operasional</label>
                                <input type="text" name="jam_operasional" id="jam_operasional"
                                       class="form-control form-atraksi-control @error('jam_operasional') is-invalid @enderror"
                                       value="{{ old('jam_operasional') }}"
                                       placeholder="contoh: 08.00-17.30 WIB, setiap hari">
                                @error('jam_operasional')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-atraksi-hint">Bisa ditulis bebas, misal beda jam weekday/weekend atau "24 jam".</div>
                            </div>

                            <div class="mb-4">
                                <label for="gambar" class="form-atraksi-label">Nama File Gambar</label>
                                <input type="text" name="gambar" id="gambar"
                                       class="form-control form-atraksi-control @error('gambar') is-invalid @enderror"
                                       value="{{ old('gambar') }}"
                                       placeholder="contoh: atraksi/tari-zapin.jpg">
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-atraksi-hint">
                                    Wajib sertakan folder <code>atraksi/</code> di depan nama file, sesuai lokasi file di <code>storage/atraksi/</code>. Nama harus sama persis (besar/kecil huruf & spasi).
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-simpan-atraksi">
                                    <i class="bi bi-check-lg me-1"></i>Simpan Atraksi
                                </button>
                                <a href="{{ route('atraksi') }}" class="btn-batal-atraksi">
                                    Batal
                                </a>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection