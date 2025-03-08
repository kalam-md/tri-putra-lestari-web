<?php

use App\Http\Controllers\BahanBajuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModelBajuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UkuranController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::resource('ukuran', UkuranController::class);
Route::resource('bahan-baju', BahanBajuController::class);
Route::resource('model-baju', ModelBajuController::class);
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');