@extends('layouts.app')
@section('title', 'Wisata Tasikmalaya - Pembayaran')
@section('content')

<?php
    $daftar_bank = array(
        "bca" => "BCA Virtual Account", "bri" => "BRI Virtual Account",
        "mandiri" => "Mandiri Virtual Account", "bni" => "BNI Virtual Account", "seabank" => "SeaBank",
    );
    $rekening_seabank = array("nomor" => "901287295755", "nama" => "Firman Khoerul Ihsan");
    $daftar_ewallet_label = array("gopay" => "GoPay", "ovo" => "OVO", "dana" => "DANA", "shopeepay" => "ShopeePay");
    $gambar_qris_ewallet = "qris-nasional.jpg";
    $qris_statis_dasar = "00020101021126610014COM.GO-JEK.WWW01189360091437330363670210G7330363670303UMI51440014ID.CO.QRIS.WWW0215ID10254568922290303UMI5204581253033605802ID5912Firman ihsan6009PEKANBARU61052829162070703A0163040762";

    function hitungCrc16Qris($data) {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                $crc = (($crc & 0x8000) !== 0) ? (($crc << 1) ^ 0x1021) & 0xFFFF : ($crc << 1) & 0xFFFF;
            }
        }
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }

    function qrisStatisKeDinamis($qrisStatis, $nominal) {
        $qris = substr($qrisStatis, 0, -4);
        $qris = str_replace('010211', '010212', $qris);
        $nominalStr = (string) (int) $nominal;
        $tagJumlah  = '54' . str_pad((string) strlen($nominalStr), 2, '0', STR_PAD_LEFT) . $nominalStr;
        $bagian     = explode('5802ID', $qris);
        $qrisBaru   = $bagian[0] . $tagJumlah . '5802ID' . $bagian[1];
        return $qrisBaru . hitungCrc16Qris($qrisBaru);
    }

    define('KODE_TIKET_INTERVAL_DETIK', 20);

    function hitungHashFnv1a($str) {
        $hash = 0x811c9dc5;
        for ($i = 0; $i < strlen($str); $i++) {
            $hash ^= ord($str[$i]);
            $hash  = ($hash * 0x01000193) & 0xFFFFFFFF;
        }
        return $hash;
    }

    function buatKodeTiketRealtime($kodeBooking, $waktuUnix) {
        $window = intdiv($waktuUnix, KODE_TIKET_INTERVAL_DETIK);
        $hash   = hitungHashFnv1a($kodeBooking . '-' . $window);
        return substr(strtoupper(str_pad(base_convert((string) $hash, 10, 36), 6, '0', STR_PAD_LEFT)), -6);
    }

    $kodeTiket = buatKodeTiketRealtime($booking->kode_booking, time());
    $destinasi = $booking->destinasi;
?>

