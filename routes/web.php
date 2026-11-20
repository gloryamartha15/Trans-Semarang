<?php

use App\Http\Controllers\AduanController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('aduan.index');
});

// Autentikasi pengguna publik
Route::middleware('guest:web')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:web')
    ->name('logout');

Route::get('/riwayat-aduan', [AduanController::class, 'history'])
    ->middleware('auth:web')
    ->name('aduan.history');

// Lacak pengaduan
Route::get('/lacak-aduan', [AduanController::class, 'track'])
    ->name('aduan.track');

// Halaman sukses pengaduan
Route::get('/konfirmasi-pengaduan', function () {
    return view('Aduan.success');
})->name('aduan.success');

// Scan QR Code
Route::get('/scan-qr', function () {
    return view('QR.scan');
})->name('qr.scan');

// Pengaduan
Route::resource('aduan', AduanController::class);

// Profil pengguna
Route::get('/profil', function () {
    return view('Auth.profile');
})
->middleware('auth:web')
->name('profile');

Route::middleware('auth:web')->group(function () {
    Route::get('/profil', function () {
        return view('Auth.profile');
    })->name('profile');

    Route::get('/profil/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/profil/ganti-password', [ProfileController::class, 'editPassword'])
        ->name('profile.password.edit');

    Route::put('/profil/ganti-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});