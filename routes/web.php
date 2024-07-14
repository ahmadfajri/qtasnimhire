<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangJenisController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiMaxMinController;
use App\Http\Controllers\TransaksiPerJenisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/get-barang-stok-sedikit', [HomeController::class, 'getBarangStokSedikit'])->name('home.getBarangStokSedikit');
Route::get('/get-project-home', [HomeController::class, 'getProject'])->name('home.getProject');

Route::get('/barangjenis', [BarangJenisController::class, 'index'])->name('barangjenis.index');
Route::get('/get-barangjenis', [BarangJenisController::class, 'get'])->name('barangjenis.get');
Route::post('/barangjenis', [BarangJenisController::class, 'store'])->name('barangjenis.store');
Route::get('/barangjenis/{id}/show', [BarangJenisController::class, 'show'])->name('barangjenis.show');
Route::put('/barangjenis/{id}/update', [BarangJenisController::class, 'update'])->name('barangjenis.update');
Route::delete('/barangjenis/{id}/delete', [BarangJenisController::class, 'destroy'])->name('barangjenis.destroy');

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/get-barang', [BarangController::class, 'get'])->name('barang.get');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{id}/show', [BarangController::class, 'show'])->name('barang.show');
Route::put('/barang/{id}/update', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}/delete', [BarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/get-transaksi', [TransaksiController::class, 'get'])->name('transaksi.get');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::delete('/transaksi/{id}/delete', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

Route::get('/transaksiperjenis', [TransaksiPerJenisController::class, 'index'])->name('transaksiperjenis.index');
Route::get('/get-transaksiperjenis', [TransaksiPerJenisController::class, 'get'])->name('transaksiperjenis.get');
