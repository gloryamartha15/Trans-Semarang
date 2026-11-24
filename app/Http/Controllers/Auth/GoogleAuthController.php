<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $google = Socialite::driver('google')->user();

            // Pastikan email Google tersedia dan terverifikasi
            if (
                empty($google->getEmail()) ||
                ! ($google->user['email_verified'] ?? false)
            ) {
                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Email Google belum terverifikasi.',
                    ]);
            }

            // Cari akun berdasarkan Google ID
            $user = User::where('google_id', $google->getId())
                ->first();

            // Jika belum ditemukan, cari berdasarkan email
            if (! $user) {
                $user = User::where('email', $google->getEmail())
                    ->first();

                // Jangan menghubungkan akun lokal yang belum terverifikasi
                if ($user && ! $user->hasVerifiedEmail()) {
                    return redirect()->route('login')
                        ->withErrors([
                            'email' => 'Silakan verifikasi email akun terlebih dahulu.',
                        ]);
                }

                // Buat akun baru jika belum terdaftar
                if (! $user) {
                    $user = User::create([
                        'name' => $google->getName()
                            ?? $google->getNickname()
                            ?? 'Google User',
                        'email' => $google->getEmail(),
                        'google_id' => $google->getId(),
                        'password' => Hash::make(Str::random(40)),
                        'email_verified_at' => now(),
                    ]);

                    // Akun Google baru otomatis menjadi pengguna
                    $user->assignRole('pengguna');
                } else {
                    // Hubungkan Google ID dengan akun yang sudah ada
                    $user->update([
                        'google_id' => $google->getId(),
                    ]);
                }
            }

            // Hanya role pengguna yang boleh masuk ke portal aduan
            if (! $user->hasRole('pengguna')) {
                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Akun ini tidak memiliki akses ke portal pengguna.',
                    ]);
            }

            // Login menggunakan guard web
            Auth::guard('web')->login($user);

            request()->session()->regenerate();

            return redirect()->route('aduan.index')
                ->with('success', 'Login Google berhasil! Selamat datang.');

        } catch (Throwable $e) {
            report($e);

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Login Google gagal. Silakan coba kembali.',
                ]);
        }
    }
}
