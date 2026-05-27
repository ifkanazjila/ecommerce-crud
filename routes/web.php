<?php

use App\Http\Controllers\PembelianController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [PembelianController::class, 'getProducts']);

Route::get('/cart', [PembelianController::class, 'getBasket'])->middleware('auth')->name('cart');

Route::post('/cart/add', [PembelianController::class, 'add'])->middleware('auth');

Route::delete('/cart/remove/{id}', [PembelianController::class, 'remove'])->middleware('auth');

Route::patch('/cart/update/{id}', [PembelianController::class, 'update'])->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/checkout', [PembelianController::class, 'checkout'])->name('checkout');

Route::patch('/cart/update/{id}', [PembelianController::class, 'update'])->middleware('auth');