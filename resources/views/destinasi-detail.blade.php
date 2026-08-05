@extends('layouts.app')

@section('title', $destinasi->nama . ' - Detail Destinasi')
@section('content')

<section class="destinasi-detail-section py-5">
    <div class="destinasi-detail-bg" style="--detail-bg-img: url('{{ asset('images/' . $destinasi->gambar) }}')"></div>

    <div class="container position-relative" style="z-index: 2;">

        <a href="{{ route('destinasi') }}" class="reset-link mb-4 d-inline-block">← Kembali ke destinasi</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="detail-wrap">
            <div class="detail-img-wrap">
                <img src="{{ asset('images/' . $destinasi->gambar) }}" alt="Foto {{ $destinasi->nama }}">

                <span class="badge-status {{ $destinasi->is_buka ? 'buka' : 'tutup' }}">
                    <span class="badge-dot"></span> {{ $destinasi->is_buka ? 'Sedang buka' : 'Sedang tutup' }}
                </span>

                <span class="badge-harga">Mulai Rp {{ number_format($destinasi->harga_termurah, 0, ',', '.') }}</span>
            </div>

            <div class="detail-info">
                <span class="destinasi-label">Detail destinasi</span>
                <h2>{{ $destinasi->nama }}</h2>
                <p class="detail-lokasi">{{ $destinasi->lokasi ?? '-' }}</p>
                <p class="detail-deskripsi">{{ $destinasi->deskripsi }}</p>

                <div class="detail-fasilitas">
                    <h4>Fasilitas tersedia</h4>
                    <div class="fasilitas-list">
                        <span class="fasilitas-item">Toilet</span>
                        <span class="fasilitas-item">Area parkir</span>
                        <span class="fasilitas-item">Warung makan</span>
                        <span class="fasilitas-item">Mushola</span>
                        <span class="fasilitas-item">Gazebo</span>
                        <span class="fasilitas-item">Pemandu lokal</span>
                    </div>
                </div>

                <p class="jam-info">
                    Jam operasional: {{ \Carbon\Carbon::parse($destinasi->jam_buka)->format('H:i') }}
                    – {{ \Carbon\Carbon::parse($destinasi->jam_tutup)->format('H:i') }} WIB
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
                        <div class="slot-bar-fill {{ str_replace('_', '-', $destinasi->ket_slot ?? 'tersedia') }}"
                             style="width: {{ $destinasi->persen_terisi }}%"></div>
                    </div>
                </div>

                <div class="detail-kuota-rincian mt-3">
                    <h4>Ketersediaan Tiket per Kategori</h4>
                    <table class="table-kuota">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Terisi</th>
                                <th>Sisa</th>
                                <th>Kuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="bi bi-person-fill"></i> Dewasa</td>
                                <td>Rp {{ number_format($destinasi->harga_dewasa, 0, ',', '.') }}</td>
                                <td>{{ $destinasi->terisi_dewasa }}</td>
                                <td>
                                    <span class="badge-sisa {{ $destinasi->sisa_dewasa <= 0 ? 'habis' : '' }}">
                                        {{ $destinasi->sisa_dewasa }}
                                    </span>
                                </td>
                                <td>{{ $destinasi->kuota_dewasa }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-emoji-smile-fill"></i> Anak-anak</td>
                                <td>Rp {{ number_format($destinasi->harga_anak, 0, ',', '.') }}</td>
                                <td>{{ $destinasi->terisi_anak }}</td>
                                <td>
                                    <span class="badge-sisa {{ $destinasi->sisa_anak <= 0 ? 'habis' : '' }}">
                                        {{ $destinasi->sisa_anak }}
                                    </span>
                                </td>
                                <td>{{ $destinasi->kuota_anak }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-globe-americas"></i> Wisatawan Asing</td>
                                <td>Rp {{ number_format($destinasi->harga_asing, 0, ',', '.') }}</td>
                                <td>{{ $destinasi->terisi_asing }}</td>
                                <td>
                                    <span class="badge-sisa {{ $destinasi->sisa_asing <= 0 ? 'habis' : '' }}">
                                        {{ $destinasi->sisa_asing }}
                                    </span>
                                </td>
                                <td>{{ $destinasi->kuota_asing }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if ($destinasi->ket_slot === 'habis')
                    <span class="btn-pesan disabled" aria-disabled="true">Tiket Habis</span>
                @else
                    <a href="{{ route('pesan-tiket') }}?d={{ $destinasi->id }}" class="btn-pesan">Pesan Tiket</a>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection