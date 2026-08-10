<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-cup-hot-fill"></i>
                    Kuliner
                </span>
                <h2>Edit Kuliner</h2>
                <p>Perbarui informasi kuliner.</p>
            </div>

            <a href="{{ route('kuliner') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        <div class="form-panel">

            @if ($kuliner->foto)
                <div class="current-image">
                    <img src="{{ asset('storage/' . $kuliner->foto) }}" alt="{{ $kuliner->nama }}">
                </div>
            @endif

            <form action="{{ route('kuliner.update', $kuliner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Kuliner</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $kuliner->nama) }}" required>
                    @error('nama') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $kuliner->alamat) }}">
                    @error('alamat') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="harga_mulai">Harga Mulai (Rp)</label>
                    <input type="number" step="0.01" name="harga_mulai" id="harga_mulai"
                           value="{{ old('harga_mulai', $kuliner->harga_mulai) }}">
                    @error('harga_mulai') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Ganti Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <small>Kosongkan jika tidak ingin mengganti foto.</small>
                    @error('foto') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi', $kuliner->deskripsi) }}</textarea>
                    @error('deskripsi') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('kuliner') }}" class="btn-cancel">Batal</a>
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