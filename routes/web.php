<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/show', [PageController::class, 'show'])->name('show');
Route::get('/track-order', fn() => view('track-order'))->name('track-order');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::redirect('/dashboard', '/admin')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
});

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');
Route::get('/checkout/success', [CartController::class, 'paymongoSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CartController::class, 'paymongoCancel'])->name('checkout.cancel');
Route::get('/checkout/failed', [CartController::class, 'paymongoCancel'])->name('checkout.failed');
