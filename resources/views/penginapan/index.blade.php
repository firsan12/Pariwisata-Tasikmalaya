<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <span class="page-badge">
                    <i class="bi bi-building-fill"></i>
                    Penginapan
                </span>
                <h2>Kelola Penginapan</h2>
                <p>Kelola informasi akomodasi dan penginapan.</p>
            </div>

            <a href="{{ route('penginapan.create') }}" class="btn-add">
                <i class="bi bi-plus-circle"></i>
                Tambah Penginapan
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
                        <th>Harga / Malam</th>
                        <th>Rating</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penginapans as $penginapan)
                        <tr>
                            <td>
                                <div class="table-thumb">
                                    @if ($penginapan->foto)
                                        <img src="{{ asset('storage/' . $penginapan->foto) }}" alt="{{ $penginapan->nama }}">
                                    @else
                                        <i class="bi bi-building-fill"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <strong>{{ $penginapan->nama }}</strong>
                                @if ($penginapan->deskripsi)
                                    <p class="table-sub">{{ Str::limit($penginapan->deskripsi, 50) }}</p>
                                @endif
                            </td>
                            <td>{{ $penginapan->alamat ?? '-' }}</td>
                            <td>
                                {{ $penginapan->harga_per_malam ? 'Rp ' . number_format($penginapan->harga_per_malam, 0, ',', '.') : '-' }}
                            </td>
                            <td>
                                @if ($penginapan->rating)
                                    <span class="rating-badge">
                                        <i class="bi bi-star-fill"></i>
                                        {{ $penginapan->rating }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="table-actions">
                                    <a href="{{ route('penginapan.edit', $penginapan->id) }}" class="table-btn" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('penginapan.destroy', $penginapan->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus data penginapan ini?');">
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
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-building-fill"></i>
                                    <h4>Belum ada data penginapan</h4>
                                    <p>Mulai tambahkan informasi akomodasi wisata.</p>
                                    <a href="{{ route('penginapan.create') }}" class="btn-add">
                                        <i class="bi bi-plus-circle"></i>
                                        Tambah Penginapan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="pagination-wrapper">
            {{ $penginapans->links() }}
        </div>

    </div>

    @include('partials.admin-styles')
</x-app-layout>