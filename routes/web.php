<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\PeminjamanRuangController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController; // Tambahkan ini di deretan "use" paling atas

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/riwayat', [DashboardController::class, 'riwayatAdmin'])->name('riwayat');

        Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::resource('barang', BarangController::class);
        Route::resource('ruang', RuangController::class);
    });

    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'mahasiswa'])->name('dashboard');
        Route::get('/riwayat', [DashboardController::class, 'riwayatMahasiswa'])->name('riwayatMahasiswa');

        Route::get('/katalog-ruangan', [RuangController::class, 'index'])->name('ruang.index');
        Route::get('/pinjam-ruang', [PeminjamanRuangController::class, 'create'])->name('peminjaman.create');
        Route::post('/pinjam-ruang', [PeminjamanRuangController::class, 'store'])->name('peminjaman.store');

        Route::get('/katalog-barang', [BarangController::class, 'katalogMahasiswa'])->name('barang.index');
        Route::get('/pinjam-barang', [PeminjamanBarangController::class, 'create'])->name('barang.create');
        Route::post('/pinjam-barang', [PeminjamanBarangController::class, 'store'])->name('barang.store');
    });

    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dosen'])->name('dashboard');
        Route::get('/riwayat', [DashboardController::class, 'riwayatDosen'])->name('riwayat');

        Route::get('/persetujuan-ruang', [PeminjamanRuangController::class, 'index'])->name('peminjaman.index');
        Route::patch('/persetujuan-ruang/{id}/status', [PeminjamanRuangController::class, 'updateStatus'])->name('peminjaman.updateStatus');

        Route::get('/persetujuan-barang', [PeminjamanBarangController::class, 'index'])->name('peminjaman_barang.index');
        Route::patch('/persetujuan-barang/{id}/status', [PeminjamanBarangController::class, 'updateStatus'])->name('peminjaman_barang.updateStatus');
    });
});