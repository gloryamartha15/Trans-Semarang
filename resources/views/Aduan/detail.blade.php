@extends('Layout.app')

@section('title', 'Detail Pengaduan | Trans Semarang')

@section('content')

@php
    $statusLabels = [
        'diajukan' => 'Menunggu Tanggapan',
        'ditanggapi' => 'Sedang Ditindaklanjuti',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    $statusColors = [
        'diajukan' => '#d97706',
        'ditanggapi' => '#2563eb',
        'selesai' => '#16a34a',
        'ditolak' => '#dc2626',
    ];

    $status = $complaint->status_aduan;
    $replays = $complaint->replays->sortBy('created_at');
    $histories = $complaint->statusHistories->sortBy('created_at');
@endphp

<section style="padding: 48px 0 72px; background: var(--cream);">
    <div class="container" style="max-width: 850px;">

        {{-- Header --}}
        <div class="section-heading" style="margin-bottom: 28px;">
            <div class="section-kicker">AKUN SAYA</div>
            <h2>Detail Pengaduan</h2>
            <p>Informasi dan perkembangan pengaduan yang telah kamu kirim.</p>
        </div>

        {{-- Informasi Utama --}}
        <div class="detail-card">

            <div class="detail-header">
                <div>
                    <small>Nomor Tiket Pengaduan</small>
                    <h3>{{ $complaint->no_aduan }}</h3>
                </div>

                <span class="status-badge"
                    style="background: {{ $statusColors[$status] ?? '#6b7280' }};">
                    {{ $statusLabels[$status] ?? ucfirst($status) }}
                </span>
            </div>

            <div class="detail-divider"></div>

            <h3 class="complaint-title">{{ $complaint->judul }}</h3>

            <div class="detail-grid">
                <div>
                    <small>Nama Pengadu</small>
                    <p>{{ $complaint->nama_pengadu }}</p>
                </div>

                <div>
                    <small>Kategori</small>
                    <p>{{ $complaint->categories?->jenis_aduan ?? '-' }}</p>
                </div>

                <div>
                    <small>Nomor Bus</small>
                    <p>{{ $complaint->bus?->police_number ?? '-' }}</p>
                </div>

                <div>
                    <small>Nama Halte</small>
                    <p>{{ $complaint->stop?->name_stop ?? '-' }}</p>
                </div>

                <div>
                    <small>Tanggal Pengaduan</small>
                    <p>{{ $complaint->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="detail-divider"></div>

            <h4>Isi Pengaduan</h4>
            <p class="complaint-content">
                {{ $complaint->isi_aduan }}
            </p>

            @if ($complaint->dokumentasi)
                <div style="margin-top: 22px;">
                    <h4>Dokumentasi / Bukti</h4>

                    @php
                        $extension = strtolower(pathinfo($complaint->dokumentasi, PATHINFO_EXTENSION));
                        $fileUrl = asset('storage/' . $complaint->dokumentasi);
                    @endphp

                    @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                        <a href="{{ $fileUrl }}" target="_blank">
                            <img src="{{ $fileUrl }}"
                                alt="Dokumentasi Pengaduan"
                                style="max-width: 100%; max-height: 350px; border-radius: 12px; margin-top: 10px; object-fit: contain;">
                        </a>
                    @else
                        <p style="margin-top: 10px;">
                            <a href="{{ $fileUrl }}" target="_blank">
                                Lihat dokumen PDF
                            </a>
                        </p>
                    @endif
                </div>
            @endif

        </div>

        {{-- Tanggapan Petugas --}}
        <div class="detail-card" style="margin-top: 22px;">
            <h3 class="section-title">Tanggapan Petugas</h3>

            @forelse ($replays as $replay)
                <div class="replay-item">
                    <div class="replay-header">
                        <strong>
                            {{ $replay->petugas?->name ?? 'Petugas Trans Semarang' }}
                        </strong>
                        <small>
                            {{ $replay->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>

                    <small style="color: var(--muted);">
                        Tanggapan siklus ke-{{ $replay->cycle_number }}
                    </small>

                    <p class="complaint-content" style="margin-top: 12px;">
                        {{ $replay->tanggapan }}
                    </p>
                </div>
            @empty
                <div class="empty-response">
                    <strong>Belum Ada Tanggapan</strong>
                    <p>
                        Pengaduanmu sudah diterima. Petugas akan memberikan
                        tanggapan setelah laporan ditinjau.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Riwayat Status --}}
        <div class="detail-card" style="margin-top: 22px;">
            <h3 class="section-title">Riwayat Status Pengaduan</h3>

            <div class="timeline">

                <div class="timeline-item">
                    <div class="timeline-dot" style="background: #d97706;"></div>
                    <div>
                        <strong>Pengaduan Dikirim</strong>
                        <p>
                            {{ $complaint->created_at->format('d M Y, H:i') }}
                        </p>
                        <small>Pengaduan berhasil diterima oleh sistem.</small>
                    </div>
                </div>

                @foreach ($histories as $history)
                    <div class="timeline-item">
                        <div class="timeline-dot"
                            style="background: {{ $statusColors[$history->new_status] ?? '#6b7280' }};">
                        </div>

                        <div>
                            <strong>
                                {{ $statusLabels[$history->new_status] ?? ucfirst($history->new_status) }}
                            </strong>

                            <p>
                                {{ $history->created_at->format('d M Y, H:i') }}
                            </p>

                            @if ($history->user)
                                <small>
                                    Oleh: {{ $history->user->name }}
                                </small>
                            @endif

                            @if ($history->notes)
                                <p class="history-notes">
                                    {{ $history->notes }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Kembali --}}
        <div style="margin-top: 24px;">
            <a href="{{ route('aduan.history') }}" class="btn btn-outline">
                ← Kembali ke Riwayat Aduan
            </a>
        </div>

    </div>
</section>

<style>
    .detail-card {
        background: white;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 26px;
        box-shadow: var(--shadow);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
    }

    .detail-header small,
    .detail-grid small {
        color: var(--muted);
        font-size: 12px;
    }

    .detail-header h3 {
        color: var(--navy);
        margin-top: 5px;
        font-size: 17px;
    }

    .status-badge {
        color: white;
        font-size: 11px;
        padding: 7px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    .detail-divider {
        height: 1px;
        background: var(--line);
        margin: 22px 0;
    }

    .complaint-title {
        color: var(--navy);
        margin-bottom: 20px;
        font-size: 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .detail-grid p {
        margin-top: 5px;
        color: var(--text);
        font-size: 14px;
    }

    .detail-card h4 {
        color: var(--navy);
        font-size: 14px;
        margin-bottom: 10px;
    }

    .complaint-content {
        color: var(--text);
        font-size: 14px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .section-title {
        color: var(--navy);
        font-size: 17px;
        margin-bottom: 20px;
    }

    .replay-item {
        padding: 18px;
        background: #f7faf9;
        border: 1px solid var(--line);
        border-radius: 12px;
        margin-bottom: 14px;
    }

    .replay-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 8px;
    }

    .replay-header strong {
        color: var(--navy);
        font-size: 14px;
    }

    .replay-header small,
    .timeline p,
    .timeline small {
        color: var(--muted);
        font-size: 12px;
    }

    .empty-response {
        padding: 20px;
        background: #f7faf9;
        border-radius: 12px;
        text-align: center;
    }

    .empty-response strong {
        color: var(--navy);
    }

    .empty-response p {
        color: var(--muted);
        font-size: 13px;
        margin-top: 7px;
        line-height: 1.6;
    }

    .timeline {
        border-left: 2px solid var(--line);
        margin-left: 7px;
        padding-left: 22px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 25px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        left: -29px;
        top: 3px;
        border: 2px solid white;
    }

    .timeline-item strong {
        color: var(--navy);
        font-size: 14px;
    }

    .timeline-item p {
        margin: 5px 0;
        font-size: 12px;
    }

    .history-notes {
        background: #f7faf9;
        border-radius: 8px;
        padding: 10px;
        margin-top: 9px;
        font-size: 13px;
        line-height: 1.6;
    }

    @media (max-width: 560px) {
        .detail-card {
            padding: 20px 16px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .replay-header {
            flex-direction: column;
        }
    }
</style>

@endsection
