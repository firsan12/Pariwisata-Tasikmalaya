{{--
    Partial kartu destinasi — dipakai di beranda.blade.php & destinasi.blade.php.
    Variabel yang diterima:
    - $destinasi   : instance Model Destinasi (wajib)
    - $ringkas     : bool, default false. Kalau true, sembunyikan rincian kuota
                      per kategori (dipakai di beranda supaya kartu tidak terlalu panjang).
--}}
@php
    $ringkas = $ringkas ?? false;
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
    <p>{{ Str::limit($destinasi->deskripsi, $ringkas ? 140 : 100) }}</p>
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
            <div class="slot-bar-fill {{ $destinasi->ket_slot === 'habis' ? 'habis' : ($destinasi->ket_slot === 'hampir_habis' ? 'hampir-habis' : 'tersedia') }}"
                 style="width: {{ $destinasi->persen_terisi }}%"></div>
        </div>
        @unless ($ringkas)
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
        @endunless
    </div>
    <div class="kartu-aksi">
        <a href="{{ route('destinasi.detail', $destinasi->id) }}" class="btn-detail">Lihat Detail</a>
        @if ($destinasi->ket_slot === 'habis')
            <span class="btn-pesan disabled" aria-disabled="true">Tiket Habis</span>
        @else
            <a href="{{ route('pesan-tiket') }}?d={{ $destinasi->id }}" class="btn-pesan">Pesan Tiket</a>
        @endif
    </div>
</div>