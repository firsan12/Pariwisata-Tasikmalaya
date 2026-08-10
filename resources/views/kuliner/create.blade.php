<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-cup-hot-fill"></i>
                    Kuliner
                </span>
                <h2>Tambah Kuliner</h2>
                <p>Tambahkan informasi kuliner baru.</p>
            </div>

            <a href="{{ route('kuliner') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        <div class="form-panel">

            <form action="{{ route('kuliner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Kuliner</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           placeholder="Contoh: Soto Ayam Tasik" required>
                    @error('nama') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                           placeholder="Alamat lengkap lokasi kuliner">
                    @error('alamat') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="harga_mulai">Harga Mulai (Rp)</label>
                    <input type="number" step="0.01" name="harga_mulai" id="harga_mulai"
                           value="{{ old('harga_mulai') }}" placeholder="Contoh: 15000">
                    @error('harga_mulai') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <small>Format JPG/PNG, maksimal 2MB.</small>
                    @error('foto') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              placeholder="Ceritakan tentang kuliner ini">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('kuliner') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        Simpan Kuliner
                    </button>
                </div>

            </form>

        </div>

    </div>

    @include('partials.admin-styles')
</x-app-layout>