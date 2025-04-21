<?php

use App\Http\Controllers\BahanBajuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModelBajuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisterController;
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
    $model_bajus = \App\Models\ModelBaju::with(['bahanBaju'])->take(8)->get();
    return view('welcome', compact('model_bajus'));
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/profile/edit', [ProfilController::class, 'edit'])->middleware(['auth', 'role:admin,user'])->name('profile.edit');
Route::put('/profile/update/{id}', [ProfilController::class, 'update'])->middleware(['auth', 'role:admin,user'])->name('profile.update');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'role:admin,user'])->name('dashboard.index');
Route::resource('ukuran', UkuranController::class)->middleware(['auth', 'role:admin']);
Route::resource('bahan-baju', BahanBajuController::class)->middleware(['auth', 'role:admin']);
Route::resource('model-baju', ModelBajuController::class)->middleware(['auth', 'role:admin,user']);
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index')->middleware(['auth', 'role:admin,user']);
// Cart routes
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [App\Http\Controllers\KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{keranjangItem}', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{keranjangItem}', [App\Http\Controllers\KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    
    // Checkout route (placeholder for future implementation)
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'payment'])->name('orders.payment');
    
    // Midtrans callback
    
});