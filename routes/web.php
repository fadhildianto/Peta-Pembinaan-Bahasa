<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\Admin\PetaController;

Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('peserta', PesertaController::class);
    Route::resource('arsip', ArsipController::class);

    // Peta
    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
    Route::get('/peta/{lokasi}', [PetaController::class, 'show'])->name('peta.show');

    // API Endpoints untuk Peta
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/map-data', [PetaController::class, 'getMapData'])->name('map-data');
        Route::get('/kegiatan-by-lokasi/{lokasiId}', [PetaController::class, 'getKegiatanByLokasi'])->name('kegiatan-by-lokasi');
    });
});

