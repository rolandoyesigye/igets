<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// Home page route - accessible from root URL
Route::get('/', [HomeController::class, 'index'])->name('home');

// Keep the existing index route for backward compatibility
Route::get('/index', [HomeController::class, 'index'])->name('index');

// Product show route using HomeController
Route::get('/product/{product}', [HomeController::class, 'show'])->name('home.show');

// Cart route
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

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
});

require __DIR__.'/auth.php';
