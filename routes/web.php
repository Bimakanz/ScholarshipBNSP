<?php

/**
 * Web Routes Configuration
 *
 * Deskripsi: Mendefinisikan seluruh endpoint routing web untuk aplikasi pendaftaran
 *            beasiswa kampus online sesuai spesifikasi uji kompetensi BNSP.
 *
 * Author: Sena
 * Tanggal: 29 Oktober 2026
 * Versi: 1.0.0
 * Unit Kompetensi: J.620100.015.01 & J.620100.017.02
 */

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeasiswaController;
use Illuminate\Support\Facades\Route;

// Menu 1: Pilihan Beasiswa (Halaman Beranda & Katalog)
Route::get('/', [BeasiswaController::class, 'index'])->name('beasiswa.home');
Route::get('/beasiswa', [BeasiswaController::class, 'index'])->name('beasiswa.index');

// Menu 2: Daftar Beasiswa (Formulir Pendaftaran & Proses Simpan)
Route::get('/daftar', [BeasiswaController::class, 'create'])->name('beasiswa.create');
Route::post('/daftar', [BeasiswaController::class, 'store'])->name('beasiswa.store');

// Menu 3: Hasil / Pencarian Status Pendaftaran (Publik)
Route::get('/hasil', [BeasiswaController::class, 'hasil'])->name('beasiswa.hasil');
Route::get('/detail-penerimaan/{id}', [BeasiswaController::class, 'detailPenerimaan'])->name('beasiswa.detail');

// Helper Actions: Unduh Berkas Persyaratan
Route::get('/berkas/{id}/download', [BeasiswaController::class, 'downloadBerkas'])->name('beasiswa.berkas.download');

// Area Administrator: Autentikasi Login & Logout
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Area Administrator: Dashboard & Pengelolaan Data Pendaftar (Terproteksi Auth Middleware)
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard']);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/pendaftar/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.status.update');
    Route::delete('/admin/pendaftar/{id}', [AdminController::class, 'destroy'])->name('admin.pendaftar.destroy');
});
