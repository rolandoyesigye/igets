<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\UserController;

// Home page route - accessible from root URL
Route::get('/', [HomeController::class, 'index'])->name('home');

// Keep the existing index route for backward compatibility
Route::get('/index', [HomeController::class, 'index'])->name('index');
Route::get('/home/laptops', [HomeController::class, 'laptops'])->name('home.laptops');
Route::get('/home/accessories', [HomeController::class, 'accessories'])->name('home.accessories');
Route::get('/home/phones', [HomeController::class, 'phones'])->name('home.phones');

// Product show route using HomeController
Route::get('/product/{product}', [HomeController::class, 'show'])->name('home.show');

// Orders for Home
Route::get('/home/orders', [HomeController::class, 'orders'])->name('home.orders');

// Category pages
Route::get('/home/laptops', [HomeController::class, 'laptops'])->name('home.laptops');
Route::get('/home/accessories', [HomeController::class, 'accessories'])->name('home.accessories');
Route::get('/home/phones', [HomeController::class, 'phones'])->name('home.phones');

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add'); // Open for everyone

// Protected cart routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Profile route
Route::get('/profile', function () {
    return view('profile.edit');
})->name('profile');

// Product routes using ProductController
Route::resource('products', ProductController::class);

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'dashboard.access'])
    ->name('dashboard');

Route::middleware(['auth', 'dashboard.access'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Admin Order Management Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/orders/filter', [\App\Http\Controllers\Admin\OrderController::class, 'filter'])->name('orders.filter');
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.delete');
    });

    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    
});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});


require __DIR__.'/auth.php';
