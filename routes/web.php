<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanBarangController;
use App\Http\Controllers\PeminjamanRuangController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

        Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::resource('barang', BarangController::class);
        Route::resource('ruang', RuangController::class);
    });

    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', function () { return view('mahasiswa.dashboard'); })->name('dashboard');

        Route::get('/pinjam-ruang', [PeminjamanRuangController::class, 'create'])->name('peminjaman.create');
        Route::post('/pinjam-ruang', [PeminjamanRuangController::class, 'store'])->name('peminjaman.store');
        Route::get('/history-ruang', [PeminjamanRuangController::class, 'historyMahasiswa'])->name('peminjaman.history');

        Route::get('/pinjam-barang', [PeminjamanBarangController::class, 'create'])->name('peminjaman_barang.create');
        Route::post('/pinjam-barang', [PeminjamanBarangController::class, 'store'])->name('peminjaman_barang.store');
        Route::get('/history-barang', [PeminjamanBarangController::class, 'historyMahasiswa'])->name('peminjaman_barang.history');
    });

    Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', function () { return view('dosen.dashboard'); })->name('dashboard');

        Route::get('/persetujuan-ruang', [PeminjamanRuangController::class, 'index'])->name('peminjaman.index');
        Route::patch('/persetujuan-ruang/{id}/status', [PeminjamanRuangController::class, 'updateStatus'])->name('peminjaman.updateStatus');

        Route::get('/persetujuan-barang', [PeminjamanBarangController::class, 'index'])->name('peminjaman_barang.index');
        Route::patch('/persetujuan-barang/{id}/status', [PeminjamanBarangController::class, 'updateStatus'])->name('peminjaman_barang.updateStatus');
    });
});