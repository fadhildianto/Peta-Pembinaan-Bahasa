<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\LokasiController;

Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kegiatan', KegiatanController::class);
    Route::resource('lokasi', LokasiController::class);
});

