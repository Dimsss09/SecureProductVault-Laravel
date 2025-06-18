<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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

// Authentication Routes (Login, Register, Password Reset, dll.)
Auth::routes(['verify' => true]);

// Redirect root URL to home
Route::get('/', function () {
    return redirect('/home'); // Redirect ke /home bukan ke route name
});

// Grup Route yang Membutuhkan Autentikasi (Hanya untuk User yang Sudah Login)
Route::middleware(['auth'])->group(function () {
    // Home route harus di atas route products
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// HAPUS atau komentari baris di bawah ini jika Anda ingin '/' menjadi satu-satunya dashboard utama.
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');