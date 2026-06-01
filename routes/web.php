<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\GenerasiController;

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

// ── ADMIN ────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Presensi
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap'])->name('presensi.rekap');

    // Kas
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::get('/kas/create', [KasController::class, 'create'])->name('kas.create');
    Route::post('/kas', [KasController::class, 'store'])->name('kas.store');
    Route::get('/kas/rekap/semua', [KasController::class, 'rekap'])->name('kas.rekap');
    Route::get('/kas/{kas}', [KasController::class, 'show'])->name('kas.show');
    Route::post('/kas/pembayaran/{pembayaran}/lunas', [KasController::class, 'tandaiLunas'])->name('kas.lunas');
    Route::post('/kas/pembayaran/{pembayaran}/batal', [KasController::class, 'batalLunas'])->name('kas.batal');

    // Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/siswa', [AnggotaController::class, 'siswa'])->name('anggota.siswa');
    Route::get('/anggota/siswa/create', [AnggotaController::class, 'createSiswa'])->name('anggota.siswa.create');
    Route::post('/anggota/siswa', [AnggotaController::class, 'storeSiswa'])->name('anggota.siswa.store');
    Route::get('/anggota/siswa/{user}', [AnggotaController::class, 'detailSiswa'])->name('anggota.siswa.show');
    Route::get('/anggota/siswa/{user}/edit', [AnggotaController::class, 'editSiswa'])->name('anggota.siswa.edit');
    Route::put('/anggota/siswa/{user}', [AnggotaController::class, 'updateSiswa'])->name('anggota.siswa.update');
    Route::post('/anggota/siswa/{user}/nonaktif', [AnggotaController::class, 'nonaktifkanSiswa'])->name('anggota.siswa.nonaktif');
    Route::get('/anggota/warga', [AnggotaController::class, 'warga'])->name('anggota.warga');
    Route::get('/anggota/warga/create', [AnggotaController::class, 'createWarga'])->name('anggota.warga.create');
    Route::post('/anggota/warga', [AnggotaController::class, 'storeWarga'])->name('anggota.warga.store');

    // Generasi (admin bisa CRUD)
    Route::get('/generasi/create', [GenerasiController::class, 'create'])->name('generasi.create');
    Route::post('/generasi', [GenerasiController::class, 'store'])->name('generasi.store');
    Route::get('/generasi/{generasi}/edit', [GenerasiController::class, 'edit'])->name('generasi.edit');
    Route::put('/generasi/{generasi}', [GenerasiController::class, 'update'])->name('generasi.update');
    Route::delete('/generasi/{generasi}', [GenerasiController::class, 'destroy'])->name('generasi.destroy');
});

// ── WARGA ────────────────────────────────────────────────
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'warga'])->name('dashboard');

    // Presensi
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap'])->name('presensi.rekap');

    // Kas
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    Route::get('/kas/{kas}', [KasController::class, 'show'])->name('kas.show');
    Route::post('/kas/pembayaran/{pembayaran}/lunas', [KasController::class, 'tandaiLunas'])->name('kas.lunas');
    Route::post('/kas/pembayaran/{pembayaran}/batal', [KasController::class, 'batalLunas'])->name('kas.batal');
    Route::get('/kas/rekap/semua', [KasController::class, 'rekap'])->name('kas.rekap');
});

// ── SISWA ────────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');

    // Presensi
    Route::get('/presensi/riwayat', [PresensiController::class, 'riwayat'])->name('presensi.riwayat');

    // Kas
    Route::get('/kas', [KasController::class, 'kasSiswa'])->name('kas.index');
});

// ── GENERASI (semua role bisa lihat) ─────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/generasi', [GenerasiController::class, 'index'])->name('generasi.index');
});

// ── PROFILE ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';