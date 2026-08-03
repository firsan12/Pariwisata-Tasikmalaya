@extends('layouts.app')
@section('title', 'Wisata Tasikmalaya - Kontak')
@section('content')

<section class="kontak-section py-5">
    <div class="kontak-bg"></div>

    <div class="container kontak-content position-relative" style="z-index: 2;">

        {{-- Bagian 1: Judul & Pengantar --}}
        <div class="text-center mb-5">
            <span class="kontak-label">Hubungi Kami</span>
            <h2 class="text-white">Ada Pertanyaan atau Saran?</h2>
            <p class="kontak-intro mx-auto">
                Kirimkan pesan Anda kepada kami, atau hubungi langsung lewat kontak di bawah ini.
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
                            <p><a href="mailto:firmanihsan13@gmail.com">firmanihsan13@gmail.com</a></p>
                        </div>
                    </div>

                    <div class="kontak-item">
                        <span class="kontak-icon"><i class="bi bi-whatsapp"></i></span>
                        <div>
                            <h6>WhatsApp</h6>
                            <p><a href="https://wa.me/6281261604202" target="_blank" rel="noopener">0812-6160-4202</a></p>
                        </div>
                    </div>

                    <div class="kontak-item">
                        <span class="kontak-icon"><i class="bi bi-geo-alt-fill"></i></span>
                        <div>
                            <h6>Alamat</h6>
                            <p>
                                <a href="https://www.google.com/maps/search/?api=1&query=Dinas+Pariwisata+Kota+Tasikmalaya+Jawa+Barat" target="_blank" rel="noopener">
                                    Dinas Pariwisata, Kota Tasikmalaya, Jawa Barat
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="kontak-item mb-0">
                        <span class="kontak-icon"><i class="bi bi-clock-fill"></i></span>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p>Senin – Jumat, 08.00 – 16.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian 3: Form (kanan) --}}
            <div class="col-12 col-lg-7">
                <div class="kontak-card">
                    <form id="formKontak">
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

                            <button type="button" id="btnEmail" class="btn btn-kirim-outline w-100">
                                <i class="bi bi-envelope-fill"></i> <span>Kirim via Email</span>
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
    const nomorWhatsapp = '6281261604202'; // format internasional tanpa "+" atau "0" di depan
    const emailTujuan   = 'firmanihsan13@gmail.com';

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

    document.getElementById('btnEmail').addEventListener('click', function () {
        if (!validasiForm()) return;

        const subjek = encodeURIComponent(`Pesan dari ${namaInput.value} - Wisata Tasikmalaya`);
        const body = encodeURIComponent(
            `Nama: ${namaInput.value}\nEmail: ${emailInput.value}\n\nPesan:\n${pesanInput.value}`
        );

        const url = `mailto:${emailTujuan}?subject=${subjek}&body=${body}`;
        window.location.href = url;
    });
});
</script>

@endsection