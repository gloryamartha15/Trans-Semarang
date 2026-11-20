@extends('Layout.app')

@section('title', 'Edit Profil | Trans Semarang')

@push('styles')
<style>
    .account-section {
        background: #f4f7fb;
        min-height: 75vh;
        padding: 55px 20px 80px;
    }

    .account-container {
        max-width: 650px;
        margin: auto;
    }

    .account-card {
        background: #fff;
        border: 1px solid #e9eef5;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 8px 30px rgba(20, 50, 90, .07);
    }

    .account-card h1 {
        color: #173b70;
        font-size: 27px;
        margin: 0 0 8px;
    }

    .account-description {
        color: #718096;
        margin-bottom: 28px;
    }

    .account-field {
        margin-bottom: 20px;
    }

    .account-field label {
        display: block;
        color: #315477;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .account-field input {
        box-sizing: border-box;
        width: 100%;
        padding: 13px 14px;
        border: 1px solid #dce4ee;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
    }

    .account-field input:focus {
        border-color: #1769aa;
        box-shadow: 0 0 0 3px rgba(23, 105, 170, .10);
    }

    .account-error {
        color: #dc3545;
        font-size: 13px;
        margin-top: 6px;
    }

    .account-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        flex-wrap: wrap;
    }

    .account-button {
        border: 0;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }

    .account-save {
        background: #1769aa;
        color: #fff;
    }

    .account-cancel {
        background: #edf3f9;
        color: #315477;
    }

    @media(max-width: 600px) {
        .account-card { padding: 23px 18px; }
        .account-actions { flex-direction: column; }
        .account-button { width: 100%; box-sizing: border-box; }
    }
</style>
@endpush

@section('content')
<section class="account-section">
    <div class="account-container">
        <div class="account-card">
            <h1>Edit Profil</h1>
            <p class="account-description">
                Perbarui informasi akun Trans Semarang Anda.
            </p>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="account-field">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                    >
                    @error('name')
                        <div class="account-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="account-field">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                    >
                    @error('email')
                        <div class="account-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="account-actions">
                    <button type="submit" class="account-button account-save">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('profile') }}"
                       class="account-button account-cancel">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection