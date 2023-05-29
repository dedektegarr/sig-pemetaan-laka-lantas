<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecelakaanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PetaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/process', [AuthController::class, 'loginProcess'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::prefix('administrator')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

        Route::prefix('data')->group(function () {
            // LOKASI
            Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
            Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
            Route::get('/lokasi/{lokasi:nama_jalan}/detail', [LokasiController::class, 'show'])->name('lokasi.show');
            Route::get('/lokasi/export', [LokasiController::class, 'export'])->name('lokasi.export');

            // KECELAKAAN
            Route::get('/kecelakaan', [KecelakaanController::class, 'index'])->name('kecelakaan.index');
            Route::get('/kecelakaan/tambah', [KecelakaanController::class, 'create'])->name('kecelakaan.create');
            Route::post('/kecelakaan/store', [KecelakaanController::class, 'store'])->name('kecelakaan.store');
            Route::get('/kecelakaan/{kecelakaan:id_kecelakaan}/detail', [KecelakaanController::class, 'show'])->name('kecelakaan.show');
            Route::get('/kecelakaan/{kecelakaan:id_kecelakaan}/edit', [KecelakaanController::class, 'edit'])->name('kecelakaan.edit');
            Route::patch('/kecelakaan/{kecelakaan:id_kecelakaan}/update', [KecelakaanController::class, 'update'])->name('kecelakaan.update');
            Route::delete('/kecelakaan/{kecelakaan:id_kecelakaan}/destroy', [KecelakaanController::class, 'destroy'])->name('kecelakaan.destroy');
            Route::get('/kecelakaan/export', [KecelakaanController::class, 'export'])->name('kecelakaan.export');
        });
    });
});
