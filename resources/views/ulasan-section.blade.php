{{--
    Partial ulasan — dipakai di destinasi-detail.blade.php.
    Background gradient biru + bentuk dekoratif, mengikuti gaya halaman Daftar User.
--}}

<section id="ulasan" class="ulasan-section-wrapper mt-5">
    <div class="ulasan-bg-shape ulasan-shape-1"></div>
    <div class="ulasan-bg-shape ulasan-shape-2"></div>
    <div class="ulasan-bg-shape ulasan-shape-3"></div>

    <div class="ulasan-card">
        <h3 class="mb-4">Ulasan Pengunjung</h3>

        <div id="ulasan-alert-container"></div>

        {{-- Daftar ulasan --}}
        <div id="ulasan-list">
            @forelse ($destinasi->ulasan as $index => $ulasan)
                <div class="ulasan-item mb-3 p-3 border rounded ulasan-fade-in" style="animation-delay: {{ $index * 0.08 }}s">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $ulasan->nama_pengguna }}</strong>
                        <span class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $ulasan->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </span>
                    </div>
                    <p class="mb-1 mt-2">{{ $ulasan->komentar }}</p>
                    <small class="text-muted">{{ $ulasan->created_at->translatedFormat('d F Y') }}</small>

                    @if ($ulasan->balasan_admin)
                        <div class="balasan-admin mt-2 p-2 bg-light rounded">
                            <strong>Balasan Pengelola:</strong>
                            <p class="mb-0">{{ $ulasan->balasan_admin }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-muted" id="ulasan-empty-text">Belum ada ulasan untuk destinasi ini. Jadilah yang pertama!</p>
            @endforelse
        </div>

        {{-- Form tambah ulasan --}}
        <div class="ulasan-form mt-4 p-4 border rounded">
            <h5 class="mb-3">Tulis Ulasan Kamu</h5>

            <form id="ulasan-form" data-action="{{ route('ulasan.store', $destinasi->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama_pengguna" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (opsional)</label>
                    <input type="email" name="email_pengguna" class="form-control" maxlength="150">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="star-rating" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star star-pick" data-value="{{ $i }}"></i>
                        @endfor
                        <input type="hidden" name="rating" id="rating-input" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Komentar</label>
                    <textarea name="komentar" class="form-control" rows="4" required minlength="10" maxlength="1000"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" id="ulasan-submit-btn">
                    <span class="btn-text">Kirim Ulasan</span>
                    <span class="btn-spinner d-none">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Mengirim...
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>

<style>
    /* ===== Wrapper background gradient biru (gaya "Daftar User") ===== */
    .ulasan-section-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 40px 20px;
        background: linear-gradient(160deg, #0b3d66 0%, #1c6ea4 45%, #4a9fd8 100%);
    }

    /* Bentuk lingkaran dekoratif blur, meniru referensi */
    .ulasan-bg-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }
    .ulasan-shape-1 {
        width: 260px; height: 260px;
        bottom: -80px; left: -60px;
        background: rgba(255, 255, 255, 0.10);
    }
    .ulasan-shape-2 {
        width: 160px; height: 160px;
        bottom: -40px; left: 120px;
        background: rgba(255, 255, 255, 0.06);
    }
    .ulasan-shape-3 {
        width: 200px; height: 200px;
        top: -70px; right: -50px;
        background: rgba(255, 255, 255, 0.08);
    }

    /* ===== Card putih rounded di atas background ===== */
    .ulasan-card {
        position: relative;
        z-index: 1;
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    /* --- Animasi fade-in untuk item ulasan --- */
    .ulasan-fade-in {
        opacity: 0;
        transform: translateY(12px);
        animation: ulasanFadeIn 0.5s ease forwards;
    }
    @keyframes ulasanFadeIn {
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- Star rating interaktif --- */
    .star-rating { font-size: 1.6rem; cursor: pointer; display: inline-flex; gap: 4px; }
    .star-pick {
        color: #d0d0d0;
        transition: transform 0.15s ease, color 0.15s ease;
    }
    .star-pick:hover,
    .star-pick.hovered {
        transform: scale(1.15);
    }
    .star-pick.active { color: #ffc107; }

    /* --- Alert masuk/keluar --- */
    .ulasan-alert {
        opacity: 0;
        transform: translateY(-8px);
        animation: ulasanAlertIn 0.35s ease forwards;
    }
    @keyframes ulasanAlertIn {
        to { opacity: 1; transform: translateY(0); }
    }

    /* --- Tombol submit --- */
    #ulasan-submit-btn { transition: opacity 0.2s ease; }
    #ulasan-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }

    /* --- Form shake kalau invalid --- */
    .ulasan-form.shake { animation: ulasanShake 0.4s ease; }
    @keyframes ulasanShake {
        25% { transform: translateX(-6px); }
        75% { transform: translateX(6px); }
    }

    @media (max-width: 576px) {
        .ulasan-card { padding: 20px; }
        .ulasan-section-wrapper { padding: 24px 12px; }
    }
</style>

<script>
(function () {
    const starRating = document.getElementById('star-rating');
    const ratingInput = document.getElementById('rating-input');
    const stars = starRating.querySelectorAll('.star-pick');

    function paintStars(value) {
        stars.forEach(star => {
            const v = parseInt(star.dataset.value, 10);
            star.classList.toggle('active', v <= value);
            star.classList.toggle('bi-star-fill', v <= value);
            star.classList.toggle('bi-star', v > value);
        });
    }

    stars.forEach(star => {
        star.addEventListener('mouseenter', () => paintStars(parseInt(star.dataset.value, 10)));
        star.addEventListener('click', () => {
            ratingInput.value = star.dataset.value;
            paintStars(parseInt(star.dataset.value, 10));
        });
    });

    starRating.addEventListener('mouseleave', () => {
        paintStars(parseInt(ratingInput.value || 0, 10));
    });

    const form = document.getElementById('ulasan-form');
    const submitBtn = document.getElementById('ulasan-submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnSpinner = submitBtn.querySelector('.btn-spinner');
    const alertContainer = document.getElementById('ulasan-alert-container');

    function showAlert(type, message) {
        alertContainer.innerHTML = `
            <div class="alert alert-${type} ulasan-alert mb-4">
                ${message}
            </div>
        `;
        setTimeout(() => {
            const el = alertContainer.querySelector('.ulasan-alert');
            if (el) {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(() => alertContainer.innerHTML = '', 400);
            }
        }, 5000);
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (!ratingInput.value) {
            form.closest('.ulasan-form').classList.add('shake');
            setTimeout(() => form.closest('.ulasan-form').classList.remove('shake'), 400);
            showAlert('danger', 'Silakan pilih rating bintang terlebih dahulu.');
            return;
        }

        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');

        const formData = new FormData(form);

        try {
            const response = await fetch(form.dataset.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Terjadi kesalahan, coba lagi.');
                showAlert('danger', firstError);
                return;
            }

            showAlert('success', data.message || 'Terima kasih! Ulasan kamu akan tampil setelah disetujui pengelola.');
            form.reset();
            ratingInput.value = '';
            paintStars(0);

        } catch (err) {
            showAlert('danger', 'Gagal mengirim ulasan. Periksa koneksi kamu dan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
        }
    });
})();
</script>