<section class="pesan-section py-5">
    <div class="pesan-bg"></div>

    <div class="container position-relative" style="z-index: 2;">

        <div class="struk-wrap">
            <div class="struk-header text-center">
              <?php if ($booking->status === 'lunas') { ?>
    <i class="bi bi-check-circle-fill struk-icon" style="color:#2ecc71;"></i>
    <h2>Pembayaran Diterima</h2>
    <p>Terima kasih! Pembayaranmu sudah diterima dan tiket sudah aktif.</p>
<?php } else if ($booking->status === 'dibatalkan') { ?>
    <i class="bi bi-x-circle-fill struk-icon" style="color:#e74c3c;"></i>
    <h2>Booking Dibatalkan</h2>
    <p>Booking ini otomatis dibatalkan karena melewati batas waktu pembayaran. Kuota tiket sudah dikembalikan.</p>
<?php } else { ?>
    <i class="bi bi-hourglass-split struk-icon"></i>
    <h2>Selesaikan Pembayaran</h2>
    <p>Pesanan dibuat. Selesaikan pembayaran agar tiket tidak hangus.</p>
<?php } ?>
                <div class="struk-kode"><?php echo $booking->kode_booking; ?></div>
            </div>

            <div class="struk-body">

                <?php if ($booking->status === 'lunas') { ?>

                    <div class="bayar-panel text-center" style="border-color:#2ecc71;">
                        <span class="bayar-label" style="color:#2ecc71;"><i class="bi bi-check-circle-fill"></i> Pembayaran Berhasil</span>
                        <p class="bayar-sub">Dikonfirmasi pada <strong><?php echo $booking->dibayar_at->translatedFormat('d F Y, H:i:s'); ?> WIB</strong>.</p>
                        <p class="bayar-jumlah">Total Dibayar: <strong>Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?></strong></p>
                    </div>

                <?php } else { ?>

                    <?php if ($booking->metode_pembayaran === 'qris') { ?>
                        <div class="bayar-panel bayar-qris text-center">
                            <span class="bayar-label"><i class="bi bi-qr-code"></i> Bayar dengan QRIS</span>
                            <p class="bayar-sub">Scan kode di bawah menggunakan aplikasi m-banking atau e-wallet apa pun.</p>
                            <div class="qris-img-wrap">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?php echo urlencode(qrisStatisKeDinamis($qris_statis_dasar, $booking->total_transfer)); ?>" width="220" height="220" alt="QRIS">
                            </div>
                            <p class="bayar-sub mb-0">a.n. <strong>Firman Ihsan</strong></p>
                            <p class="bayar-jumlah">Total Transfer (kode unik <?php echo $booking->kode_unik; ?>): <strong>Rp <?php echo number_format($booking->total_transfer, 0, ',', '.'); ?></strong></p>
                        </div>

                    <?php } else if ($booking->metode_pembayaran === 'transfer_bank' && $booking->bank_kode === 'seabank') { ?>
                        <div class="bayar-panel bayar-va text-center">
                            <span class="bayar-label"><i class="bi bi-bank"></i> Transfer ke SeaBank</span>
                            <p class="bayar-sub">Transfer ke rekening SeaBank di bawah, atau scan QR menggunakan aplikasi SeaBank.</p>
                            <div class="qris-img-wrap">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?php echo urlencode($rekening_seabank['nomor']); ?>" width="220" height="220" alt="QR SeaBank">
                            </div>
                            <div class="va-box">
                                <span id="vaNumber"><?php echo $rekening_seabank['nomor']; ?></span>
                                <button type="button" class="btn-salin" onclick="salinVA()"><i class="bi bi-clipboard"></i> Salin</button>
                            </div>
                            <p class="bayar-sub mb-0">a.n. <strong><?php echo $rekening_seabank['nama']; ?></strong></p>
                            <p class="bayar-jumlah">Total Transfer (kode unik <?php echo $booking->kode_unik; ?>): <strong>Rp <?php echo number_format($booking->total_transfer, 0, ',', '.'); ?></strong></p>
                        </div>

                    <?php } else if ($booking->metode_pembayaran === 'transfer_bank') { ?>
                        <div class="bayar-panel bayar-va">
                            <span class="bayar-label"><i class="bi bi-bank"></i> Transfer ke <?php echo $daftar_bank[$booking->bank_kode]; ?></span>
                            <p class="bayar-sub">Salin nomor Virtual Account di bawah, lalu bayar melalui m-banking / ATM.</p>
                            <div class="va-box">
                                <span id="vaNumber"><?php echo strtoupper($booking->bank_kode) . ' ' . str_pad((string) hexdec(substr(md5($booking->kode_booking), 0, 8)), 10, '0', STR_PAD_LEFT); ?></span>
                                <button type="button" class="btn-salin" onclick="salinVA()"><i class="bi bi-clipboard"></i> Salin</button>
                            </div>
                            <p class="bayar-jumlah">Total Transfer (kode unik <?php echo $booking->kode_unik; ?>): <strong>Rp <?php echo number_format($booking->total_transfer, 0, ',', '.'); ?></strong></p>
                        </div>

                    <?php } else if ($booking->metode_pembayaran === 'ewallet') { ?>
                        <div class="bayar-panel bayar-ewallet text-center">
                            <span class="bayar-label"><i class="bi bi-wallet2"></i> Bayar dengan <?php echo $daftar_ewallet_label[$booking->ewallet_kode]; ?></span>
                            <p class="bayar-sub">Scan kode QRIS nasional di bawah dari aplikasi <?php echo $daftar_ewallet_label[$booking->ewallet_kode]; ?>.</p>
                            <div class="qris-img-wrap">
                                <img src="<?php echo asset('images/' . $gambar_qris_ewallet); ?>" width="220" height="220" alt="QRIS Ewallet">
                            </div>
                            <p class="bayar-sub mb-0">a.n. <strong>Firman Ihsan</strong></p>
                            <div class="va-box mt-2">
                                <span id="ewalletNumber">081261604202</span>
                                <button type="button" class="btn-salin" onclick="salinEwallet()"><i class="bi bi-clipboard"></i> Salin</button>
                            </div>
                            <p class="bayar-jumlah mt-3">Total Transfer (kode unik <?php echo $booking->kode_unik; ?>): <strong>Rp <?php echo number_format($booking->total_transfer, 0, ',', '.'); ?></strong></p>
                        </div>
                    <?php } ?>

                    <div class="text-center mt-3">
                        <div style="display:inline-block;padding:10px 18px;border:1px dashed currentColor;border-radius:10px;">
                            <div style="font-size:.8rem;opacity:.8;"><i class="bi bi-arrow-repeat"></i> Kode Tiket (real-time)</div>
                            <div id="kodeTiket" style="font-size:1.4rem;font-weight:700;letter-spacing:2px;"><?php echo $kodeTiket; ?></div>
                            <div style="font-size:.72rem;opacity:.7;">Kode ini otomatis berganti setiap <?php echo KODE_TIKET_INTERVAL_DETIK; ?> detik.</div>
                        </div>
                    </div>

                <?php } ?>

                <hr class="struk-divider">

                <div class="struk-baris"><span>Nama Pemesan</span><strong><?php echo htmlspecialchars($booking->nama_pemesan); ?></strong></div>
                <div class="struk-baris"><span>Email</span><strong><?php echo htmlspecialchars($booking->email_pemesan); ?></strong></div>
                <div class="struk-baris"><span>No. WhatsApp</span><strong><?php echo htmlspecialchars($booking->wa_pemesan); ?></strong></div>
                <div class="struk-baris"><span>Destinasi</span><strong><?php echo $destinasi->nama; ?></strong></div>
                <div class="struk-baris"><span>Tanggal Kunjungan</span><strong><?php echo $booking->tanggal_kunjungan->translatedFormat('d F Y'); ?></strong></div>

                <hr class="struk-divider">

                <?php if ($booking->jumlah_dewasa > 0) { ?>
                    <div class="struk-baris"><span>Dewasa × <?php echo $booking->jumlah_dewasa; ?></span><strong>Rp <?php echo number_format($booking->subtotal_dewasa, 0, ',', '.'); ?></strong></div>
                <?php } ?>
                <?php if ($booking->jumlah_anak > 0) { ?>
                    <div class="struk-baris"><span>Anak-anak × <?php echo $booking->jumlah_anak; ?></span><strong>Rp <?php echo number_format($booking->subtotal_anak, 0, ',', '.'); ?></strong></div>
                <?php } ?>
                <?php if ($booking->jumlah_asing > 0) { ?>
                    <div class="struk-baris"><span>Wisatawan Asing × <?php echo $booking->jumlah_asing; ?></span><strong>Rp <?php echo number_format($booking->subtotal_asing, 0, ',', '.'); ?></strong></div>
                <?php } ?>

                <hr class="struk-divider">

                <div class="struk-baris struk-total">
                    <span>Total Bayar (<?php echo $booking->total_tiket; ?> tiket)</span>
                    <strong>Rp <?php echo number_format($booking->total_harga, 0, ',', '.'); ?></strong>
                </div>
            </div>

            <div class="struk-footer text-center d-flex flex-wrap gap-2 justify-content-center">
                <?php if ($booking->status === 'lunas') { ?>
    <a href="{{ route('destinasi') }}" class="btn-lihat-semua"><i class="bi bi-arrow-left"></i> Kembali ke Destinasi</a>
<?php } else if ($booking->status === 'dibatalkan') { ?>
    <a href="{{ route('destinasi.detail', $destinasi->id) }}" class="btn-lihat-semua"><i class="bi bi-arrow-repeat"></i> Pesan Ulang</a>
<?php } else { ?>
    <form method="POST" action="{{ route('pembayaran.konfirmasi', $booking->kode_booking) }}">
        @csrf
        <button type="submit" class="btn-lihat-semua btn-wa-konfirmasi"><i class="bi bi-check-circle"></i> Saya Sudah Bayar</button>
    </form>
<?php } ?>
                <a href="https://wa.me/6281261604202?text=<?php echo urlencode('Halo, saya sudah pesan tiket dengan kode ' . $booking->kode_booking . ' untuk ' . $destinasi->nama . '. Mohon dibantu verifikasi pembayarannya.'); ?>"
                   target="_blank" rel="noopener" class="btn-lihat-semua btn-outline-tasik">
                    <i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp
                </a>
            </div>
        </div>

    </div>
