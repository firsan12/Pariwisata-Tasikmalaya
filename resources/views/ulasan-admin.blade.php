<x-app-layout>
    <x-slot name="header">
        <div class="ulasan-header">
            <div>
                <span class="ulasan-badge">
                    <i class="bi bi-star-fill"></i>
                    Kelola Ulasan
                </span>
                <h2>Ulasan Pengunjung</h2>
                <p>Moderasi, balas, dan pantau ulasan yang masuk dari pengunjung.</p>
            </div>
        </div>
    </x-slot>

    <div class="ulasan-wrapper">

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- FILTER TABS --}}
        <div class="filter-tabs">
            <a href="{{ route('ulasan.admin') }}" class="tab {{ !$status ? 'active' : '' }}">
                Semua <span>{{ $counts['semua'] }}</span>
            </a>
            <a href="{{ route('ulasan.admin', ['status' => 'pending']) }}" class="tab {{ $status === 'pending' ? 'active' : '' }}">
                Pending <span>{{ $counts['pending'] }}</span>
            </a>
            <a href="{{ route('ulasan.admin', ['status' => 'approved']) }}" class="tab {{ $status === 'approved' ? 'active' : '' }}">
                Disetujui <span>{{ $counts['approved'] }}</span>
            </a>
            <a href="{{ route('ulasan.admin', ['status' => 'ditolak']) }}" class="tab {{ $status === 'ditolak' ? 'active' : '' }}">
                Ditolak <span>{{ $counts['ditolak'] }}</span>
            </a>
        </div>

        {{-- LIST --}}
        <div class="ulasan-list">
            @forelse ($ulasanList as $ulasan)
                <div class="ulasan-card">
                    <div class="ulasan-top">
                        <div>
                            <h4>{{ $ulasan->nama_pengguna }}</h4>
                            <span class="ulasan-destinasi">
                                <i class="bi bi-geo-alt"></i>
                                {{ $ulasan->destinasi->nama ?? 'Destinasi dihapus' }}
                            </span>
                        </div>

                        <span class="status-badge status-{{ $ulasan->status }}">
                            {{ ucfirst($ulasan->status) }}
                        </span>
                    </div>

                    <div class="ulasan-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $ulasan->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </div>

                    <p class="ulasan-komentar">{{ $ulasan->komentar }}</p>

                    <span class="ulasan-tanggal">{{ $ulasan->created_at->translatedFormat('d F Y, H:i') }}</span>

                    @if ($ulasan->balasan_admin)
                        <div class="balasan-box">
                            <strong>Balasan pengelola:</strong>
                            <p>{{ $ulasan->balasan_admin }}</p>
                        </div>
                    @endif

                    <div class="ulasan-actions">
                        @if ($ulasan->status === 'pending')
                            <form action="{{ route('ulasan.approve', $ulasan) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-approve">
                                    <i class="bi bi-check-lg"></i> Setujui
                                </button>
                            </form>

                            <form action="{{ route('ulasan.reject', $ulasan) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-reject">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn-reply" onclick="document.getElementById('balas-{{ $ulasan->id }}').classList.toggle('show')">
                            <i class="bi bi-reply"></i> Balas
                        </button>

                        <form action="{{ route('ulasan.destroy', $ulasan) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>

                    <form id="balas-{{ $ulasan->id }}" action="{{ route('ulasan.balas', $ulasan) }}" method="POST" class="balas-form">
                        @csrf
                        <textarea name="balasan_admin" rows="2" placeholder="Tulis balasan untuk pengunjung..." required>{{ $ulasan->balasan_admin }}</textarea>
                        <button type="submit">Kirim Balasan</button>
                    </form>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-chat-square-text"></i>
                    <p>Belum ada ulasan{{ $status ? ' dengan status ini' : '' }}.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $ulasanList->links() }}
        </div>
    </div>

    <style>
        :root {
            --primary: #0ea5e9;
            --text: #172033;
            --muted: #64748b;
            --border: #e8edf4;
            --bg: #f5f7fb;
        }

        .ulasan-header h2 { margin: 7px 0 3px; font-size: 25px; font-weight: 800; color: var(--text); }
        .ulasan-header p { margin: 0; color: var(--muted); font-size: 14px; }
        .ulasan-badge {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 6px 11px; border-radius: 30px;
            background: #f2edff; color: #7c3aed; font-size: 12px; font-weight: 700;
        }

        .ulasan-wrapper { max-width: 900px; margin: 0 auto; padding: 30px 20px 50px; background: var(--bg); }

        .alert-success {
            padding: 12px 16px; margin-bottom: 18px;
            background: #eafaf0; border: 1px solid #b9edc9; color: #16693a;
            border-radius: 10px; font-size: 13px;
        }

        .filter-tabs { display: flex; gap: 8px; margin-bottom: 22px; flex-wrap: wrap; }
        .tab {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;
            color: var(--muted); background: white; border: 1px solid var(--border); text-decoration: none;
        }
        .tab span { background: #eef1f6; padding: 1px 7px; border-radius: 10px; font-size: 11px; }
        .tab.active { background: var(--primary); color: white; border-color: var(--primary); }
        .tab.active span { background: rgba(255,255,255,.25); color: white; }

        .ulasan-list { display: flex; flex-direction: column; gap: 14px; }
        .ulasan-card {
            background: white; border: 1px solid var(--border); border-radius: 16px;
            padding: 18px 20px; box-shadow: 0 6px 20px rgba(15,23,42,.035);
        }
        .ulasan-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
        .ulasan-top h4 { margin: 0; font-size: 14px; font-weight: 750; color: var(--text); }
        .ulasan-destinasi { font-size: 11px; color: var(--muted); }

        .status-badge { font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; }
        .status-pending { background: #fff3e0; color: #b45309; }
        .status-approved { background: #eafaf0; color: #16693a; }
        .status-ditolak { background: #fde8e8; color: #b91c1c; }

        .ulasan-rating { color: #f59e0b; font-size: 13px; margin: 6px 0; }
        .ulasan-komentar { font-size: 13px; color: #334155; line-height: 1.6; margin: 6px 0; }
        .ulasan-tanggal { font-size: 10px; color: #94a3b8; }

        .balasan-box {
            margin-top: 10px; padding: 10px 12px; background: #f5f7fb;
            border-left: 3px solid var(--primary); border-radius: 8px; font-size: 12px;
        }
        .balasan-box strong { font-size: 11px; color: var(--primary); }
        .balasan-box p { margin: 4px 0 0; color: #475569; }

        .ulasan-actions { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; }
        .ulasan-actions button {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 12px; border-radius: 8px; border: none;
            font-size: 12px; font-weight: 600; cursor: pointer;
        }
        .btn-approve { background: #eafaf0; color: #16693a; }
        .btn-reject { background: #fde8e8; color: #b91c1c; }
        .btn-reply { background: #eaf2ff; color: #2563eb; }
        .btn-delete { background: #f1f2f4; color: #475569; }

        .balas-form {
            display: none; margin-top: 12px; gap: 8px; flex-direction: column;
        }
        .balas-form.show { display: flex; }
        .balas-form textarea {
            border: 1px solid var(--border); border-radius: 8px; padding: 8px 10px; font-size: 12px; resize: vertical;
        }
        .balas-form button {
            align-self: flex-start; padding: 7px 14px; border: none; border-radius: 8px;
            background: var(--primary); color: white; font-size: 12px; font-weight: 600; cursor: pointer;
        }

        .empty-state { text-align: center; padding: 50px 0; color: var(--muted); }
        .empty-state i { font-size: 32px; display: block; margin-bottom: 10px; color: #cbd5e1; }

        .pagination-wrap { margin-top: 22px; }
    </style>
</x-app-layout>