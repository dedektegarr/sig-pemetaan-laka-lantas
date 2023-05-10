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
    });
});
