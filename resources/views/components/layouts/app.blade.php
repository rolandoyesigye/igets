<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        @include('partials.head')

        <!-- Additional Meta Tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

        <!-- Shadcn Font: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="h-full bg-background text-foreground antialiased">
        <div x-data="{ mobileSidebarOpen: false }" class="flex h-full overflow-hidden">
            <!-- Sidebar for Desktop -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                <x-layouts.app.sidebar />
            </div>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="mobileSidebarOpen"
                 @click="mobileSidebarOpen = false"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

            <!-- Mobile Sidebar Content -->
            <div x-show="mobileSidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 w-64 z-50 lg:hidden bg-background">
                <x-layouts.app.sidebar />
            </div>

            <!-- Main Content Area -->
            <div class="flex flex-1 flex-col min-w-0 overflow-hidden">
                <!-- Mobile Header -->
                <header class="lg:hidden flex items-center justify-between px-4 py-3 bg-background border-b shadow-sm w-full">
                    <button @click="mobileSidebarOpen = true" class="p-2 text-muted-foreground hover:bg-accent rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    </button>

                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-primary-foreground font-bold text-xs shadow-sm">
                            IG
                        </div>
                        <span class="text-lg font-bold">Igets</span>
                    </a>

                    <div class="w-10"></div> <!-- Spacer for balance -->
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-auto bg-muted/30 lg:p-6 p-4">
                    <!-- Content Container -->
                    <div class="min-h-full bg-white dark:bg-zinc-900 lg:rounded-[2.5rem] p-6 shadow-sm border border-border">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Flash Messages -->
        <div id="flash-messages" class="fixed top-4 right-4 z-[100] space-y-2 pointer-events-none">
            @if(session('success'))
                <x-ui.card class="p-4 bg-green-50 border-green-200 text-green-800 shadow-lg pointer-events-auto">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ session('success') }}
                    </div>
                </x-ui.card>
            @endif

            @if(session('error'))
                <x-ui.card class="p-4 bg-red-50 border-red-200 text-red-800 shadow-lg pointer-events-auto">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                        {{ session('error') }}
                    </div>
                </x-ui.card>
            @endif
        </div>

        <!-- Toastr JS (Optional fallback) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Global Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const flashMessages = document.querySelectorAll('#flash-messages > div');
                flashMessages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.opacity = '0';
                        message.style.transform = 'translateY(-20px)';
                        message.style.transition = 'all 0.5s ease';
                        setTimeout(() => message.remove(), 500);
                    }, 5000);
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
