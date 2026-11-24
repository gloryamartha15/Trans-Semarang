@extends('Layout.app')

@section('title', 'Data Tidak Aktif | Trans Semarang')

@section('content')

<section style="padding: 80px 20px; background: var(--cream); min-height: 65vh;">
    <div class="container" style="max-width: 550px; margin: auto;">

        <div style="background: white; padding: 40px 28px; border-radius: 18px; text-align: center; box-shadow: var(--shadow);">

            <div style="font-size: 48px; margin-bottom: 15px;">
                ⚠️
            </div>

            <h2 style="color: var(--navy);">
                {{ $type === 'halte' ? 'Halte Tidak Aktif' : 'Bus Tidak Aktif' }}
            </h2>

            <p style="color: var(--muted); line-height: 1.8; margin: 16px 0 25px;">
                Maaf, {{ $type === 'halte' ? 'halte' : 'bus' }}
                yang Anda pindai saat ini sudah tidak aktif atau
                tidak tersedia untuk pengaduan.
            </p>

            <a href="{{ route('aduan.create') }}" class="btn btn-primary">
                Isi Pengaduan Secara Manual
            </a>

            <div style="margin-top: 15px;">
                <a href="{{ route('aduan.index') }}" class="btn btn-outline">
                    Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>
</section>

@endsection