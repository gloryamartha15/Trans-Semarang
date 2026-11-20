@extends('Layout.app')

@section('title', 'Profil Pengguna | Trans Semarang')

@push('styles')
<style>
    .profile-section {
        padding: 55px 20px 80px;
        background: #f4f7fb;
        min-height: 75vh;
    }

    .profile-container {
        max-width: 1000px;
        margin: auto;
    }

    .profile-heading {
        margin-bottom: 30px;
    }

    .profile-heading h1 {
        font-size: 30px;
        color: #173b70;
        margin-bottom: 8px;
    }

    .profile-heading p {
        color: #718096;
        margin: 0;
    }

    .profile-card {
        background: #fff;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 8px 30px rgba(20, 50, 90, .07);
        border: 1px solid #e9eef5;
    }

    .profile-top {
        display: flex;
        align-items: center;
        gap: 22px;
        padding-bottom: 28px;
        border-bottom: 1px solid #edf1f6;
    }

    .profile-avatar {
        width: 86px;
        height: 86px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1769aa, #42a5e8);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .profile-identity h2 {
        color: #183b68;
        font-size: 23px;
        margin: 0 0 7px;
    }

    .profile-identity p {
        color: #7b8798;
        margin: 0 0 10px;
    }

    .profile-role {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        background: #e8f3ff;
        color: #1769aa;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .profile-info-title {
        color: #183b68;
        font-size: 17px;
        margin: 28px 0 18px;
    }

    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .profile-info-item {
        padding: 17px;
        background: #f7f9fc;
        border-radius: 12px;
    }

    .profile-info-item span {
        display: block;
        color: #8793a4;
        font-size: 13px;
        margin-bottom: 7px;
    }

    .profile-info-item strong {
        color: #263b55;
        font-size: 15px;
        overflow-wrap: anywhere;
    }

    .profile-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #edf1f6;
    }

    .profile-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 19px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: .2s;
    }

    .profile-action-primary {
        background: #1769aa;
        color: #fff;
    }

    .profile-action-primary:hover {
        background: #12558c;
        color: #fff;
    }

    .profile-action-secondary {
        background: #edf3f9;
        color: #315477;
    }

    .profile-action-secondary:hover {
        background: #dfeaf5;
        color: #183b68;
    }

    @media (max-width: 600px) {
        .profile-section {
            padding: 35px 15px 55px;
        }

        .profile-card {
            padding: 22px 18px;
        }

        .profile-top {
            align-items: flex-start;
            gap: 15px;
        }

        .profile-avatar {
            width: 65px;
            height: 65px;
            font-size: 25px;
        }

        .profile-identity h2 {
            font-size: 19px;
        }

        .profile-info-grid {
            grid-template-columns: 1fr;
        }

        .profile-heading h1 {
            font-size: 25px;
        }

        .profile-actions {
            flex-direction: column;
        }

        .profile-action {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>
@endpush

@section('content')
@php
    $user = auth('web')->user();
    $initial = strtoupper(substr($user->name, 0, 1));
@endphp

<section class="profile-section">
    <div class="profile-container">

        <div class="profile-heading">
            <h1>Profil Saya</h1>
            <p>Kelola informasi akun Trans Semarang Anda.</p>
        </div>

        <div class="profile-card">
            @if (session('success'))
                <div style="background:#e8f7ee; color:#247747; padding:13px 16px; border-radius:10px; margin-bottom:20px;">
                    {{ session('success') }}
                </div>
            @endif
            <div class="profile-top">
                <div class="profile-avatar">
                    {{ $initial }}
                </div>

                <div class="profile-identity">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                    <span class="profile-role">{{ $user->role }}</span>
                </div>
            </div>

            <h3 class="profile-info-title">Informasi Akun</h3>

            <div class="profile-info-grid">
                <div class="profile-info-item">
                    <span>Nama Lengkap</span>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="profile-info-item">
                    <span>Alamat Email</span>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="profile-info-item">
                    <span>Jenis Akun</span>
                    <strong>{{ ucfirst($user->role) }}</strong>
                </div>

                <div class="profile-info-item">
                    <span>Bergabung Sejak</span>
                    <strong>{{ $user->created_at?->format('d F Y') ?? '-' }}</strong>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}"
                class="profile-action profile-action-primary">
                    ✏️ Edit Profil
                </a>

                <a href="{{ route('profile.password.edit') }}"
                class="profile-action profile-action-secondary">
                    🔒 Ganti Password
                </a>
                <form action="{{ route('logout') }}" method="POST"
                    onsubmit="return confirm('Apakah kamu yakin ingin keluar?')">
                    @csrf
                    <button type="submit" class="profile-action"
                            style="background:#fff0f0; color:#dc3545; border:0; cursor:pointer;">
                        ↪ Keluar
                    </button>
                </form>
            </div>
            </div>

        </div>
    </div>
</section>
@endsection
