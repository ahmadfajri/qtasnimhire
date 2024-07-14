<?php

use App\Http\Controllers\API\BarangController;
use App\Http\Controllers\API\BarangJenisController;
use App\Http\Controllers\API\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('barang')->group(function () {
    Route::controller(BarangController::class)->group(function () {
        Route::get('/', 'getBarang');
        Route::post('/tambah', 'store');
        Route::get('/{id}/show', 'show');
        Route::post('/{id}/update', 'update');
        Route::delete('/{id}/delete', 'destroy');
    });
});

Route::prefix('barangjenis')->group(function () {
    Route::controller(BarangJenisController::class)->group(function () {
        Route::get('/', 'getBarangJenis');
        Route::post('/tambah', 'store');
        Route::get('/{id}/show', 'show');
        Route::post('/{id}/update', 'update');
        Route::delete('/{id}/delete', 'destroy');
    });
});

Route::prefix('transaksi')->group(function () {
    Route::controller(TransaksiController::class)->group(function () {
        Route::get('/', 'getTransaksi');
        Route::post('/tambah', 'store');
        Route::get('/{id}/show', 'show');
        Route::delete('/{id}/delete', 'destroy');
        Route::get('/perjenis', 'getTransaksiPerJenis');
    });
});
