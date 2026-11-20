@extends('Layout.app')

@section('title', 'Daftar Akun | Trans Semarang')

@section('content')

<style>
.auth-section {
    min-height: 75vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 50px 20px;
    background: #f5f8fc;
}

.auth-card {
    width: 100%;
    max-width: 460px;
    background: white;
    padding: 38px;
    border-radius: 18px;
    box-shadow: 0 8px 30px rgba(0,0,0,.07);
}

.auth-card h1 {
    font-size: 27px;
    color: #173b68;
    margin-bottom: 8px;
}

.auth-description {
    color: #718096;
    margin-bottom: 28px;
}

.auth-group {
    margin-bottom: 18px;
}

.auth-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #334155;
}

.auth-group input {
    width: 100%;
    padding: 13px 14px;
    border: 1px solid #dbe3ed;
    border-radius: 9px;
    font-size: 15px;
    outline: none;
}

.auth-group input:focus {
    border-color: #2563eb;
}

.auth-button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 9px;
    background: #174a80;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
}

.auth-button:hover {
    background: #10375f;
}

.auth-footer {
    text-align: center;
    margin-top: 22px;
    color: #64748b;
}

.auth-footer a {
    color: #174a80;
    font-weight: 600;
    text-decoration: none;
}

.auth-error {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

</style>

<section class="auth-section">
    <div class="auth-card">

        <h1>Buat Akun</h1>

        <p class="auth-description">
            Daftar untuk mengirim dan memantau pengaduan layanan Trans Semarang.
        </p>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="auth-group">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >
                @error('name')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                >
                @error('email')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                >
                @error('password')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                >
            </div>

            <button type="submit" class="auth-button">
                Daftar Sekarang
            </button>

        </form>

        <div class="auth-footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>

    </div>
</section>

@endsection
