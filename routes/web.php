<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\Admin\PetaController;
use App\Http\Controllers\PetaPublicController;

Route::get('/', function () {
    return redirect('/peta');
});

// PUBLIC FRONTEND - Peta Interaktif (tanpa middleware)
Route::get('/peta', [PetaPublicController::class, 'index'])->name('peta.index');
Route::get('/peta/{lokasi}', [PetaPublicController::class, 'show'])->name('peta.show');

// API untuk Peta (bisa diakses dari publik & admin)
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/map-data', [PetaController::class, 'getMapData'])->name('map-data');
    Route::get('/kegiatan-by-lokasi/{lokasiId}', [PetaController::class, 'getKegiatanByLokasi'])->name('kegiatan-by-lokasi');
});

require __DIR__.'/auth.php';

// ADMIN PANEL - Backend (protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('peserta', PesertaController::class);
    Route::resource('arsip', ArsipController::class);

    // Admin Peta (tetap ada)
    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
    Route::get('/peta/{lokasi}', [PetaController::class, 'show'])->name('peta.show');

    // API Endpoints untuk Admin (mirror dari publik)
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/map-data', [PetaController::class, 'getMapData'])->name('map-data');
        Route::get('/kegiatan-by-lokasi/{lokasiId}', [PetaController::class, 'getKegiatanByLokasi'])->name('kegiatan-by-lokasi');
    });
});

