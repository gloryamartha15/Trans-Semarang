
@extends('Layout.app')

@section('title', 'Riwayat Pengaduan | Trans Semarang')

@section('content')
<section style="padding: 50px 0;">
    <div class="container" style="max-width: 900px;">

        <div class="section-heading">
            <div class="section-kicker">AKUN SAYA</div>
            <h2>Riwayat Pengaduan</h2>
            <p>
                Halo, {{ Auth::guard('web')->user()->name }}.
                Berikut daftar pengaduan yang pernah kamu kirim.
            </p>
        </div>

        @forelse ($complaints as $complaint)
            <div style="padding: 20px; margin-bottom: 16px;
                        border: 1px solid #e5e7eb; border-radius: 12px;">

                <div style="display: flex; justify-content: space-between;
                            flex-wrap: wrap; gap: 10px;">

                    <strong>{{ $complaint->no_aduan }}</strong>

                    <span>{{ ucfirst($complaint->status_aduan) }}</span>
                </div>

                <h3 style="margin-top: 12px;">
                    {{ $complaint->judul }}
                </h3>

                <p>
                    Kategori:
                    {{ $complaint->categories->jenis_aduan ?? '-' }}
                </p>

                <p>
                    Bus:
                    {{ $complaint->bus?->police_number ?? '-' }}
                </p>

                <p>
                    Halte:
                    {{ $complaint->stop?->name_stop ?? '-' }}
                </p>

                <small>
                    Dikirim pada:
                    {{ $complaint->created_at->format('d-m-Y H:i') }}
                </small>

                <div style="margin-top: 16px;">
                    <a href="{{ route('aduan.detail', $complaint->id) }}"
                       class="btn btn-primary"
                       style="display: inline-block;">
                        Lihat Detail Aduan →
                    </a>
                </div>

            </div>
        @empty
            <div style="padding: 30px; text-align: center;">
                <h3>Belum Ada Pengaduan</h3>
                <p>Kamu belum pernah mengirim pengaduan.</p>

                <a href="{{ route('aduan.create') }}">
                    Buat Pengaduan
                </a>
            </div>
        @endforelse

        <div style="margin-top: 20px;">
            {{ $complaints->links() }}
        </div>

    </div>
</section>
@endsection
