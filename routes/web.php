<?php

use App\Http\Controllers\LokasiController;
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

    Route::prefix('data')->group(function () {
        Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::get('/lokasi/tambah', [LokasiController::class, 'tambah'])->name('lokasi.tambah');
        Route::post('/lokasi/insert', [LokasiController::class, 'insert'])->name('lokasi.insert');
        Route::get('/lokasi/detail/{lokasi:id_lokasi}', [LokasiController::class, 'show'])->name('lokasi.show');
        Route::get('/lokasi/{lokasi:id_lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
        Route::patch('/lokasi/{lokasi:id_lokasi}/update', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/{lokasi:id_lokasi}/destroy', [LokasiController::class, 'destroy'])->name('lokasi.destroy');
    });
});
