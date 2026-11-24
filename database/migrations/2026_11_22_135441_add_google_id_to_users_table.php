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

            // Hanya menerima email yang sudah diverifikasi Google.
            if (
                empty($google->getEmail()) ||
                ! ($google->user['email_verified'] ?? false)
            ) {
                return redirect('/admin/login')
                    ->withErrors([
                        'email' => 'Email Google belum terverifikasi.',
                    ]);
            }

            $user = User::where(
                'google_id',
                $google->getId()
            )->first();

            if (! $user) {
                $user = User::where(
                    'email',
                    $google->getEmail()
                )->first();

                // Jangan otomatis menghubungkan akun lokal
                // yang emailnya belum terverifikasi.
                if ($user && ! $user->hasVerifiedEmail()) {
                    return redirect('/admin/login')
                        ->withErrors([
                            'email' => 'Silakan verifikasi email akun terlebih dahulu.',
                        ]);
                }

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
                } else {
                    $user->update([
                        'google_id' => $google->getId(),
                    ]);
                }
            }

            Auth::login($user);

            request()->session()->regenerate();

            return redirect('/admin');
        } catch (Throwable $e) {
            report($e);

            return redirect('/admin/login')
                ->withErrors([
                    'email' => 'Login Google gagal. Silakan coba kembali.',
                ]);
        }
    }
}
