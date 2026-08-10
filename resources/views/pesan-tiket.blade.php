@extends('layouts.site')
@section('title', 'Wisata Tasikmalaya - Pesan Tiket')
@section('content')

<?php
    $destinasiId    = request()->query('d');
    $destinasiAktif = $destinasiId ? \App\Models\Destinasi::find($destinasiId) : null;

    $daftar_bank = array(
        "bca"     => "BCA Virtual Account",
        "bri"     => "BRI Virtual Account",
        "mandiri" => "Mandiri Virtual Account",
        "bni"     => "BNI Virtual Account",
        "seabank" => "SeaBank",
    );

    $rekening_seabank = array("nomor" => "901287295755", "nama" => "Firman Khoerul Ihsan");
    $nomor_ewallet_tujuan = "081261604202";

    $daftar_ewallet = array(
        "gopay"     => "GoPay",
        "ovo"       => "OVO",
        "dana"      => "DANA",
        "shopeepay" => "ShopeePay",
    );

    $old = old();
?>

<section class="pesan-section py-5">
    <div class="pesan-bg"></div>

    <div class="container position-relative" style="z-index: 2;">

        <?php if ($destinasiAktif === null) { ?>

            <div class="pesan-kosong text-center">
                <i class="bi bi-ticket-perforated pesan-kosong-icon"></i>
                <h2 class="text-white mb-3">Destinasi Tidak Ditemukan</h2>
                <p class="pesan-kosong-text mb-4">Silakan pilih destinasi terlebih dahulu dari halaman Destinasi.</p>
                <a href="{{ route('destinasi') }}" class="btn-lihat-semua">Kembali ke Destinasi</a>
            </div>

        <?php } else { ?>

            <div class="text-center mb-5 pesan-heading">
                <span class="destinasi-label">Pesan Tiket</span>
                <h2 class="fw-bold text-white mb-2"><?php echo $destinasiAktif->nama; ?></h2>
                <p class="destinasi-subtitle mx-auto">
                    Lengkapi data, pilih metode pembayaran, dan total bayar akan terhitung otomatis.
                </p>
            </div>

            @if ($errors->any())
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9">
                        <div class="pesan-error mb-4">
                            <strong><i class="bi bi-exclamation-triangle-fill"></i> Mohon periksa kembali:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('pesan-tiket.store') }}" id="formPesan">
                @csrf
                <input type="hidden" name="destinasi_id" value="{{ $destinasiAktif->id }}">

                <div class="row justify-content-center g-4">

                    <div class="col-12 col-lg-7">
                        <div class="pesan-card mb-4">
                            <h6 class="pesan-subjudul"><i class="bi bi-person-lines-fill"></i> Data Pemesan</h6>

                            <div class="row g-3">
                                <div class="col-12 col-md-6 form-floating">
                                    <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" placeholder="Nama"
                                           value="{{ old('nama_pemesan') }}">
                                    <label for="nama_pemesan">Nama Pemesan</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating">
                                    <input type="email" class="form-control" id="email_pemesan" name="email_pemesan" placeholder="Email"
                                           value="{{ old('email_pemesan') }}">
                                    <label for="email_pemesan">Email</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating">
                                    <input type="text" class="form-control" id="wa_pemesan" name="wa_pemesan" placeholder="WhatsApp"
                                           value="{{ old('wa_pemesan') }}">
                                    <label for="wa_pemesan">Nomor WhatsApp</label>
                                </div>
                                <div class="col-12 col-md-6 form-floating">
                                    <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan"
                                           min="{{ date('Y-m-d') }}"
                                           value="{{ old('tanggal_kunjungan') }}">
                                    <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
                                </div>
                            </div>
                        </div>

                        <div class="pesan-card mb-4">
                            <h6 class="pesan-subjudul"><i class="bi bi-ticket-perforated-fill"></i> Jumlah Tiket</h6>
                            <p class="tiket-sisa-info">Sisa slot tersedia: <strong><?php echo $destinasiAktif->sisa_slot; ?></strong> tiket</p>

                            <?php
                                $kategori_tiket = array(
                                    array("key" => "dewasa", "label" => "Dewasa", "ikon" => "bi-person-fill", "sisa" => $destinasiAktif->sisa_dewasa, "harga" => $destinasiAktif->harga_dewasa),
                                    array("key" => "anak", "label" => "Anak-anak", "ikon" => "bi-emoji-smile-fill", "sisa" => $destinasiAktif->sisa_anak, "harga" => $destinasiAktif->harga_anak),
                                    array("key" => "asing", "label" => "Wisatawan Asing", "ikon" => "bi-globe-americas", "sisa" => $destinasiAktif->sisa_asing, "harga" => $destinasiAktif->harga_asing),
                                );
                            ?>

                            <?php foreach ($kategori_tiket as $kt) { ?>
                                <div class="tiket-kategori">
                                    <div class="tiket-kategori-info">
                                        <span>
                                            <i class="bi <?php echo $kt['ikon']; ?>"></i> <?php echo $kt['label']; ?>
                                            <?php if ($kt['sisa'] <= 0) { ?>
                                                <span class="badge-sisa habis ms-1">Habis</span>
                                            <?php } else { ?>
                                                <small>(sisa <?php echo $kt['sisa']; ?>)</small>
                                            <?php } ?>
                                        </span>
                                        <small>Rp <?php echo number_format($kt['harga'], 0, ',', '.'); ?> / orang</small>
                                    </div>

                                    <div class="tiket-stepper" data-harga="<?php echo $kt['harga']; ?>" data-sisa="<?php echo $kt['sisa']; ?>">
                                        <button type="button" class="tiket-stepper-btn tiket-kurang" aria-label="Kurangi">−</button>
                                        <input type="number" min="0" max="<?php echo $kt['sisa']; ?>"
                                               name="jumlah_<?php echo $kt['key']; ?>"
                                               class="tiket-input tiket-jumlah"
                                               value="{{ old('jumlah_' . $kt['key'], 0) }}"
                                               readonly>
                                        <button type="button" class="tiket-stepper-btn tiket-tambah" aria-label="Tambah">+</button>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="pesan-card">
                            <h6 class="pesan-subjudul"><i class="bi bi-credit-card-2-front-fill"></i> Metode Pembayaran</h6>

                            <?php $metode_terpilih = old('metode_pembayaran', 'qris'); ?>

                            <div class="metode-bayar-grid">
                                <label class="metode-bayar-opsi">
                                    <input type="radio" name="metode_pembayaran" value="qris" <?php echo ($metode_terpilih === 'qris') ? 'checked' : ''; ?>>
                                    <span class="metode-bayar-card"><i class="bi bi-qr-code"></i><span>QRIS</span></span>
                                </label>
                                <label class="metode-bayar-opsi">
                                    <input type="radio" name="metode_pembayaran" value="transfer_bank" <?php echo ($metode_terpilih === 'transfer_bank') ? 'checked' : ''; ?>>
                                    <span class="metode-bayar-card"><i class="bi bi-bank"></i><span>Transfer Bank</span></span>
                                </label>
                                <label class="metode-bayar-opsi">
                                    <input type="radio" name="metode_pembayaran" value="ewallet" <?php echo ($metode_terpilih === 'ewallet') ? 'checked' : ''; ?>>
                                    <span class="metode-bayar-card"><i class="bi bi-wallet2"></i><span>E-Wallet</span></span>
                                </label>
                            </div>

                            <div id="subBank" class="metode-sub">
                                <label for="bank_dipilih" class="metode-sub-label">Pilih Bank Tujuan</label>
                                <select name="bank_kode" id="bank_dipilih" class="form-select">
                                    <?php foreach ($daftar_bank as $kode => $label) { ?>
                                        <option value="<?php echo $kode; ?>" <?php echo (old('bank_kode') === $kode) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div id="subEwallet" class="metode-sub">
                                <label for="ewallet_dipilih" class="metode-sub-label">Pilih E-Wallet</label>
                                <select name="ewallet_kode" id="ewallet_dipilih" class="form-select">
                                    <?php foreach ($daftar_ewallet as $kode => $label) { ?>
                                        <option value="<?php echo $kode; ?>" <?php echo (old('ewallet_kode') === $kode) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php } ?>
                                </select>
                                <p class="metode-sub-label mt-2 mb-0">
                                    <i class="bi bi-info-circle"></i> Pembayaran e-wallet dikirim ke nomor <?php echo $nomor_ewallet_tujuan; ?>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="ringkasan-card">
                            <div class="ringkasan-img-wrap">
                                <img src="<?php echo asset('images/' . $destinasiAktif->gambar); ?>" alt="<?php echo $destinasiAktif->nama; ?>">
                            </div>

                            <h5 class="ringkasan-judul"><?php echo $destinasiAktif->nama; ?></h5>
                            <p class="ringkasan-jam">
                                <i class="bi bi-clock"></i>
                                <?php echo \Carbon\Carbon::parse($destinasiAktif->jam_buka)->format('H:i'); ?> –
                                <?php echo \Carbon\Carbon::parse($destinasiAktif->jam_tutup)->format('H:i'); ?> WIB
                            </p>

                            <hr class="struk-divider">

                            <div id="ringkasanRincian" class="ringkasan-rincian">
                                <p class="ringkasan-kosong">Belum ada tiket dipilih.</p>
                            </div>

                            <hr class="struk-divider">

                            <div class="ringkasan-total">
                                <span>Total Bayar</span>
                                <strong id="ringkasanTotal">Rp 0</strong>
                            </div>

                            <button type="submit" class="btn-pesan w-100 mt-3" id="btnKonfirmasi" disabled>
                                <i class="bi bi-lock-fill"></i> Lanjut ke Pembayaran
                            </button>
                            <p class="ringkasan-catatan">Pilih minimal 1 tiket untuk melanjutkan.</p>
                        </div>
                    </div>

                </div>
            </form>

        <?php } ?>

    </div>
</section>

@if ($destinasiAktif !== null)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const steppers   = document.querySelectorAll('.tiket-stepper');
    const ringkasan  = document.getElementById('ringkasanRincian');
    const totalEl    = document.getElementById('ringkasanTotal');
    const btnKonfirm = document.getElementById('btnKonfirmasi');

    const labelMap = { dewasa: 'Dewasa', anak: 'Anak-anak', asing: 'Wisatawan Asing' };

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function hitungTotal() {
        let totalTiket = 0, totalBayar = 0, rincianHTML = '', overQuota = false;

        steppers.forEach(function (stepper) {
            const input  = stepper.querySelector('.tiket-jumlah');
            const jumlah = parseInt(input.value, 10) || 0;
            const harga  = parseInt(stepper.dataset.harga, 10) || 0;
            const sisa   = parseInt(stepper.dataset.sisa, 10) || 0;
            const key    = input.name.replace('jumlah_', '');

            if (jumlah > sisa) overQuota = true;

            totalTiket += jumlah;
            totalBayar += jumlah * harga;

            if (jumlah > 0) {
                rincianHTML += `<div class="ringkasan-baris"><span>${labelMap[key]} × ${jumlah}</span><span>${formatRupiah(jumlah * harga)}</span></div>`;
            }
        });

        ringkasan.innerHTML = rincianHTML !== '' ? rincianHTML : '<p class="ringkasan-kosong">Belum ada tiket dipilih.</p>';
        totalEl.textContent = formatRupiah(totalBayar);
        btnKonfirm.disabled = (totalTiket <= 0 || overQuota);
    }

    steppers.forEach(function (stepper) {
        const input  = stepper.querySelector('.tiket-jumlah');
        const kurang = stepper.querySelector('.tiket-kurang');
        const tambah = stepper.querySelector('.tiket-tambah');
        const max    = parseInt(input.getAttribute('max'), 10) || 0;

        kurang.addEventListener('click', function () {
            let nilai = parseInt(input.value, 10) || 0;
            if (nilai > 0) { input.value = nilai - 1; hitungTotal(); }
        });

        tambah.addEventListener('click', function () {
            let nilai = parseInt(input.value, 10) || 0;
            if (nilai < max) { input.value = nilai + 1; hitungTotal(); }
        });
    });

    hitungTotal();

    const radioMetode = document.querySelectorAll('input[name="metode_pembayaran"]');
    const subBank     = document.getElementById('subBank');
    const subEwallet  = document.getElementById('subEwallet');

    function toggleMetode() {
        const dipilih = document.querySelector('input[name="metode_pembayaran"]:checked').value;
        subBank.classList.toggle('metode-sub-aktif', dipilih === 'transfer_bank');
        subEwallet.classList.toggle('metode-sub-aktif', dipilih === 'ewallet');

        document.querySelectorAll('.metode-bayar-opsi').forEach(function (opsi) {
            opsi.classList.toggle('metode-bayar-opsi-aktif', opsi.querySelector('input').checked);
        });
    }

    radioMetode.forEach(r => r.addEventListener('change', toggleMetode));
    toggleMetode();
});
</script>
@endif

@endsection