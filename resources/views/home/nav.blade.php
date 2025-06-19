<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF‑8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>iGETS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3" defer></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100" x-data="{ open: false }">

  <!-- NAVBAR -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
      <!-- Logo -->
       <a href="{{ route('home') }}"><img src="{{ asset('images/logo1.png') }}" width="100px" height="100px" alt="iGETS Logo"></a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center space-x-6 sticky-top">
        <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500">Home</a>
        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-orange-500">Laptops</a>
        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-orange-500">Accessories</a>
        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-orange-500">Desktops</a>
        <div class="relative">
          <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-l-md focus:outline-none"/>
          <button class="absolute top-0 right-0 bg-orange-500 text-white px-3 py-1 rounded-r-md">Go</button>
        </div>
      </nav>

      <!-- Auth Buttons (md+) -->
      <div class="hidden md:flex items-center space-x-4">
        <!-- Cart icon - shown for all users -->
        <a href="{{ Auth::check() ? route('cart.index') : route('login') }}" class="px-4 py-2 rounded hover:bg-gray-50 flex items-center relative">
          <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
          </svg>
          <span class="text-gray-700">{{ Auth::check() ? 'Cart' : 'View Cart' }}</span>
          @php
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = session('cart', []);
                $cartCount = array_sum($cart);
            }
          @endphp
          @if($cartCount > 0)
            <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
              {{ $cartCount > 99 ? '99+' : $cartCount }}
            </span>
          @endif
        </a>

  @if (Route::has('login'))
    @auth
      @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('access-dashboard'))
        <a href="{{ url('/dashboard') }}" class="px-4 py-2 border rounded hover:bg-gray-50">Dashboard</a>
      @else
        <span class="px-4 py-2 text-gray-500 text-sm">Welcome, {{ auth()->user()->name }}</span>

        <!-- Account dropdown -->
        <div x-data="{ open: false }" @click.away="open = false" class="relative">
          <button @click="open = !open" class="flex items-center px-4 py-2 rounded hover:bg-gray-50">
            <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-gray-700">Account</span>
            <svg class="h-4 w-4 text-gray-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <div 
            x-show="open" 
            x-transition 
            class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-10"
          >
            <a href="{{ route('home.orders') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
              <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              My Orders
            </a>
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('access-dashboard'))
              <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Dashboard
              </a>
            @endif
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
              <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
              </button>
            </form>
          </div>
        </div>
      @endif
    @else
      <a href="{{ route('login') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Log in</a>
      @if (Route::has('register'))
        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Register</a>
      @endif
    @endauth
  @endif
      </div>


      <!-- Mobile Menu Button -->
      <button @click="open = !open" class="md:hidden text-gray-700">
        <span x-show="!open">☰</span>
        <span x-show="open">✕</span>
        </button>
      </div>

    <!-- Mobile Nav -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="md:hidden bg-white border-t border-gray-200">
      <nav class="px-6 py-4 space-y-2">
        <a href="{{ route('home') }}" class="block text-gray-700 hover:text-orange-500">Home</a>
        <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-orange-500">Laptops</a>
        <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-orange-500">Accessories</a>
        <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-orange-500">Desktops</a>
        
        <!-- Cart link for mobile -->
        <a href="{{ Auth::check() ? route('cart.index') : route('login') }}" class="block text-gray-700 hover:text-orange-500 flex items-center">
          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
          </svg>
          {{ Auth::check() ? 'Cart' : 'View Cart' }}
          @php
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = session('cart', []);
                $cartCount = array_sum($cart);
            }
          @endphp
          @if($cartCount > 0)
            <span class="ml-2 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
              {{ $cartCount > 99 ? '99+' : $cartCount }}
            </span>
          @endif
        </a>
        
        <div class="pt-4 border-t">
          @if (Route::has('login'))
            @auth
              @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('access-dashboard'))
                <a href="{{ url('/dashboard') }}" class="block px-4 py-2 border rounded mb-2 hover:bg-gray-50">Dashboard</a>
              @else
                <span class="block px-4 py-2 text-gray-500 text-sm">Welcome, {{ auth()->user()->name }}</span>
              @endif
            @else
              <a href="{{ route('login') }}" class="block bg-orange-500 text-white px-4 py-2 rounded mb-2 hover:bg-orange-600">Log in</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="block bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Register</a>
              @endif
            @endauth
          @endif
      </div>
      </nav>
    </div>
  </header>