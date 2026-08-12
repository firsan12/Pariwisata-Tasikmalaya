<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-cup-hot-fill"></i>
                    Kuliner
                </span>
                <h2>Kelola Kuliner</h2>
                <p>Kelola informasi kuliner khas Tasikmalaya.</p>
            </div>

            <a href="{{ route('kuliner.create') }}" class="btn-add">
                <i class="bi bi-plus-circle"></i>
                Tambah Kuliner
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

        <div class="table-panel">

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Harga Mulai</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kuliners as $kuliner)
                        <tr>
                           <td>
    <div class="table-thumb">
        @if ($kuliner->foto_url)
            <img src="{{ $kuliner->foto_url }}" alt="{{ $kuliner->nama }}" loading="lazy">
        @else
            <i class="bi bi-cup-hot-fill"></i>
        @endif
    </div>
</td>
                            <td>
                                <strong>{{ $kuliner->nama }}</strong>
                                @if ($kuliner->deskripsi)
                                    <p class="table-sub">{{ Str::limit($kuliner->deskripsi, 50) }}</p>
                                @endif
                            </td>
                            <td>{{ $kuliner->alamat ?? '-' }}</td>
                            <td>
                                {{ $kuliner->harga_mulai ? 'Rp ' . number_format($kuliner->harga_mulai, 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('kuliner.edit', $kuliner->id) }}" class="table-btn" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('kuliner.destroy', $kuliner->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus data kuliner ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-btn danger" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-cup-hot-fill"></i>
                                    <h4>Belum ada data kuliner</h4>
                                    <p>Mulai tambahkan informasi kuliner khas Tasikmalaya.</p>
                                    <a href="{{ route('kuliner.create') }}" class="btn-add">
                                        <i class="bi bi-plus-circle"></i>
                                        Tambah Kuliner
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        @if ($kuliners->hasPages())
    <div class="kk-pagination">

        <div class="kk-pagination-info">
            Menampilkan
            <strong>{{ $kuliners->firstItem() }}</strong>
            –
            <strong>{{ $kuliners->lastItem() }}</strong>
            dari
            <strong>{{ $kuliners->total() }}</strong>
            kuliner
        </div>

        <div class="kk-pagination-buttons">

            {{-- Previous --}}
            @if ($kuliners->onFirstPage())
                <span class="kk-page disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $kuliners->previousPageUrl() }}" class="kk-page">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($kuliners->getUrlRange(1, $kuliners->lastPage()) as $page => $url)
                @if ($page == $kuliners->currentPage())
                    <span class="kk-page active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="kk-page">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($kuliners->hasMorePages())
                <a href="{{ $kuliners->nextPageUrl() }}" class="kk-page">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="kk-page disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif

        </div>

    </div>
@endif

    </div>

    @include('partials.admin-styles')
</x-app-layout>