@extends('Layout.app')

@section('title', 'Login | Trans Semarang')

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

.auth-remember {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    color: #475569;
    font-size: 14px;
}
</style>

<section class="auth-section">
    <div class="auth-card">

        <h1>Selamat Datang!</h1>

        <p class="auth-description">
            Login untuk mengirim dan memantau pengaduan layanan Trans Semarang.
        </p>

        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

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
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <label class="auth-remember">
                <input type="checkbox" name="remember" value="1">
                Ingat saya
            </label>

            <button type="submit" class="auth-button">
                Login
            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

<div>
<a href="{{ route('google.redirect') }}"
   style="
       display: flex;
       width: 100%;
       box-sizing: border-box;
       align-items: center;
       justify-content: center;
       gap: 10px;
       padding: 14px 16px;
       margin-top: 16px;
       border: 1px solid #d1d5db;
       border-radius: 10px;
       background-color: #ffffff;
       color: #374151;
       font-size: 14px;
       font-weight: 600;
       text-decoration: none;
       text-align: center;
       cursor: pointer;
   ">

    <svg width="20" height="20" viewBox="0 0 48 48" style="flex-shrink: 0;">
        <path fill="#4285F4" d="M43.6 24.5c0-1.4-.1-2.8-.4-4.1H24v7.8h11a9.4 9.4 0 0 1-4.1 6.2v5h6.6c3.9-3.6 6.1-8.8 6.1-14.9Z"/>
        <path fill="#34A853" d="M24 44c5.5 0 10.1-1.8 13.5-4.9l-6.6-5c-1.8 1.2-4 2-6.9 2-5.3 0-9.8-3.6-11.4-8.4H5.8v5.1A20 20 0 0 0 24 44Z"/>
        <path fill="#FBBC05" d="M12.6 27.7a12 12 0 0 1 0-7.4v-5.1H5.8a20 20 0 0 0 0 17.6l6.8-5.1Z"/>
        <path fill="#EA4335" d="M24 12.1c3 0 5.7 1 7.8 3.1l5.8-5.8C34.1 6 29.5 4 24 4A20 20 0 0 0 5.8 15.2l6.8 5.1c1.6-4.8 6.1-8.2 11.4-8.2Z"/>
    </svg>

    <span>Continue with Google</span>
</a>
    </div>

    </div>
</section>

@endsection
