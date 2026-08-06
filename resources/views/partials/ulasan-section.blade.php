{{--
    Partial kartu ulasan — dipakai di destinasi-detail.blade.php.

    Variabel yang diterima:
    - $destinasi : instance Model Destinasi (wajib), sudah di-load relasi 'ulasan'
--}}

<section id="ulasan" class="ulasan-section mt-5">
    <h3 class="mb-4">Ulasan Pengunjung</h3>

    @if (session('ulasan_success'))
        <div class="alert alert-ulasan-sukses mb-4">
            <i class="bi bi-check-circle-fill"></i> {{ session('ulasan_success') }}
        </div>
    @endif

    {{-- Daftar ulasan yang sudah disetujui --}}
    @forelse ($destinasi->ulasan as $ulasan)
        <div class="ulasan-item mb-3 p-3 border rounded">
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
        <p class="text-muted">Belum ada ulasan untuk destinasi ini. Jadilah yang pertama!</p>
    @endforelse

    {{-- Form tambah ulasan --}}
    <div class="ulasan-form mt-4 p-4 border rounded">
        <h5 class="mb-3">Tulis Ulasan Kamu</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ulasan.store', $destinasi->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama_pengguna" class="form-control" required maxlength="100" value="{{ old('nama_pengguna') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email (opsional)</label>
                <input type="email" name="email_pengguna" class="form-control" maxlength="150" value="{{ old('email_pengguna') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                    <option value="">Pilih rating</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Komentar</label>
                <textarea name="komentar" class="form-control" rows="4" required minlength="10" maxlength="1000">{{ old('komentar') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
    </div>
</section>
