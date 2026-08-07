@extends('layouts.app')
@section('title', 'Admin - Verifikasi Pembayaran')
@section('content')

<section class="py-5" style="background:#0f1115; min-height:100vh;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h2 class="fw-bold text-white mb-1"><i class="bi bi-shield-check"></i> Verifikasi Pembayaran</h2>
                <p class="text-white-50 mb-0">Booking yang menunggu konfirmasi dana masuk dari pemesan.</p>
            </div>
            <span class="badge rounded-pill" style="background:#f1c40f;color:#1a1a1a;font-size:.95rem;padding:.5em 1em;">
                {{ $bookings->total() }} menunggu
            </span>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if ($bookings->isEmpty())
            <div class="text-center py-5" style="color:#8a8f98;">
                <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                <p class="mt-3 mb-0">Tidak ada klaim pembayaran yang menunggu verifikasi saat ini.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach ($bookings as $booking)
                    <div class="verif-card">
                        <div class="verif-card-main">
                            <div class="verif-card-info">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <strong class="verif-kode">{{ $booking->kode_booking }}</strong>
                                    <span class="verif-badge">{{ str_replace('_', ' ', $booking->metode_pembayaran) }}</span>
                                </div>
                                <div class="verif-sub">{{ $booking->nama_pemesan }} &middot; {{ $booking->wa_pemesan }}</div>
                                <div class="verif-sub">{{ $booking->destinasi->nama ?? '—' }} &middot; {{ $booking->tanggal_kunjungan->translatedFormat('d F Y') }}</div>
                                <div class="verif-sub">
                                    Klaim dikirim:
                                    {{ $booking->klaim_bayar_at ? $booking->klaim_bayar_at->translatedFormat('d F Y, H:i') . ' WIB' : '—' }}
                                </div>
                            </div>

                            <div class="verif-card-amount text-end">
                                <div class="verif-total-label">Total Transfer</div>
                                <div class="verif-total">Rp {{ number_format($booking->total_transfer, 0, ',', '.') }}</div>
                                <div class="verif-sub">kode unik {{ $booking->kode_unik }}</div>
                            </div>
                        </div>

                        @if ($booking->bukti_transfer_path)
                            <div class="mt-2">
                                <a href="{{ route('admin.verifikasi.bukti', $booking->kode_booking) }}"
                                   target="_blank" rel="noopener" class="verif-bukti-link">
                                    <i class="bi bi-image"></i> Lihat bukti transfer
                                </a>
                            </div>
                        @endif

                        <div class="verif-actions">
                            <form method="POST" action="{{ route('admin.verifikasi.approve', $booking->kode_booking) }}"
                                  onsubmit="return confirm('Konfirmasi: dana Rp {{ number_format($booking->total_transfer, 0, ',', '.') }} untuk {{ $booking->kode_booking }} sudah benar-benar diterima?');">
                                @csrf
                                <button type="submit" class="btn-verif btn-verif-approve">
                                    <i class="bi bi-check-lg"></i> Konfirmasi Lunas
                                </button>
                            </form>

                            <button type="button" class="btn-verif btn-verif-reject"
                                    data-bs-toggle="collapse" data-bs-target="#tolak-{{ $booking->id }}">
                                <i class="bi bi-x-lg"></i> Tolak
                            </button>
                        </div>

                        <div class="collapse mt-2" id="tolak-{{ $booking->id }}">
                            <form method="POST" action="{{ route('admin.verifikasi.reject', $booking->kode_booking) }}" class="d-flex gap-2 flex-wrap">
                                @csrf
                                <input type="text" name="alasan" required maxlength="500"
                                       class="form-control form-control-sm" style="max-width:340px;"
                                       placeholder="Alasan penolakan (wajib diisi)">
                                <button type="submit" class="btn-verif btn-verif-reject-confirm">Kirim Penolakan</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        @endif

    </div>
</section>

<style>
.verif-card {
    background: #171a21;
    border: 1px solid #262a33;
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
}
.verif-card-main {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.verif-kode {
    color: #fff;
    font-size: 1.05rem;
    letter-spacing: .5px;
}
.verif-badge {
    background: #262a33;
    color: #c9cdd6;
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: .2em .6em;
    border-radius: 999px;
}
.verif-sub {
    color: #8a8f98;
    font-size: .85rem;
}
.verif-total-label {
    color: #8a8f98;
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: .06em;
}
.verif-total {
    color: #f1c40f;
    font-size: 1.25rem;
    font-weight: 700;
}
.verif-bukti-link {
    color: #6cb2eb;
    font-size: .85rem;
    text-decoration: none;
}
.verif-bukti-link:hover { text-decoration: underline; }
.verif-actions {
    display: flex;
    gap: .6rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}
.btn-verif {
    border: none;
    border-radius: 8px;
    padding: .5em 1.1em;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
}
.btn-verif-approve { background: #2ecc71; color: #0f1115; }
.btn-verif-approve:hover { background: #27ae60; }
.btn-verif-reject { background: transparent; color: #e74c3c; border: 1px solid #e74c3c; }
.btn-verif-reject:hover { background: rgba(231,76,60,.1); }
.btn-verif-reject-confirm { background: #e74c3c; color: #fff; }
.btn-verif-reject-confirm:hover { background: #c0392b; }
</style>

@endsection