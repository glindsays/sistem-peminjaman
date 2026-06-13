<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Route::get('/mahasiswa/dashboard', function () {
//     return view('/mahasiswa/dashboard');
// })->name('mahasiswa.dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::resource('barang', BarangController::class);
        Route::resource('ruang', RuangController::class);
    });

    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', function () { return view('mahasiswa.dashboard'); })->name('mahasiswa.dashboard');
    });

    Route::middleware('role:dosen')->prefix('dosen')->group(function () {
        Route::get('/dashboard', function () { return view('dosen.dashboard'); })->name('dosen.dashboard');
    });
});