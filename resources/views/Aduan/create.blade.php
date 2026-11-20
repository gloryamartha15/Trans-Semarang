@extends('layout.app')

@section('title', 'Form Pengaduan | Lapor Trans Semarang')

@section('content')

@if (session('success'))
    <div class="alert-success">
        <h3>Pengaduan Berhasil Dikirim!</h3>

        <p>{{ session('success') }}</p>

        <p>Nomor Tiket Pengaduan:</p>

        <strong id="nomorAduan">
            {{ session('no_aduan') }}
        </strong>

        <button type="button" onclick="salinNomorAduan()">
            Salin Nomor Tiket
        </button>

        <a href="{{ route('aduan.track') }}">
            Lacak Pengaduan
        </a>
    </div>
@endif

<section class="content-section" style="padding-top: 48px; padding-bottom: 72px; background: var(--cream);">
    <div class="container" style="max-width: 680px;">

        {{-- Heading --}}
        <div class="section-heading" style="margin-bottom: 32px;">
            <div class="section-kicker">FORM PENGADUAN</div>
            <h2>Sampaikan Pengaduan Anda</h2>
            <p>
                Isi formulir di bawah ini dengan jelas agar laporan dapat
                ditindaklanjuti dengan lebih cepat dan tepat.
            </p>
        </div>

        {{-- Form Card --}}
        <div style="background: white; border: 1px solid var(--line); border-radius: 19px; padding: 32px 28px; box-shadow: var(--shadow);">

            <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Pengadu --}}
                <div style="margin-bottom: 22px;">
                    <label for="nama_pengadu" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Nama Pengadu
                    </label>
                    @php
                    $penggunaLogin = Auth::guard('web')->user();
                    @endphp
                    <input
                        type="text"
                        id="nama_pengadu"
                        name="nama_pengadu"
                        value="{{ old('nama_pengadu', $penggunaLogin?->name ?? '') }}"
                        {{ $penggunaLogin ? 'readonly' : '' }}
                        required
                        placeholder="Masukkan nama Anda"
                        style="width: 100%; padding: 13px 16px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; color: var(--text); background: #fafcfb; outline: none;"
                    >
                    @error('nama_pengadu')
                        <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Judul --}}
                <div style="margin-bottom: 22px;">
                    <label for="judul" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Judul Pengaduan <span style="color: var(--teal);">*</span>
                    </label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        value="{{ old('judul') }}"
                        required
                        placeholder="Contoh: AC bus tidak dingin"
                        style="width: 100%; padding: 13px 16px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; color: var(--text); background: #fafcfb; outline: none;"
                    >
                    @error('judul')
                        <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div style="margin-bottom: 22px;">
                    <label for="categories_id" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Kategori Pengaduan <span style="color: var(--teal);">*</span>
                    </label>
                    <select
                        id="categories_id"
                        name="categories"
                        required
                        style="width: 100%; padding: 13px 16px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; color: var(--text); background: #fafcfb; outline: none;"
                    >
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('categories') == $category->id)>
                                {{ $category->jenis_aduan }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bus & Halte (opsional) --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 22px;">
                    <div>
                        <label for="bus_id" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                            Bus (opsional)
                        </label>
                        <select
                            id="bus_id"
                            name="nama_bus"
                            style="width: 100%; padding: 13px 16px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; color: var(--text); background: #fafcfb; outline: none;"
                        >
                            <option value="">-- Pilih Bus --</option>                         
                            @foreach ($buses as $bus)
                                <option value="{{ $bus->id }}"
                                @selected(old('nama_bus', $selectedBusId) == $bus->id)>
                                     {{ $bus->bus_number ?? $bus->police_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_bus')
                            <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stop_id" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                            Halte (opsional)
                        </label>
                        <select
                            id="stop_id"
                            name="stops"
                            style="width: 100%; padding: 13px 16px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; color: var(--text); background: #fafcfb; outline: none;"
                        >
                            <option value="">-- Pilih Halte --</option>                          
                            @foreach ($stops as $stop)
                                <option value="{{ $stop->id }}"
                                @selected(old('stops', $selectedStopId) == $stop->id)>
                                    {{ $stop->name_stop }}
                                </option>
                            @endforeach
                        </select>
                        @error('stops')
                            <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Isi Aduan --}}
                <div style="margin-bottom: 22px;">
                    <label for="isi_aduan" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Isi Pengaduan <span style="color: var(--teal);">*</span>
                    </label>
                    <textarea
                        id="isi_aduan"
                        name="isi_aduan"
                        rows="6"
                        required
                        placeholder="Jelaskan kejadian secara jelas: waktu, lokasi, dan kendala yang dialami..."
                        style="width: 100%; padding: 13px 16px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; color: var(--text); background: #fafcfb; outline: none; resize: vertical; line-height: 1.6;"
                    >{{ old('isi_aduan') }}</textarea>
                    @error('isi_aduan')
                        <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokumentasi (foto/bukti) --}}
                <div style="margin-bottom: 28px;">
                    <label for="dokumentasi" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Dokumentasi / Bukti (opsional)
                    </label>
                    <input
                        type="file"
                        id="dokumentasi"
                        name="dokumentasi"
                        accept="image/*,.pdf"
                        style="width: 100%; padding: 12px 14px; border: 1px dashed var(--line); border-radius: 10px; font-size: 13px; color: var(--muted); background: #fafcfb;"
                    >
                    <p style="font-size: 11px; color: var(--muted); margin-top: 6px;">
                        Format: JPG, PNG, atau PDF. Maksimal 2 MB.
                    </p>
                    @error('dokumentasi')
                        <p style="color: #c0392b; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; min-width: 160px;">
                        Kirim Pengaduan
                        <span aria-hidden="true">→</span>
                    </button>

                    <a href="{{ url('/') }}" class="btn btn-outline" style="flex: 0 0 auto;">
                        Kembali
                    </a>
                </div>

            </form>
        </div>

        <p style="text-align: center; font-size: 12px; color: var(--muted); margin-top: 20px; line-height: 1.7;">
            Laporan Anda akan ditinjau oleh petugas. Mohon sampaikan informasi
            yang akurat dan bertanggung jawab.
        </p>

    </div>
</section>

<script>
function salinNomorAduan() {
    const nomor = document.getElementById('nomorAduan').innerText;

    navigator.clipboard.writeText(nomor)
        .then(() => alert('Nomor tiket berhasil disalin!'));
}
</script>

@endsection