<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;

// ── Public pages ──────────────────────────────────────────────────────────

#|--------------------------------------------------------------------------
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog'); # Web Routes – SugarLoom PH 
#|--------------------------------------------------------------------------

// ── Placeholder routes (build these out next) ─────────────────────────────
Route::get('/track-order', fn() => view('track-order'))->name('track-order');
Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');


// ── Cart API ──────────────────────────────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',         [CartController::class, 'index'])->name('index');
    Route::post('/add',     [CartController::class, 'add'])->name('add');
    Route::delete('/{id}',  [CartController::class, 'remove'])->name('remove');
    Route::delete('/',      [CartController::class, 'clear'])->name('clear');
});
