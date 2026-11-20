
@extends('Layout.app')

@section('title', 'Pengaduan Berhasil | Lapor Trans Semarang')

@section('content')
<section class="success-section">
    <div class="success-card">
        <div class="success-icon">✓</div>

        <h1>Pengaduan Berhasil Dikirim!</h1>

        <p>
            Terima kasih telah menyampaikan pengaduan.
            Laporan Anda telah kami terima dan akan diproses
            oleh petugas.
        </p>

        <div class="ticket-box">
            <span>NOMOR TIKET PENGADUAN</span>

            <strong id="nomorAduan">
                {{ session('no_aduan', '-') }}
            </strong>

            <button type="button" onclick="salinNomorAduan()">
                Salin Nomor Tiket
            </button>
        </div>

        <p class="ticket-note">
            Simpan nomor tiket ini untuk memantau perkembangan
            pengaduan Anda.
        </p>

        <a href="{{ route('aduan.track') }}" class="btn btn-primary">
            Lacak Pengaduan
        </a>

        <a href="{{ route('aduan.index') }}" class="back-link">
            Kembali ke Beranda
        </a>
    </div>
</section>

<style>
.success-section {
    min-height: 75vh;
    display: grid;
    place-items: center;
    padding: 55px 20px;
    background: #f6faf8;
}

.success-card {
    width: 100%;
    max-width: 540px;
    padding: 42px 35px;
    text-align: center;
    background: white;
    border: 1px solid #e5ecea;
    border-radius: 22px;
    box-shadow: 0 14px 40px rgba(16,45,58,.07);
}

.success-icon {
    width: 66px;
    height: 66px;
    margin: 0 auto 22px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: #e6f5f1;
    color: #078b80;
    font-size: 35px;
    font-weight: bold;
}

.success-card h1 {
    color: #102d3a;
    font-size: 25px;
    margin-bottom: 12px;
}

.success-card > p {
    color: #73838a;
    font-size: 13px;
    line-height: 1.8;
}

.ticket-box {
    margin: 27px 0 15px;
    padding: 23px 15px;
    background: #f3f9f7;
    border: 1px dashed #078b80;
    border-radius: 14px;
}

.ticket-box span {
    display: block;
    color: #73838a;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.2px;
    margin-bottom: 10px;
}

.ticket-box strong {
    display: block;
    color: #078b80;
    font-size: clamp(18px, 4vw, 24px);
    margin-bottom: 16px;
    overflow-wrap: anywhere;
}

.ticket-box button {
    padding: 9px 16px;
    border: 0;
    border-radius: 8px;
    background: #e0efeb;
    color: #06746b;
    font-weight: 700;
    cursor: pointer;
}

.ticket-note {
    margin-bottom: 23px;
}

.success-card .btn {
    width: 100%;
}

.back-link {
    display: block;
    margin-top: 17px;
    color: #078b80;
    font-size: 13px;
    font-weight: 600;
}

@media(max-width: 500px) {
    .success-card {
        padding: 32px 20px;
    }
}
</style>

<script>
function salinNomorAduan() {
    const nomor = document.getElementById('nomorAduan').innerText.trim();

    navigator.clipboard.writeText(nomor)
        .then(() => alert('Nomor tiket berhasil disalin!'))
        .catch(() => alert('Gagal menyalin nomor tiket.'));
}
</script>
@endsection
