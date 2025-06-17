<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;

// Home page route - accessible from root URL
Route::get('/', [HomeController::class, 'index'])->name('home');

// Keep the existing index route for backward compatibility
Route::get('/index', [HomeController::class, 'index'])->name('index');

// Cart route
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');

// Profile route
Route::get('/profile', function () {
    return view('profile.edit');
})->name('profile');

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
