@extends('layouts.app')
@section('title', ' Wisata Tasikmalaya - Destinasi')
@section('content')

<section class="destinasi-section py-5">
    <div class="destinasi-bg"></div>

    <div class="container position-relative" style="z-index: 2;">

        <div class="text-center mb-5 destinasi-heading">
            <span class="destinasi-label">Jelajahi</span>
            <h2 class="fw-bold text-white mb-2">Destinasi Unggulan</h2>
            <p class="destinasi-subtitle mx-auto">
                Cari destinasi favoritmu, cek slot tiket yang masih tersedia, dan rencanakan kunjunganmu sekarang.
            </p>
        </div>

        <div class="kartu-container">

            @forelse ($destinasiList as $destinasi)

                @php
                    $slug = \Illuminate\Support\Str::slug($destinasi->nama);
                    $jamBuka  = \Carbon\Carbon::parse($destinasi->jam_buka);
                    $jamTutup = \Carbon\Carbon::parse($destinasi->jam_tutup);
                @endphp

                <div class="kartu">
                    <div class="kartu-img-wrap">
                        <img src="{{ asset('images/' . $destinasi->gambar) }}" alt="Foto {{ $destinasi->nama }}">

                        <span class="badge-status {{ $destinasi->is_buka ? 'buka' : 'tutup' }}">
                            <span class="badge-dot"></span> {{ $destinasi->is_buka ? 'Sedang buka' : 'Sedang tutup' }}
                        </span>

                        <span class="badge-harga">Mulai Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</span>
                    </div>

                    <h3>{{ $destinasi->nama }}</h3>
                    <p>{{ Str::limit($destinasi->deskripsi, 100) }}</p>
                    <p class="jam-info">
                        Jam operasional: {{ $jamBuka->format('H:i') }} – {{ $jamTutup->format('H:i') }} WIB
                    </p>

                   <div class="slot-info">
    <div class="slot-label">
        @if ($destinasi->ket_slot === 'habis')
            <span class="slot-text habis">Tiket habis</span>
        @elseif ($destinasi->ket_slot === 'hampir_habis')
            <span class="slot-text hampir-habis">Tersisa {{ $destinasi->sisa_slot }} slot lagi!</span>
        @else
            <span class="slot-text tersedia">{{ $destinasi->sisa_slot }} slot tersedia</span>
        @endif
        <span class="slot-persen">{{ $destinasi->persen_terisi }}% terisi</span>
    </div>
    <div class="slot-bar">
        <div class="slot-bar-fill {{ $destinasi->ket_slot === 'habis' ? 'habis' : ($destinasi->ket_slot === 'hampir_habis' ? 'hampir-habis' : 'tersedia') }}"
             style="width: {{ $destinasi->persen_terisi }}%"></div>
    </div>

    <div class="slot-kategori-rincian mt-2">
        <div class="slot-kategori-baris">
            <span><i class="bi bi-person-fill"></i> Dewasa</span>
            <span>{{ $destinasi->sisa_dewasa }} sisa / {{ $destinasi->kuota_dewasa }}</span>
        </div>
        <div class="slot-kategori-baris">
            <span><i class="bi bi-emoji-smile-fill"></i> Anak</span>
            <span>{{ $destinasi->sisa_anak }} sisa / {{ $destinasi->kuota_anak }}</span>
        </div>
        <div class="slot-kategori-baris">
            <span><i class="bi bi-globe-americas"></i> Asing</span>
            <span>{{ $destinasi->sisa_asing }} sisa / {{ $destinasi->kuota_asing }}</span>
        </div>
    </div>
</div>
                    <div class="kartu-aksi">
                        <a href="{{ route('destinasi.detail', $destinasi->id) }}" class="btn-detail">Lihat Detail</a>
                        @if ($destinasi->ket_slot === 'habis')
                            <span class="btn-pesan disabled" aria-disabled="true">Tiket Habis</span>
                        @else
                            <a href="{{ route('pesan-tiket') }}?d={{ $slug }}" class="btn-pesan">Pesan Tiket</a>
                        @endif
                    </div>
                </div>

            @empty
                <div class="text-center text-white py-5">
                    <p class="mb-0">Belum ada destinasi yang ditambahkan.</p>
                </div>
            @endforelse

        </div>

    </div>
</section>

@endsection