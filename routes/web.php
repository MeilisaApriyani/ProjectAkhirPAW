<?php

use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController; 
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;



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

Route::redirect('/','/login');



Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.post');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {
   
    Route::get('/home',[HomeController::class,'home'])->name('home');
    Route::get('/dashboard',[StockController::class,'index'])->name('dashboard');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
    Route::put('/stock/{idbarang}', [StockController::class, 'update'])->name('stock.update');
    Route::delete('/stock/{idbarang}', [StockController::class, 'destroy'])->name('stock.delete');
    
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk');
    Route::post('/barang-masuk/store', [BarangMasukController::class, 'store'])->name('barang.masuk.store');
    Route::put('/barang-masuk/update/{idmasuk}', [BarangMasukController::class, 'update'])->name('barang.masuk.update');
    Route::delete('/barang-masuk/delete/{idmasuk}', [BarangMasukController::class, 'destroy'])->name('barang.masuk.delete');
    
    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar');
    Route::post('/barang-keluar/store', [BarangKeluarController::class, 'store'])->name('barang.keluar.store');
    Route::put('/barang-keluar/update/{idkeluar}', [BarangKeluarController::class, 'update'])->name('barang.keluar.update');
    Route::delete('/barang-keluar/delete/{idkeluar}', [BarangKeluarController::class, 'destroy'])->name('barang.keluar.delete');
    
    
   
});

Route::middleware(['auth'])->group(function () {
Route::get('/user', [StockController::class, 'user'])->name('user');

});


