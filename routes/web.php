<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\Admin\PetaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetaPublicController;

Route::get('/', [PetaPublicController::class, 'index'])->name('home');

// PUBLIC FRONTEND - Peta Interaktif (tanpa middleware)
Route::get('/peta', [PetaPublicController::class, 'index'])->name('peta.index');
Route::get('/peta/lokasi/{lokasi}', [PetaPublicController::class, 'show'])->name('peta.detail');

// API untuk Peta (bisa diakses dari publik & admin)
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/map-data', [PetaController::class, 'getMapData'])->name('map-data');
    Route::get('/kegiatan-by-lokasi/{lokasiId}', [PetaController::class, 'getKegiatanByLokasi'])->name('kegiatan-by-lokasi');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('peta.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ADMIN PANEL - Backend (protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('lokasi', LokasiController::class)->except(['show']);
    Route::resource('peserta', PesertaController::class)
        ->parameters(['peserta' => 'peserta'])
        ->except(['show']);
    Route::resource('arsip', ArsipController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    // Admin Peta (tetap ada)
    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
    Route::get('/peta/{lokasi}', [PetaController::class, 'show'])->name('peta.show');

    // API Endpoints untuk Admin (mirror dari publik)
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/map-data', [PetaController::class, 'getMapData'])->name('map-data');
        Route::get('/kegiatan-by-lokasi/{lokasiId}', [PetaController::class, 'getKegiatanByLokasi'])->name('kegiatan-by-lokasi');
    });
});
