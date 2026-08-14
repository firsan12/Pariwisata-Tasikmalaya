@extends('layouts.site')
@section('title', 'Wisata Tasikmalaya - Kontak')
@section('content')

{{--
    Info kontak (email, whatsapp, alamat, jam operasional) sekarang datang
    dari KontakController (tabel profil_situs). Variabel di bawah ini hanya
    fallback kalau datanya belum di-seed.
--}}
@php
    $adaProfil = isset($profilSitus) && $profilSitus->id;

    $kontakJudul = $adaProfil && $profilSitus->kontak_judul ? $profilSitus->kontak_judul : 'Ada Pertanyaan atau Saran?';
    $kontakIntro = $adaProfil && $profilSitus->kontak_intro ? $profilSitus->kontak_intro
        : 'Kirimkan pesan Anda kepada kami, atau hubungi langsung lewat kontak di bawah ini.';

    $kontakEmail = $adaProfil && $profilSitus->kontak_email ? $profilSitus->kontak_email : 'firmanihsan13@gmail.com';
    $kontakWhatsapp = $adaProfil && $profilSitus->kontak_whatsapp ? $profilSitus->kontak_whatsapp : '6281261604202';
    $kontakWhatsappDisplay = $adaProfil && $profilSitus->kontak_whatsapp_display ? $profilSitus->kontak_whatsapp_display : '0812-6160-4202';
    $kontakAlamat = $adaProfil && $profilSitus->kontak_alamat ? $profilSitus->kontak_alamat : 'Dinas Pariwisata, Kota Tasikmalaya, Jawa Barat';
    $kontakAlamatMapsUrl = $adaProfil && $profilSitus->kontak_alamat_maps_url ? $profilSitus->kontak_alamat_maps_url
        : 'https://www.google.com/maps/search/?api=1&query=Dinas+Pariwisata+Kota+Tasikmalaya+Jawa+Barat';
    $kontakJamOperasional = $adaProfil && $profilSitus->kontak_jam_operasional ? $profilSitus->kontak_jam_operasional : 'Senin – Jumat, 08.00 – 16.00 WIB';
@endphp

<section class="kontak-section py-5">
    <div class="kontak-bg"></div>

    <div class="container kontak-content position-relative" style="z-index: 2;">

        {{-- Bagian 1: Judul & Pengantar --}}
        <div class="text-center mb-5">
            <span class="kontak-label">Hubungi Kami</span>
            <h2 class="text-white">{{ $kontakJudul }}</h2>
            <p class="kontak-intro mx-auto">
                {{ $kontakIntro }}
            </p>
        </div>

        <div class="row gy-4">

            {{-- Bagian 2: Info Kontak (kiri) --}}
            <div class="col-12 col-lg-5">
                <div class="kontak-info-card h-100">
                    <h4 class="mb-4">Informasi Kontak</h4>

                    <div class="kontak-item">
                        <span class="kontak-icon"><i class="bi bi-envelope-fill"></i></span>
                        <div>
                            <h6>Email</h6>
                            <p><a href="mailto:{{ $kontakEmail }}">{{ $kontakEmail }}</a></p>
                        </div>
                    </div>

                    <div class="kontak-item">
                        <span class="kontak-icon"><i class="bi bi-whatsapp"></i></span>
                        <div>
                            <h6>WhatsApp</h6>
                            <p><a href="https://wa.me/{{ $kontakWhatsapp }}" target="_blank" rel="noopener">{{ $kontakWhatsappDisplay }}</a></p>
                        </div>
                    </div>

                    <div class="kontak-item">
                        <span class="kontak-icon"><i class="bi bi-geo-alt-fill"></i></span>
                        <div>
                            <h6>Alamat</h6>
                            <p>
                                <a href="{{ $kontakAlamatMapsUrl }}" target="_blank" rel="noopener">
                                    {{ $kontakAlamat }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="kontak-item mb-0">
                        <span class="kontak-icon"><i class="bi bi-clock-fill"></i></span>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p>{{ $kontakJamOperasional }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian 3: Form (kanan) --}}
            <div class="col-12 col-lg-7">
                <div class="kontak-card">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kontak.send') }}" method="POST">
                        @csrf

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                            <label for="nama">Nama</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <textarea class="form-control" id="pesan" name="pesan" placeholder="Pesan" style="height: 130px" required></textarea>
                            <label for="pesan">Pesan</label>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="button" id="btnWhatsapp" class="btn btn-kirim w-100">
                                <i class="bi bi-whatsapp"></i> <span>Kirim via WhatsApp</span>
                            </button>

                            <button type="submit" class="btn btn-kirim w-100">
                                <i class="bi bi-send-fill"></i> <span>Kirim ke Email</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nomorWhatsapp = '{{ $kontakWhatsapp }}'; // format internasional tanpa "+" atau "0" di depan

    const namaInput  = document.getElementById('nama');
    const emailInput = document.getElementById('email');
    const pesanInput = document.getElementById('pesan');

    function validasiForm() {
        if (!namaInput.value.trim() || !emailInput.value.trim() || !pesanInput.value.trim()) {
            alert('Mohon lengkapi semua field terlebih dahulu.');
            return false;
        }
        return true;
    }

    document.getElementById('btnWhatsapp').addEventListener('click', function () {
        if (!validasiForm()) return;

        const teks = `Halo, saya ${namaInput.value}%0A` +
                     `Email: ${emailInput.value}%0A` +
                     `Pesan: ${pesanInput.value}`;

        const url = `https://wa.me/${nomorWhatsapp}?text=${teks}`;
        window.open(url, '_blank');
    });

    // Tombol "Kirim ke Email" sekarang type="submit" — otomatis submit form
    // asli ke server (route kontak.send), tidak perlu JavaScript tambahan lagi.
});
</script>

@endsection