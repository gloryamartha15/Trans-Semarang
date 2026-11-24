@extends('Layout.app')

@section('title', 'Form Pengaduan | Lapor Trans Semarang')

@section('content')

@if (session('success'))
    <div class="alert-success">
        <h3>Pengaduan Berhasil Dikirim!</h3>
        <p>{{ session('success') }}</p>
        <p>Nomor Tiket Pengaduan:</p>
        <strong id="nomorAduan">{{ session('no_aduan') }}</strong>

        <button type="button" onclick="salinNomorAduan()">
            Salin Nomor Tiket
        </button>

        <a href="{{ route('aduan.track') }}">Lacak Pengaduan</a>
    </div>
@endif

<section class="content-section" style="padding-top: 48px; padding-bottom: 72px; background: var(--cream);">
    <div class="container" style="max-width: 680px;">

        <div class="section-heading" style="margin-bottom: 32px;">
            <div class="section-kicker">FORM PENGADUAN</div>
            <h2>Sampaikan Pengaduan Anda</h2>
            <p>
                Isi formulir di bawah ini dengan jelas agar laporan dapat
                ditindaklanjuti dengan lebih cepat dan tepat.
            </p>
        </div>

        @if ($errors->any())
            <div style="background: #fff1f0; border: 1px solid #f5c6c3; color: #b42318; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px;">
                <strong>Pengaduan belum dapat dikirim.</strong>
                <p style="font-size: 13px; margin: 5px 0 0;">
                    Silakan periksa kembali bagian formulir yang masih perlu diperbaiki.
                </p>
            </div>
        @endif

        <div style="background: white; border: 1px solid var(--line); border-radius: 19px; padding: 32px 28px; box-shadow: var(--shadow);">

            <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @php
                    $penggunaLogin = Auth::guard('web')->user();
                @endphp

                {{-- Nama Pengadu --}}
                <div style="margin-bottom: 22px;">
                    <label for="nama_pengadu" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Nama Pengadu <span style="color: var(--teal);">*</span>
                    </label>

                    <input
                        type="text"
                        id="nama_pengadu"
                        name="nama_pengadu"
                        value="{{ old('nama_pengadu', $penggunaLogin?->name ?? '') }}"
                        {{ $penggunaLogin ? 'readonly' : 'required' }}
                        maxlength="50"
                        placeholder="Masukkan nama Anda"
                        class="form-input-custom @error('nama_pengadu') is-invalid @enderror"
                    >

                    @error('nama_pengadu')
                        <p class="error-message">{{ $message }}</p>
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
                        maxlength="125"
                        placeholder="Contoh: AC bus tidak dingin"
                        class="form-input-custom @error('judul') is-invalid @enderror"
                    >

                    @error('judul')
                        <p class="error-message">{{ $message }}</p>
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
                        class="form-select-custom @error('categories') is-invalid @enderror"
                    >
                        <option value="">-- Pilih Kategori --</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('categories') == $category->id)>
                                {{ $category->jenis_aduan }}
                            </option>
                        @endforeach
                    </select>

                    @error('categories')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bus dan Halte --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 8px;">

                    <div>
                        <label for="bus_id" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                            Bus (opsional)
                        </label>

                        <select
                            id="bus_id"
                            name="nama_bus"
                            class="form-select-custom @error('nama_bus') is-invalid @enderror"
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
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stop_id" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                            Halte (opsional)
                        </label>

                        <select
                            id="stop_id"
                            name="stop_id"
                            class="form-select-custom @error('stop_id') is-invalid @enderror"
                        >
                            <option value="">-- Pilih Halte --</option>

                            @foreach ($stops as $stop)
                                <option value="{{ $stop->id }}"
                                    @selected(old('stop_id', $selectedStopId) == $stop->id)>
                                    {{ $stop->name_stop }}
                                </option>
                            @endforeach
                        </select>

                        @error('stop_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <p style="font-size: 11px; color: var(--muted); margin: 8px 0 22px; line-height: 1.6;">
                    Bus dan halte dapat dipilih secara terpisah. Jika data terisi otomatis melalui QR Code, Anda tetap dapat mengubah atau mengosongkannya sesuai lokasi kejadian.
                </p>

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
                        class="form-input-custom @error('isi_aduan') is-invalid @enderror"
                        style="resize: vertical; line-height: 1.6;"
                    >{{ old('isi_aduan') }}</textarea>

                    @error('isi_aduan')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dokumentasi --}}
                <div style="margin-bottom: 28px;">
                    <label for="dokumentasi" style="display: block; font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 8px;">
                        Dokumentasi / Bukti (opsional)
                    </label>

                    <input
                        type="file"
                        id="dokumentasi"
                        name="dokumentasi"
                        accept="image/jpeg,image/png,application/pdf"
                        class="form-input-custom @error('dokumentasi') is-invalid @enderror"
                        style="border-style: dashed;"
                    >

                    <p style="font-size: 11px; color: var(--muted); margin-top: 6px;">
                        Format: JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                    </p>

                    @error('dokumentasi')
                        <p class="error-message">{{ $message }}</p>
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

<style>
    .form-input-custom,
    .form-select-custom {
        width: 100%;
        padding: 13px 16px;
        border: 1px solid var(--line);
        border-radius: 10px;
        font-size: 14px;
        color: var(--text);
        background: #fafcfb;
        outline: none;
        box-sizing: border-box;
    }

    .form-input-custom:focus,
    .form-select-custom:focus {
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(20, 145, 130, 0.10);
    }

    .is-invalid {
        border-color: #c0392b !important;
    }

    .error-message {
        color: #c0392b;
        font-size: 12px;
        margin-top: 6px;
    }

    .ts-control {
        border: 1px solid var(--line) !important;
        border-radius: 10px !important;
        padding: 12px 14px !important;
        background: #fafcfb !important;
        box-shadow: none !important;
        font-size: 14px;
        min-height: 46px;
    }

    .ts-control.focus {
        border-color: var(--teal) !important;
        box-shadow: 0 0 0 3px rgba(20, 145, 130, 0.10) !important;
    }

    .ts-dropdown {
        border-radius: 10px;
        border: 1px solid var(--line);
        overflow: hidden;
        font-size: 13px;
    }

    .ts-dropdown .active {
        background: #eaf5f2;
        color: var(--navy);
    }

    .ts-wrapper {
        width: 100%;
    }

    @media (max-width: 520px) {
        .content-section .container > div[style*="padding: 32px"] {
            padding: 24px 18px !important;
        }

        .content-section form > div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css">

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Kategori tetap dropdown biasa.
        // Bus dan Halte menggunakan dropdown yang bisa dicari.
        ['bus_id', 'stop_id'].forEach(function (id) {
            const element = document.getElementById(id);

            if (element && !element.tomselect) {
                new TomSelect(element, {
                    create: false,
                    allowEmptyOption: true,
                    maxOptions: null,
                    placeholder: 'Cari atau pilih...',
                    searchField: ['text'],
                    closeAfterSelect: true
                });
            }
        });

    });

    function salinNomorAduan() {
        const nomor = document.getElementById('nomorAduan').innerText;

        navigator.clipboard.writeText(nomor)
            .then(() => alert('Nomor tiket berhasil disalin!'));
    }
</script>

@endsection