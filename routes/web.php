<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SocialiteController;

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

// Cart routes - accessible to all users
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::put('/cart/{itemId}/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{itemId}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Protected checkout routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Profile route
Route::get('/profile', function () {
    return view('profile.edit');
})->name('profile');

// Account Settings routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/account/settings', [AccountController::class, 'index'])->name('account.settings');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    
    // Profile Settings routes
    Route::get('/profile/settings', [ProfileController::class, 'index'])->name('profile.settings');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

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

    // Admin Management Routes - restricted to admin role only
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        // Order Management
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/orders/filter', [\App\Http\Controllers\Admin\OrderController::class, 'filter'])->name('orders.filter');
        
        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    
});


// Duplicate admin prefix group removed; routes are defined above with proper middleware

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
