<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;

require __DIR__.'/auth.php';
// ── Public pages ──────────────────────────────────────────────────────────

#|--------------------------------------------------------------------------
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog'); # Web Routes – SugarLoom PH 
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/show', [PageController::class, 'show'])->name('show');
#|--------------------------------------------------------------------------

// ── Placeholder routes (build these out next) ─────────────────────────────
Route::get('/track-order', fn() => view('track-order'))->name('track-order');
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');


// ── Cart API ──────────────────────────────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',         [CartController::class, 'index'])->name('index');
    Route::post('/add',     [CartController::class, 'add'])->name('add');
    Route::patch('/{id}',   [CartController::class, 'update'])->name('update');
    Route::delete('/{id}',  [CartController::class, 'remove'])->name('remove');
    Route::delete('/',      [CartController::class, 'clear'])->name('clear');
});

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');
Route::get('/checkout/success', [CartController::class, 'paymongoSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CartController::class, 'paymongoCancel'])->name('checkout.cancel');
Route::get('/checkout/failed', [CartController::class, 'paymongoCancel'])->name('checkout.failed');
