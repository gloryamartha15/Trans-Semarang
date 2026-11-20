
@extends('layout.app')

@section('title', 'Lacak Pengaduan | Trans Semarang')

@section('content')

<section style="padding: 60px 20px 80px; background: var(--cream); min-height: 70vh;">
    <div class="container" style="max-width: 720px;">

        <div class="section-heading" style="margin-bottom: 30px;">
            <div class="section-kicker">PELACAKAN PENGADUAN</div>
            <h2>Lacak Pengaduan Anda</h2>
            <p>
                Masukkan nomor pengaduan untuk melihat
                perkembangan laporan Anda.
            </p>
        </div>

        <div style="background: white; padding: 30px; border-radius: 18px; border: 1px solid var(--line); box-shadow: var(--shadow);">

            <form action="{{ route('aduan.track') }}" method="GET">

                <label for="no_aduan"
                    style="display:block; font-weight:600; margin-bottom:8px;">
                    Nomor Pengaduan
                </label>

                <input
                    type="text"
                    id="no_aduan"
                    name="no_aduan"
                    value="{{ request('no_aduan') }}"
                    placeholder="Contoh: ADU-20261119-A8K2P"
                    required
                    style="width:100%; padding:14px; border:1px solid var(--line); border-radius:10px; margin-bottom:15px;"
                >

                <button type="submit" class="btn btn-primary"
                    style="width:100%;">
                    Lacak Pengaduan
                </button>

            </form>

            @if ($searched && !$complaint)
                <div style="margin-top:22px; padding:15px; background:#fee2e2; color:#991b1b; border-radius:10px;">
                    Nomor pengaduan tidak ditemukan.
                    Periksa kembali nomor yang Anda masukkan.
                </div>
            @endif

        </div>
<br><br><br><br>        
        @if ($complaint)

            @php
                $statusLabels = [
                    'diajukan' => 'Diajukan',
                    'diverifikasi' => 'Diverifikasi',
                    'ditindaklanjuti' => 'Ditindaklanjuti',
                    'selesai' => 'Selesai',
                ];

                $statusColors = [
                    'diajukan' => '#d97706',
                    'diverifikasi' => '#2563eb',
                    'ditindaklanjuti' => '#7c3aed',
                    'selesai' => '#059669',
                ];
            @endphp

            <div style="margin-top:25px; background:white; padding:28px; border-radius:18px; border:1px solid var(--line); box-shadow:var(--shadow);">

                <div style="margin-bottom:20px;">
                    <div style="font-size:12px; color:var(--muted);">
                        NOMOR PENGADUAN
                    </div>

                    <h3 style="margin-top:5px;">
                        {{ $complaint->no_aduan }}
                    </h3>
                </div>

                <div style="margin-bottom:20px;">
                    <div style="font-size:12px; color:var(--muted);">
                        STATUS TERKINI
                    </div>

                    <span style="
                        display:inline-block;
                        margin-top:8px;
                        padding:8px 15px;
                        border-radius:20px;
                        color:white;
                        background:{{ $statusColors[$complaint->status_aduan] ?? '#6b7280' }};
                    ">
                        {{ $statusLabels[$complaint->status_aduan] ?? $complaint->status_aduan }}
                    </span>
                </div>

                <hr>

                <h3 style="margin:20px 0 12px;">
                    Informasi Pengaduan
                </h3>

                <p><strong>Judul:</strong> {{ $complaint->judul }}</p>

                <p>
                    <strong>Kategori:</strong>
                    {{ $complaint->categories?->jenis_aduan ?? '-' }}
                </p>

                <p>
                    <strong>Bus:</strong>
                    {{ $complaint->buses?->police_number ?? '-' }}
                </p>

                <p>
                    <strong>Halte:</strong>
                    {{ $complaint->stops?->name_stop ?? '-' }}
                </p>

                <p>
                    <strong>Tanggal laporan:</strong>
                    {{ $complaint->created_at->format('d M Y, H:i') }}
                </p>

                <hr>

                <h3 style="margin:20px 0 15px;">
                    Tanggapan Petugas
                </h3>

                @forelse ($complaint->replays as $replay)

                    <div style="padding:16px; background:#f8fafc; border-radius:12px; margin-bottom:12px; border:1px solid var(--line);">

                        <div style="font-size:12px; color:var(--muted); margin-bottom:8px;">
                            {{ $replay->created_at->format('d M Y, H:i') }}
                        </div>

                        <p style="line-height:1.7;">
                            {{ $replay->tanggapan }}
                        </p>

                    </div>

                @empty

                    <p style="color:var(--muted);">
                        Belum ada tanggapan dari petugas.
                    </p>

                @endforelse

            </div>

        @endif

    </div>
</section>

@endsection
