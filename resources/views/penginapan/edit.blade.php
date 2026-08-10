<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-building-fill"></i>
                    Penginapan
                </span>
                <h2>Edit Penginapan</h2>
                <p>Perbarui informasi penginapan.</p>
            </div>

            <a href="{{ route('penginapan') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        <div class="form-panel">

            @if ($penginapan->foto)
                <div class="current-image">
                    <img src="{{ asset('storage/' . $penginapan->foto) }}" alt="{{ $penginapan->nama }}">
                </div>
            @endif

            <form action="{{ route('penginapan.update', $penginapan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Penginapan</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $penginapan->nama) }}" required>
                    @error('nama') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $penginapan->alamat) }}">
                    @error('alamat') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="harga_per_malam">Harga per Malam (Rp)</label>
                        <input type="number" step="0.01" name="harga_per_malam" id="harga_per_malam"
                               value="{{ old('harga_per_malam', $penginapan->harga_per_malam) }}">
                        @error('harga_per_malam') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating (1-5)</label>
                        <input type="number" min="1" max="5" name="rating" id="rating"
                               value="{{ old('rating', $penginapan->rating) }}">
                        @error('rating') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto">Ganti Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <small>Kosongkan jika tidak ingin mengganti foto.</small>
                    @error('foto') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', $penginapan->deskripsi) }}</textarea>
                    @error('deskripsi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('penginapan') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </div>

    @include('partials.admin-styles')
</x-app-layout>