<?php

use App\Http\Controllers\KecelakaanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PetaController;
use App\Models\Kecelakaan;
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

Route::prefix('administrator')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard/index');
    })->name('dashboard.index');

    Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');

    Route::prefix('data')->group(function () {
        // LOKASI
        Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::get('/lokasi/tambah', [LokasiController::class, 'create'])->name('lokasi.create');
        Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::get('/lokasi/{lokasi:id_lokasi}/detail', [LokasiController::class, 'show'])->name('lokasi.show');
        Route::get('/lokasi/{lokasi:id_lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
        Route::patch('/lokasi/{lokasi:id_lokasi}/update', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/{lokasi:id_lokasi}/destroy', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

        // KECELAKAAN
        Route::get('/kecelakaan', [KecelakaanController::class, 'index'])->name('kecelakaan.index');
        Route::get('/kecelakaan/tambah', [KecelakaanController::class, 'create'])->name('kecelakaan.create');
        Route::post('/kecelakaan/store', [KecelakaanController::class, 'store'])->name('kecelakaan.store');
        Route::patch('/kecelakaan/{kecelakaan:id_kecelakaan}/detail', [KecelakaanController::class, 'show'])->name('kecelakaan.show');
        Route::patch('/kecelakaan/{kecelakaan:id_kecelakaan}/update', [KecelakaanController::class, 'update'])->name('kecelakaan.update');
        Route::delete('/kecelakaan/{kecelakaan:id_kecelakaan}/destroy', [KecelakaanController::class, 'destroy'])->name('kecelakaan.destroy');
        Route::get('/kecelakaan/export', [KecelakaanController::class, 'export'])->name('kecelakaan.export');
    });
});