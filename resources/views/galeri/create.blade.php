<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-images"></i>
                    Galeri
                </span>
                <h2>Tambah Foto Galeri</h2>
                <p>Unggah foto baru untuk galeri wisata.</p>
            </div>

            <a href="{{ route('galeri') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        <div class="form-panel">

            <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="judul">Judul Foto</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                           placeholder="Contoh: Sunrise di Gunung Galunggung" required>
                    @error('judul') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="destinasi_id">Destinasi Terkait (opsional)</label>
                    <select name="destinasi_id" id="destinasi_id">
                        <option value="">-- Pilih Destinasi --</option>
                        @foreach ($destinasis as $destinasi)
                            <option value="{{ $destinasi->id }}" @selected(old('destinasi_id') == $destinasi->id)>
                                {{ $destinasi->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('destinasi_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" accept="image/*" required>
                    <small>Format JPG/PNG, maksimal 2MB.</small>
                    @error('foto') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan (opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="4"
                              placeholder="Deskripsi singkat tentang foto ini">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('galeri') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        Simpan Foto
                    </button>
                </div>

            </form>

        </div>

    </div>

    @include('partials.admin-styles')
</x-app-layout>