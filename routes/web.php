<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackOrderController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/show', [PageController::class, 'show'])->name('show');
Route::get('/track-order', [TrackOrderController::class, 'index'])->name('track-order');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // --> NEW EXPORT ROUTE ADDED HERE <--
    Route::get('/admin/export-report', [DashboardController::class, 'exportReport'])->name('admin.export');
    
    Route::get('/admin/inventory', [DashboardController::class, 'inventory'])->name('admin.inventory');
    Route::get('/admin/products/create', [DashboardController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [DashboardController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [DashboardController::class, 'editProduct'])->name('admin.products.edit');
    Route::patch('/admin/products/{product}', [DashboardController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [DashboardController::class, 'destroyProduct'])->name('admin.products.destroy');
    
    Route::get('/admin/orders', [DashboardController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/orders/create', [DashboardController::class, 'createOrder'])->name('admin.orders.create');
    Route::post('/admin/orders', [DashboardController::class, 'storeOrder'])->name('admin.orders.store');
    Route::patch('/admin/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::redirect('/dashboard', '/admin')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/orders/{order}/rating', [OrderController::class, 'submitRating'])->name('order.rating');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/rewards', [CartController::class, 'rewards'])->name('rewards');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/promo', [CartController::class, 'applyPromo'])->name('promo');
    Route::patch('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
});

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.process');
Route::get('/checkout/success', [CartController::class, 'paymongoSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [CartController::class, 'paymongoCancel'])->name('checkout.cancel');
Route::get('/checkout/failed', [CartController::class, 'paymongoCancel'])->name('checkout.failed');