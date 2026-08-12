@extends('layouts.site')
@section('title', 'Wisata Tasikmalaya - Tiket Saya')
@section('content')

<?php
    $labelStatus = [
        'pending'             => ['Menunggu Pembayaran', '#f1c40f'],
        'menunggu_verifikasi' => ['Menunggu Verifikasi', '#f1c40f'],
        'lunas'               => ['Lunas', '#2ecc71'],
        'dibatalkan'          => ['Dibatalkan', '#e74c3c'],
    ];
?>

<section class="pesan-section py-5">
    <div class="pesan-bg"></div>

    <div class="container position-relative" style="z-index: 2;">

        <h2 class="text-center mb-4" style="color:#fff;">Tiket Saya</h2>

        <?php if ($bookings->isEmpty()) { ?>

            <div class="struk-wrap text-center py-5">
                <p class="mb-3">Kamu belum punya tiket. Yuk pesan tiket destinasi favoritmu.</p>
                <a href="{{ route('destinasi') }}" class="btn-lihat-semua">
                    <i class="bi bi-search"></i> Jelajahi Destinasi
                </a>
            </div>

        <?php } else { ?>

            <div class="d-flex flex-column gap-3">
                <?php foreach ($bookings as $booking) {
                    [$label, $warna] = $labelStatus[$booking->status] ?? ['-', '#999'];
                ?>
                    <a href="{{ route('pembayaran.show', $booking->kode_booking) }}"
                       class="struk-wrap d-block text-decoration-none" style="color:inherit;">
                        <div class="struk-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <div class="struk-kode mb-1"><?php echo $booking->kode_booking; ?></div>
                                <div><strong><?php echo optional($booking->destinasi)->nama ?? 'Destinasi tidak ditemukan'; ?></strong></div>
                                <div style="opacity:.8;font-size:.9rem;">
                                    Kunjungan: <?php echo $booking->tanggal_kunjungan?->translatedFormat('d F Y'); ?>
                                </div>
                            </div>
                            <div class="text-end">
                                <span style="display:inline-block;padding:4px 12px;border-radius:20px;border:1px solid <?php echo $warna; ?>;color:<?php echo $warna; ?>;font-size:.85rem;">
                                    <?php echo $label; ?>
                                </span>
                                <div style="font-size:.9rem;margin-top:6px;">
                                    Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>

        <?php } ?>

    </div>
</section>

@endsection