@extends('Layout.app')

@section('title', 'Lacak Pengaduan | Trans Semarang')

@section('content')

@php
    $statusLabels = [
        'diajukan' => 'Diajukan',
        'ditanggapi' => 'Ditanggapi',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    $statusColors = [
        'diajukan' => '#D99A18',
        'ditanggapi' => '#2874C8',
        'selesai' => '#218653',
        'ditolak' => '#D64545',
    ];

    $currentStatus = $complaint?->status_aduan;

    $histories = $complaint
        ? $complaint->statusHistories->sortBy('created_at')
        : collect();
@endphp

<style>
    .track-page {
        background: #f4f7fb;
        min-height: 80vh;
        padding: 65px 20px 90px;
        color: #24364b;
    }

    .track-container {
        max-width: 850px;
        margin: auto;
    }

    .track-heading {
        text-align: center;
        margin-bottom: 35px;
    }

    .track-kicker {
        color: #2874c8;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .track-heading h1 {
        color: #17385e;
        font-size: clamp(27px, 4vw, 38px);
        font-weight: 800;
        margin-bottom: 12px;
    }

    .track-heading p {
        color: #718096;
        line-height: 1.7;
        max-width: 550px;
        margin: auto;
    }

    .track-card {
        background: #fff;
        border: 1px solid #e6ecf3;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 8px 30px rgba(25, 55, 90, .055);
        margin-bottom: 22px;
    }

    .track-label {
        display: block;
        color: #53657a;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .track-input {
        width: 100%;
        padding: 15px 16px;
        border: 1px solid #dce4ee;
        border-radius: 11px;
        font-size: 14px;
        color: #23364d;
        outline: none;
        transition: .2s;
        background: #fff;
    }

    .track-input:focus {
        border-color: #2874c8;
        box-shadow: 0 0 0 3px rgba(40, 116, 200, .10);
    }

    .track-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        border: none;
        background: #17385e;
        color: #fff;
        padding: 15px;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .track-button:hover {
        background: #24517f;
        transform: translateY(-1px);
    }

    .track-hint {
        color: #8996a7;
        font-size: 12px;
        line-height: 1.6;
        margin-top: 12px;
    }

    .track-error {
        background: #fff1f1;
        border: 1px solid #fecaca;
        color: #b42323;
        padding: 15px;
        border-radius: 11px;
        margin-top: 20px;
        font-size: 13px;
    }

    .track-result {
        margin-top: 35px;
    }

    .track-result-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        flex-wrap: wrap;
    }

    .track-eyebrow {
        color: #8a98a9;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.3px;
        margin-bottom: 8px;
    }

    .track-number {
        color: #17385e;
        font-size: clamp(19px, 3vw, 25px);
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .track-status {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 30px;
        color: white;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .track-section-title {
        color: #17385e;
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .track-divider {
        border: 0;
        border-top: 1px solid #edf0f5;
        margin: 25px 0;
    }

    .track-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .track-info-item small {
        display: block;
        color: #8996a7;
        font-size: 11px;
        margin-bottom: 6px;
    }

    .track-info-item strong {
        display: block;
        color: #344a63;
        font-size: 13px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .track-description {
        color: #53657a;
        font-size: 13px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .track-response {
        border: 1px solid #e7edf4;
        background: #f8fafc;
        border-radius: 13px;
        padding: 18px;
        margin-bottom: 13px;
    }

    .track-response p {
        color: #42566e;
        font-size: 13px;
        line-height: 1.8;
        white-space: pre-line;
        margin: 10px 0 0;
    }

    .track-response-meta {
        color: #8795a6;
        font-size: 11px;
        margin-top: 10px;
    }

    .track-timeline {
        position: relative;
        padding-left: 25px;
    }

    .track-timeline-item {
        position: relative;
        padding: 0 0 25px 20px;
        border-left: 2px solid #e5ebf2;
    }

    .track-timeline-item:last-child {
        border-left-color: transparent;
        padding-bottom: 0;
    }

    .track-timeline-dot {
        position: absolute;
        left: -8px;
        top: 1px;
        width: 14px;
        height: 14px;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 1px #dce5ef;
    }

    .track-timeline-title {
        color: #344a63;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .track-timeline-note {
        color: #64748b;
        font-size: 13px;
        line-height: 1.7;
        white-space: pre-line;
        margin-top: 9px;
    }

    .track-timeline-meta {
        color: #98a4b3;
        font-size: 11px;
        margin-top: 8px;
    }

    .track-empty {
        background: #f8fafc;
        border: 1px dashed #dce4ee;
        border-radius: 12px;
        padding: 20px;
        color: #8795a6;
        font-size: 13px;
        text-align: center;
    }

    .track-image {
        width: 100%;
        max-height: 350px;
        object-fit: contain;
        border-radius: 12px;
        border: 1px solid #e6ecf3;
        background: #f8fafc;
    }

    @media(max-width: 600px) {
        .track-page {
            padding: 40px 15px 60px;
        }

        .track-card {
            padding: 20px;
            border-radius: 15px;
        }

        .track-info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
</style>

<section class="track-page">
    <div class="track-container">

        {{-- HEADER --}}
        <div class="track-heading">
            <div class="track-kicker">TRANS SEMARANG • LAYANAN PENGADUAN</div>

            <h1>Lacak Pengaduan Anda</h1>

            <p>
                Pantau perkembangan laporan Anda secara mudah dan transparan.
                Masukkan nomor pengaduan untuk melihat informasi dan hasil
                penanganan dari petugas kami.
            </p>
        </div>

        {{-- FORM PENCARIAN --}}
        <div class="track-card">

            <form action="{{ route('aduan.track') }}" method="GET">

                <label for="no_aduan" class="track-label">
                    Nomor Pengaduan
                </label>

                <input
                    type="text"
                    id="no_aduan"
                    name="no_aduan"
                    value="{{ request('no_aduan') }}"
                    placeholder="Contoh: ADU-20261119-A8K2P"
                    class="track-input"
                    required
                >

                <div style="margin-top: 15px;">
                    <button type="submit" class="track-button">
                        <span>Lacak Pengaduan</span>
                        <span aria-hidden="true">→</span>
                    </button>
                </div>

                <p class="track-hint">
                    Pastikan nomor pengaduan yang dimasukkan sesuai dengan
                    nomor yang diberikan setelah laporan berhasil dikirim.
                </p>

            </form>

            {{-- PESAN TIDAK DITEMUKAN --}}
            @if ($searched && !$complaint)
                <div class="track-error">
                    <strong>Pengaduan tidak ditemukan.</strong>
                    <br>
                    Periksa kembali nomor pengaduan Anda dan coba lagi.
                </div>
            @endif

        </div>

        {{-- HASIL PENCARIAN --}}
        @if ($complaint)

            <div class="track-result">

                {{-- NOMOR DAN STATUS --}}
                <div class="track-card">

                    <div class="track-result-header">

                        <div>
                            <div class="track-eyebrow">
                                NOMOR PENGADUAN
                            </div>

                            <div class="track-number">
                                {{ $complaint->no_aduan }}
                            </div>

                            <div style="color:#8996a7; font-size:12px; margin-top:7px;">
                                Dikirim pada
                                {{ $complaint->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <span
                            class="track-status"
                            style="background:{{ $statusColors[$currentStatus] ?? '#64748b' }};"
                        >
                            {{ $statusLabels[$currentStatus] ?? $currentStatus }}
                        </span>

                    </div>

                    <hr class="track-divider">

                    <div class="track-section-title">
                        Informasi Pengaduan
                    </div>

                    <div class="track-info-grid">

                        <div class="track-info-item">
                            <small>Nama Pengadu</small>
                            <strong>{{ $complaint->nama_pengadu }}</strong>
                        </div>

                        <div class="track-info-item">
                            <small>Kategori Pengaduan</small>
                            <strong>
                                {{ $complaint->categories?->jenis_aduan ?? '-' }}
                            </strong>
                        </div>

                        <div class="track-info-item">
                            <small>Nomor Polisi Bus</small>
                            <strong>
                                {{ $complaint->bus?->police_number ?? '-' }}
                            </strong>
                        </div>

                        <div class="track-info-item">
                            <small>Nama Halte</small>
                            <strong>
                                {{ $complaint->stop?->name_stop ?? '-' }}
                            </strong>
                        </div>

                        <div class="track-info-item" style="grid-column:1/-1;">
                            <small>Judul Pengaduan</small>
                            <strong>{{ $complaint->judul }}</strong>
                        </div>

                    </div>

                    <hr class="track-divider">

                    <div class="track-section-title">
                        Detail Laporan
                    </div>

                    <p class="track-description">
                        {{ $complaint->isi_aduan }}
                    </p>

                    @if ($complaint->dokumentasi)
                        <div style="margin-top:20px;">
                            <div class="track-label">Dokumentasi Pengaduan</div>

                            <img
                                src="{{ asset('storage/' . $complaint->dokumentasi) }}"
                                alt="Dokumentasi pengaduan"
                                class="track-image"
                                loading="lazy"
                            >
                        </div>
                    @endif

                </div>

                {{-- TANGGAPAN PETUGAS --}}
                <div class="track-card">

                    <div class="track-section-title">
                        Tanggapan Petugas
                    </div>

                    @forelse ($complaint->replays->sortBy('created_at') as $replay)

                        <div class="track-response">

                            <div style="font-weight:800; color:#2874c8; font-size:13px;">
                                Tanggapan Petugas
                                @if ($replay->cycle_number)
                                    • Siklus {{ $replay->cycle_number }}
                                @endif
                            </div>

                            <p>{{ $replay->tanggapan }}</p>

                            <div class="track-response-meta">
                                {{ $replay->petugas?->name ?? 'Petugas Trans Semarang' }}
                                &nbsp;•&nbsp;
                                {{ $replay->created_at->format('d M Y, H:i') }}
                            </div>

                        </div>

                    @empty

                        <div class="track-empty">
                            Aduan Anda sudah tercatat. Tanggapan petugas
                            belum tersedia.
                        </div>

                    @endforelse

                </div>

                {{-- RIWAYAT STATUS --}}
                <div class="track-card">

                    <div class="track-section-title">
                        Riwayat Penanganan Aduan
                    </div>

                    <p style="color:#8996a7; font-size:12px; margin-top:-10px; margin-bottom:25px;">
                        Berikut perkembangan laporan Anda sejak dikirim
                        hingga proses penanganan.
                    </p>

                    <div class="track-timeline">

                        {{-- STATUS AWAL --}}
                        <div class="track-timeline-item">

                            <span
                                class="track-timeline-dot"
                                style="background:{{ $statusColors['diajukan'] }};"
                            ></span>

                            <div class="track-timeline-title">
                                Aduan Diajukan
                            </div>

                            <span
                                class="track-status"
                                style="background:{{ $statusColors['diajukan'] }}; padding:5px 10px;"
                            >
                                Diajukan
                            </span>

                            <div class="track-timeline-note">
                                Pengaduan berhasil dikirim dan tercatat
                                dalam sistem.
                            </div>

                            <div class="track-timeline-meta">
                                {{ $complaint->created_at->format('d M Y, H:i') }}
                            </div>

                        </div>

                        {{-- RIWAYAT PERUBAHAN STATUS --}}
                        @foreach ($histories as $history)

                            @php
                                $historyColor = $statusColors[$history->new_status] ?? '#64748b';

                                $historyLabel = $statusLabels[$history->new_status]
                                    ?? ucfirst($history->new_status);
                            @endphp

                            <div class="track-timeline-item">

                                <span
                                    class="track-timeline-dot"
                                    style="background:{{ $historyColor }};"
                                ></span>

                                <div class="track-timeline-title">
                                    {{ $historyLabel }}
                                </div>

                                <span
                                    class="track-status"
                                    style="background:{{ $historyColor }}; padding:5px 10px;"
                                >
                                    {{ $historyLabel }}
                                </span>

                                @if ($history->notes)
                                    <div class="track-timeline-note">
                                        {{ $history->notes }}
                                    </div>
                                @elseif ($history->new_status === 'ditanggapi')
                                    <div class="track-timeline-note">
                                        Petugas telah memberikan tanggapan
                                        terhadap pengaduan Anda.
                                    </div>
                                @elseif ($history->new_status === 'diajukan')
                                    <div class="track-timeline-note">
                                        Aduan dibuka kembali untuk proses
                                        penanganan selanjutnya.
                                    </div>
                                @endif

                                <div class="track-timeline-meta">
                                    {{ $history->user?->name ?? 'Petugas Trans Semarang' }}
                                    &nbsp;•&nbsp;
                                    {{ $history->created_at->format('d M Y, H:i') }}
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                <div style="text-align:center; padding:10px 15px;">
                    <p style="color:#8795a6; font-size:12px; line-height:1.7;">
                        Informasi ini ditampilkan berdasarkan data pengaduan
                        yang tersimpan dalam sistem Lapor Trans Semarang.
                    </p>
                </div>

            </div>

        @endif

    </div>
</section>

@endsection
