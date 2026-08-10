<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-images"></i>
                    Galeri
                </span>
                <h2>Kelola Galeri Wisata</h2>
                <p>Kelola foto-foto destinasi wisata Tasikmalaya.</p>
            </div>

            <a href="{{ route('galeri.create') }}" class="btn-add">
                <i class="bi bi-plus-circle"></i>
                Tambah Foto
            </a>
        </div>
    </x-slot>

    <div class="page-wrapper">

        @if (session('success'))
            <div class="alert-success">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="gallery-grid">

            @forelse ($galeris as $galeri)
                <div class="gallery-card">
                    <div class="gallery-image">
                        <img src="{{ asset('storage/' . $galeri->foto) }}" alt="{{ $galeri->judul }}">

                        <div class="gallery-actions">
                            <a href="{{ route('galeri.edit', $galeri->id) }}" class="gallery-btn" title="Edit">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <form action="{{ route('galeri.destroy', $galeri->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="gallery-btn danger" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="gallery-info">
                        <h4>{{ $galeri->judul }}</h4>

                        @if ($galeri->destinasi)
                            <span>
                                <i class="bi bi-geo-alt"></i>
                                {{ $galeri->destinasi->nama }}
                            </span>
                        @endif

                        @if ($galeri->keterangan)
                            <p>{{ Str::limit($galeri->keterangan, 60) }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-images"></i>
                    <h4>Belum ada foto</h4>
                    <p>Mulai tambahkan foto destinasi wisata ke galeri.</p>
                    <a href="{{ route('galeri.create') }}" class="btn-add">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Foto
                    </a>
                </div>
            @endforelse

        </div>

        <div class="pagination-wrapper">
            {{ $galeris->links() }}
        </div>

    </div>

    @include('partials.admin-styles')
</x-app-layout>