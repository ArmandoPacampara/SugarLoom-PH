<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;

// ── Public pages ──────────────────────────────────────────────────────────

#|--------------------------------------------------------------------------
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog'); # Web Routes – SugarLoom PH 
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/about', [PageController::class, 'about'])->name('about');
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

<<<<<<< HEAD
=======
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-product', function () {
    return view('products.show');
});

Route::get('/catalog', function () {
    return view('welcome');
})->name('catalog');

Route::get('/track-order', function () {
    return view('welcome');
})->name('track-order');

require __DIR__.'/auth.php';
>>>>>>> 9b763315e79c08fefc39251731e24321775cae87
