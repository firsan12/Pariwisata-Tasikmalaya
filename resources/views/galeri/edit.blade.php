<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-images"></i>
                    Galeri
                </span>
                <h2>Edit Foto Galeri</h2>
                <p>Perbarui informasi foto galeri.</p>
            </div>

            <a href="{{ route('galeri') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        <div class="form-panel">

            <div class="current-image">
                <img src="{{ asset('storage/' . $galeri->foto) }}" alt="{{ $galeri->judul }}">
            </div>

            <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="judul">Judul Foto</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $galeri->judul) }}" required>
                    @error('judul') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="destinasi_id">Destinasi Terkait (opsional)</label>
                    <select name="destinasi_id" id="destinasi_id">
                        <option value="">-- Pilih Destinasi --</option>
                        @foreach ($destinasis as $destinasi)
                            <option value="{{ $destinasi->id }}" @selected(old('destinasi_id', $galeri->destinasi_id) == $destinasi->id)>
                                {{ $destinasi->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('destinasi_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Ganti Foto (opsional)</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <small>Kosongkan jika tidak ingin mengganti foto.</small>
                    @error('foto') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan (opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="4">{{ old('keterangan', $galeri->keterangan) }}</textarea>
                    @error('keterangan') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('galeri') }}" class="btn-cancel">Batal</a>
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