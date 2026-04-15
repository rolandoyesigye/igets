<aside class="w-64 border-r bg-card h-screen flex flex-col shadow-xl">
    <!-- Brand Header -->
    <div class="px-6 py-6 border-b border-border">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-12 h-12 bg-primary text-primary-foreground rounded-2xl flex items-center justify-center font-bold text-lg shadow-sm">
                IG
            </div>
            <div>
                <p class="text-sm font-semibold text-foreground">{{ config('app.name') }}</p>
                <p class="text-xs text-muted-foreground">Admin Dashboard</p>
            </div>
        </a>
    </div>

    <!-- User Profile Section (Top) -->
    <div class="px-4 py-8 lg:hidden">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-3 w-full p-2 rounded-xl hover:bg-accent transition-all duration-200 text-left">
                <div class="flex-shrink-0 w-12 h-12 bg-primary text-primary-foreground rounded-xl flex items-center justify-center text-lg font-bold shadow-lg">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-foreground truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-muted-foreground truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
            </button>

            <div x-show="open" @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="absolute left-0 w-full mt-2 origin-top-left bg-popover text-popover-foreground border rounded-xl shadow-lg z-50 overflow-hidden">
                <a href="{{ route('settings.profile') }}" class="flex items-center gap-2 px-4 py-3 text-sm hover:bg-accent transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.1a2 2 0 0 1-1-1.72v-.51a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    Settings
                </a>
                <div class="h-px bg-border"></div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-3 text-sm text-destructive hover:bg-destructive/10 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="px-6 mt-6 mb-8">
        <label class="relative block">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </span>
            <input type="text" placeholder="Search" class="block w-full h-10 pl-10 pr-4 bg-muted border-none rounded-xl text-sm placeholder:text-muted-foreground focus:ring-2 focus:ring-primary/20 transition-all outline-none">
        </label>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all @if(request()->routeIs('dashboard')) bg-primary text-primary-foreground shadow-lg shadow-primary/20 @else text-muted-foreground hover:bg-accent hover:text-accent-foreground @endif"
           wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all @if(request()->routeIs('admin.users.*')) bg-primary text-primary-foreground shadow-lg shadow-primary/20 @else text-muted-foreground hover:bg-accent hover:text-accent-foreground @endif"
           wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all @if(request()->routeIs('admin.orders.*')) bg-primary text-primary-foreground shadow-lg shadow-primary/20 @else text-muted-foreground hover:bg-accent hover:text-accent-foreground @endif"
           wire:navigate>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            Orders
        </a>

        <!-- Products Dropdown -->
        <div x-data="{ open: @js(request()->routeIs('products.*')) }" class="space-y-1">
            <button @click="open = !open"
                    class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-all">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    Products
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200" :class="open ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-show="open" x-collapse class="pl-12 space-y-1">
                <a href="{{ route('products.index') }}"
                   class="block px-3 py-2 rounded-lg text-sm transition-colors @if(request()->is('products')) text-primary font-bold @else text-muted-foreground hover:text-accent-foreground hover:bg-accent @endif"
                   wire:navigate>
                    View All
                </a>
                <a href="{{ route('products.create') }}"
                   class="block px-3 py-2 rounded-lg text-sm transition-colors @if(request()->is('products/create')) text-primary font-bold @else text-muted-foreground hover:text-accent-foreground hover:bg-accent @endif"
                   wire:navigate>
                    Add Product
                </a>
            </div>
        </div>
    </nav>
</aside>
