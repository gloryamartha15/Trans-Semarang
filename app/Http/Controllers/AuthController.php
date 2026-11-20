<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function showRegister()
    {
        return view('Auth.register');
    }

    // Memproses registrasi pengguna
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::guard('web')->login($user);

        $request->session()->regenerate();

        return redirect()->route('aduan.index')
            ->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // Menampilkan halaman login
    public function showLogin()
    {
        return view('Auth.login');
    }

    // Memproses login pengguna
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Hanya akun dengan role pengguna yang boleh login di website
        $credentials['role'] = 'pengguna';

        if (! Auth::guard('web')->attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak sesuai.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('aduan.index'));
    }

    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Mempertahankan sesi guard admin
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('aduan.index');
    }
}
