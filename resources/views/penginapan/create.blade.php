<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-building-fill"></i>
                    Penginapan
                </span>
                <h2>Tambah Penginapan</h2>
                <p>Tambahkan informasi akomodasi baru.</p>
            </div>

            <a href="{{ route('penginapan') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        <div class="form-panel">

            <form action="{{ route('penginapan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama">Nama Penginapan</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           placeholder="Contoh: Villa Galunggung" required>
                    @error('nama') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                           placeholder="Alamat lengkap penginapan">
                    @error('alamat') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="harga_per_malam">Harga per Malam (Rp)</label>
                        <input type="number" step="0.01" name="harga_per_malam" id="harga_per_malam"
                               value="{{ old('harga_per_malam') }}" placeholder="Contoh: 350000">
                        @error('harga_per_malam') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating (1-5)</label>
                        <input type="number" min="1" max="5" name="rating" id="rating"
                               value="{{ old('rating') }}" placeholder="Contoh: 4">
                        @error('rating') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
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
                              placeholder="Ceritakan tentang fasilitas dan kenyamanan penginapan ini">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('penginapan') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        Simpan Penginapan
                    </button>
                </div>

            </form>

        </div>

    </div>

    @include('partials.admin-styles')
</x-app-layout>