
@extends('layout.app')

@section('title', 'Scan QR Code | Trans Semarang')

@section('content')

<section class="content-section" style="padding: 50px 20px;">
    <div class="container" style="max-width: 650px; margin: auto; text-align: center;">

        <div class="section-kicker">SCAN QR CODE</div>
        <h2>Identifikasi Bus atau Halte</h2>

        <p style="margin: 15px 0 25px; color: #64748b;">
            Arahkan kamera ke QR Code yang tersedia pada bus atau halte Trans Semarang.
        </p>

        <div id="reader" style="width: 100%; margin: auto;"></div>

        <div style="margin-top: 20px;">
            <button type="button" id="start-scan" class="btn btn-primary">
                Aktifkan Kamera
            </button>

            <button type="button" id="stop-scan" class="btn btn-outline" disabled>
                Berhenti
            </button>
        </div>

        <p id="scan-message" style="margin-top: 20px;">
            Tekan tombol Mulai Scan untuk mengaktifkan kamera.
        </p>

        <a href="{{ route('aduan.index') }}" class="btn btn-outline"
           style="margin-top: 15px;">
            Kembali ke Beranda
        </a>

    </div>
</section>
<br><br><br><br><br><br><br>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const scanner = new Html5Qrcode("reader");

    const startButton = document.getElementById('start-scan');
    const stopButton = document.getElementById('stop-scan');
    const message = document.getElementById('scan-message');

    let scanning = false;

    async function startScanner() {

        if (scanning) return;

        try {
            message.textContent = 'Meminta izin kamera...';

            await scanner.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },

                async function (decodedText) {

                    message.textContent = 'QR Code berhasil terbaca!';

                    await stopScanner();

                    window.location.href = decodedText;
                }
            );

            scanning = true;

            startButton.disabled = true;
            stopButton.disabled = false;

            message.textContent = 'Kamera aktif. Arahkan ke QR Code.';

        } catch (error) {

            message.textContent =
                'Kamera belum aktif. Tekan Aktifkan Kamera dan izinkan akses kamera.';

            console.error('Kesalahan kamera:', error);
        }
    }

    async function stopScanner() {

        if (!scanning) return;

        try {

            await scanner.stop();

            scanning = false;

            startButton.disabled = false;
            stopButton.disabled = true;

        } catch (error) {

            console.error('Gagal menghentikan kamera:', error);
        }
    }

    startButton.addEventListener('click', startScanner);

    stopButton.addEventListener('click', async function () {

        await stopScanner();

        message.textContent = 'Pemindaian dihentikan.';
    });

    // Mencoba mengaktifkan kamera otomatis.
    startScanner();

});
</script>

@endpush