</section>

<script>
function salinVA() {
    const el = document.getElementById('vaNumber');
    if (!el) return;
    navigator.clipboard.writeText(el.textContent.replace(/\s+/g, '')).then(() => alert('Nomor rekening berhasil disalin!'));
}
function salinEwallet() {
    const el = document.getElementById('ewalletNumber');
    if (!el) return;
    navigator.clipboard.writeText(el.textContent.replace(/\s+/g, '')).then(() => alert('Nomor e-wallet berhasil disalin!'));
}
</script>

<script>
(function () {
    const kodeEl = document.getElementById('kodeTiket');
    if (!kodeEl) return;

    const KODE_BOOKING   = <?php echo json_encode($booking->kode_booking); ?>;
    const INTERVAL_DETIK = <?php echo KODE_TIKET_INTERVAL_DETIK; ?>;

    function hashFnv1a(str) {
        let hash = 0x811c9dc5;
        for (let i = 0; i < str.length; i++) {
            hash ^= str.charCodeAt(i);
            hash = Math.imul(hash, 0x01000193);
        }
        return hash >>> 0;
    }

    function keBase36Pad6(angka) {
        let s = angka.toString(36).toUpperCase();
        while (s.length < 6) s = '0' + s;
        return s.slice(-6);
    }

    function buatKodeTiketSaatIni() {
        const window = Math.floor(Math.floor(Date.now() / 1000) / INTERVAL_DETIK);
        return keBase36Pad6(hashFnv1a(KODE_BOOKING + '-' + window));
    }

    let kodeTerakhir = null;
    function perbarui() {
        const kodeBaru = buatKodeTiketSaatIni();
        if (kodeBaru === kodeTerakhir) return;
        kodeTerakhir = kodeBaru;
        kodeEl.style.opacity = '0';
        setTimeout(() => { kodeEl.textContent = kodeBaru; kodeEl.style.opacity = '1'; }, 200);
    }

    perbarui();
    setInterval(perbarui, 1000);
})();
</script>

@endsection