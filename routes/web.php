<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\AnggotaController;

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
    Route::get('/kas/{kas}', [KasController::class, 'show'])->name('kas.show');
    Route::post('/kas/pembayaran/{pembayaran}/lunas', [KasController::class, 'tandaiLunas'])->name('kas.lunas');
    Route::post('/kas/pembayaran/{pembayaran}/batal', [KasController::class, 'batalLunas'])->name('kas.batal');
    Route::get('/kas/rekap/semua', [KasController::class, 'rekap'])->name('kas.rekap');

    // Anggota
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
});

// ── WARGA ────────────────────────────────────────────────
Route::middleware(['auth', 'role:warga'])->prefix('warga')->name('warga.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'warga'])->name('dashboard');

    // Presensi
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap'])->name('presensi.rekap');

    // Kas (warga bisa tandai lunas & lihat rekap, tidak bisa buat tagihan)
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

// ── PROFILE ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';