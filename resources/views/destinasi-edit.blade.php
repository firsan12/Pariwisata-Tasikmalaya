@extends('layouts.site')

@section('title', 'Ubah Destinasi')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/destinasi-theme.css') }}">

<div class="container tasik-permit-page">

    {{-- Breadcrumb navigasi --}}
    <nav aria-label="breadcrumb">
        <ol class="tasik-breadcrumb">
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li><a href="{{ route('destinasi') }}">Destinasi</a></li>
            <li class="active" aria-current="page">Ubah Destinasi</li>
        </ol>
    </nav>

    <div class="tasik-permit-wrap">
        <div class="tasik-stamp tasik-stamp--edit">Revisi<br>Data</div>

        <div class="tasik-permit">
            <div class="tasik-permit-head">
                <div class="tasik-eyebrow">Formulir Perubahan</div>
                <h2>Ubah Destinasi</h2>
                <p class="tasik-sub">Perbarui data "{{ $destinasi->nama }}" agar informasinya tetap akurat.</p>
            </div>

            <div class="tasik-tear"></div>

            <div class="tasik-permit-body">

                @if (session('success'))
                    <div class="alert-tasik alert-tasik--success">
                        <div class="alert-title"><i class="bi bi-check-circle"></i> Berhasil</div>
                        <p class="mb-0" style="font-size:.88rem;">{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-tasik">
                        <div class="alert-title"><i class="bi bi-exclamation-triangle"></i> Perlu diperiksa lagi</div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('destinasi.update', $destinasi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="tasik-field">
                        <label for="nama" class="tasik-label"><i class="bi bi-signpost-2"></i> Nama Destinasi</label>
                        <input
                            type="text"
                            class="tasik-input"
                            id="nama"
                            name="nama"
                            value="{{ old('nama', $destinasi->nama) }}"
                            placeholder="contoh: Istana Siak Sri Indrapura"
                            required
                        >
                    </div>

                    <div class="tasik-field">
                        <label for="deskripsi" class="tasik-label"><i class="bi bi-journal-text"></i> Deskripsi</label>
                        <textarea
                            class="tasik-input"
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            placeholder="Ceritakan tentang destinasi ini..."
                            required
                        >{{ old('deskripsi', $destinasi->deskripsi) }}</textarea>
                    </div>

                    <div class="tasik-field">
                        <label for="gambar" class="tasik-label"><i class="bi bi-image"></i> Nama File Gambar</label>
                       <input type="file" name="gambar" class="form-control" accept="image/*">
                        <div class="tasik-hint">Sementara isi nama file gambar yang sudah tersedia di folder public/images.</div>
                    </div>

                    <div class="tasik-row-2">
                        <div class="tasik-field">
                            <label for="jam_buka" class="tasik-label"><i class="bi bi-sunrise"></i> Jam Buka</label>
                            <input
                                type="text"
                                class="tasik-input jam-24-input"
                                id="jam_buka"
                                name="jam_buka"
                                value="{{ old('jam_buka', \Carbon\Carbon::parse($destinasi->jam_buka)->format('H:i')) }}"
                                placeholder="HH:mm"
                                inputmode="numeric"
                                maxlength="5"
                                pattern="^([01]\d|2[0-3]):[0-5]\d$"
                                autocomplete="off"
                                required
                            >
                            <div class="tasik-hint">Format 24 jam, contoh: 08:00</div>
                        </div>
                        <div class="tasik-field">
                            <label for="jam_tutup" class="tasik-label"><i class="bi bi-sunset"></i> Jam Tutup</label>
                            <input
                                type="text"
                                class="tasik-input jam-24-input"
                                id="jam_tutup"
                                name="jam_tutup"
                                value="{{ old('jam_tutup', \Carbon\Carbon::parse($destinasi->jam_tutup)->format('H:i')) }}"
                                placeholder="HH:mm"
                                inputmode="numeric"
                                maxlength="5"
                                pattern="^([01]\d|2[0-3]):[0-5]\d$"
                                autocomplete="off"
                                required
                            >
                            <div class="tasik-hint">Format 24 jam, contoh: 17:30</div>
                        </div>
                    </div>

                    <div class="tasik-field">
                        <label for="lokasi" class="tasik-label"><i class="bi bi-geo-alt"></i> Lokasi</label>
                        <input
                            type="text"
                            class="tasik-input"
                            id="lokasi"
                            name="lokasi"
                            value="{{ old('lokasi', $destinasi->lokasi) }}"
                            placeholder="contoh: Kecamatan Siak, Kabupaten Siak"
                        >
                    </div>

                    <div class="tasik-row-2">
                        <div class="tasik-field">
                            <label for="latitude" class="tasik-label"><i class="bi bi-pin-map"></i> Latitude</label>
                            <input
                                type="text"
                                class="tasik-input"
                                id="latitude"
                                name="latitude"
                                value="{{ old('latitude', $destinasi->latitude) }}"
                                placeholder="-7.3274"
                            >
                            <div class="tasik-hint">Ambil dari Google Maps: klik kanan lokasi → klik koordinat untuk copy.</div>
                        </div>
                        <div class="tasik-field">
                            <label for="longitude" class="tasik-label"><i class="bi bi-pin-map"></i> Longitude</label>
                            <input
                                type="text"
                                class="tasik-input"
                                id="longitude"
                                name="longitude"
                                value="{{ old('longitude', $destinasi->longitude) }}"
                                placeholder="108.2207"
                            >
                            <div class="tasik-hint">Angka kedua dari koordinat Google Maps.</div>
                        </div>
                    </div>

                    <div class="tasik-row-2" style="grid-template-columns: repeat(3, 1fr);">
                        <div class="tasik-field">
                            <label class="tasik-label"><i class="bi bi-person"></i> Harga Dewasa (Rp)</label>
                            <input type="number" class="tasik-input" name="harga_dewasa" min="0" value="{{ old('harga_dewasa', $destinasi->harga_dewasa) }}" required>
                        </div>
                        <div class="tasik-field">
                            <label class="tasik-label"><i class="bi bi-emoji-smile"></i> Harga Anak (Rp)</label>
                            <input type="number" class="tasik-input" name="harga_anak" min="0" value="{{ old('harga_anak', $destinasi->harga_anak) }}" required>
                        </div>
                        <div class="tasik-field">
                            <label class="tasik-label"><i class="bi bi-globe"></i> Harga Asing (Rp)</label>
                            <input type="number" class="tasik-input" name="harga_asing" min="0" value="{{ old('harga_asing', $destinasi->harga_asing) }}" required>
                        </div>
                    </div>

                    <div class="tasik-row-2" style="grid-template-columns: repeat(3, 1fr);">
                        <div class="tasik-field">
                            <label class="tasik-label"><i class="bi bi-people"></i> Kuota Dewasa</label>
                            <input type="number" class="tasik-input" name="kuota_dewasa" min="0" value="{{ old('kuota_dewasa', $destinasi->kuota_dewasa) }}" required>
                            <div class="tasik-hint">Terisi saat ini: {{ $destinasi->terisi_dewasa }}</div>
                        </div>
                        <div class="tasik-field">
                            <label class="tasik-label"><i class="bi bi-people"></i> Kuota Anak</label>
                            <input type="number" class="tasik-input" name="kuota_anak" min="0" value="{{ old('kuota_anak', $destinasi->kuota_anak) }}" required>
                            <div class="tasik-hint">Terisi saat ini: {{ $destinasi->terisi_anak }}</div>
                        </div>
                        <div class="tasik-field">
                            <label class="tasik-label"><i class="bi bi-people"></i> Kuota Asing</label>
                            <input type="number" class="tasik-input" name="kuota_asing" min="0" value="{{ old('kuota_asing', $destinasi->kuota_asing) }}" required>
                            <div class="tasik-hint">Terisi saat ini: {{ $destinasi->terisi_asing }}</div>
                        </div>
                    </div>

                    <div class="tasik-actions">
                        <button type="submit" class="tasik-btn tasik-btn-primary">
                            <i class="bi bi-check2-circle"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('destinasi') }}" class="tasik-btn tasik-btn-ghost">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                    </div>

                </form>

                {{-- ===== Hapus Destinasi ===== --}}
                <div class="tasik-actions tasik-actions--split">
                    <span class="tasik-hint mb-0">Tindakan ini tidak bisa dibatalkan.</span>
                    <form action="{{ route('destinasi.destroy', $destinasi->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus destinasi &quot;{{ $destinasi->nama }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="tasik-btn tasik-btn-danger">
                            <i class="bi bi-trash3"></i> Hapus Destinasi
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    document.querySelectorAll('.jam-24-input').forEach(function (input) {
        input.addEventListener('input', function () {
            let digits = input.value.replace(/\D/g, '').slice(0, 4);

            if (digits.length >= 3) {
                let jam = digits.slice(0, 2);
                let menit = digits.slice(2, 4);
                input.value = jam + ':' + menit;
            } else {
                input.value = digits;
            }
        });

        input.addEventListener('blur', function () {
            let match = input.value.match(/^(\d{1,2}):?(\d{0,2})$/);
            if (!match) return;

            let jam = Math.min(parseInt(match[1] || '0', 10), 23);
            let menit = Math.min(parseInt(match[2] || '0', 10), 59);

            input.value = String(jam).padStart(2, '0') + ':' + String(menit).padStart(2, '0');
        });
    });
</script>
@endsection