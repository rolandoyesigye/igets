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
                @auth
                    <!-- Desktop Top Navigation -->
                    <header class="hidden lg:flex items-center justify-between px-6 py-4 bg-background border-b shadow-sm w-full">
                    <div></div>

                    <div class="flex items-center gap-3">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative inline-flex items-center justify-center p-3 rounded-xl border border-border text-muted-foreground hover:text-foreground hover:border-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                @if(auth()->user()->unreadNotifications->count())
                                    <span class="absolute top-1 right-1 inline-flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-destructive text-[10px] text-white px-1.5">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute right-0 mt-3 w-96 rounded-3xl border border-border bg-popover text-popover-foreground shadow-xl z-50 overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-border">
                                    <div>
                                        <p class="text-sm font-semibold">Notifications</p>
                                        <p class="text-xs text-muted-foreground">Latest alerts for your account</p>
                                    </div>
                                    <span class="inline-flex items-center justify-center rounded-full bg-destructive text-[10px] text-white h-5 px-2">{{ auth()->user()->unreadNotifications->count() }}</span>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    @forelse(auth()->user()->notifications->sortByDesc('created_at')->take(5) as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-muted transition-colors {{ $notification->read_at ? '' : 'bg-primary/5' }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">🔔</div>
                                                <div class="min-w-0">
                                                    <div class="font-medium text-foreground truncate">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                                    <p class="text-sm text-muted-foreground truncate">{{ $notification->data['message'] ?? '' }}</p>
                                                    <p class="text-xs uppercase tracking-[0.18em] text-muted-foreground mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-6 text-center text-sm text-muted-foreground">
                                            No notifications at the moment.
                                        </div>
                                    @endforelse
                                </div>
                                <div class="border-t border-border px-4 py-3">
                                    <a href="{{ route('settings.notifications') }}" class="block text-center text-sm font-semibold text-primary hover:underline">View all notifications</a>
                                </div>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-3 rounded-xl border border-border bg-white px-3 py-2 hover:border-primary transition-all">
                                <div class="w-10 h-10 rounded-xl bg-primary text-primary-foreground flex items-center justify-center font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-foreground">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-muted-foreground">My Account</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="m6 9 6 6 6-6"/></svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute right-0 mt-2 w-56 rounded-2xl border border-border bg-popover text-popover-foreground shadow-lg z-50 overflow-hidden">
                                <a href="{{ route('settings.profile') }}" class="block px-4 py-3 text-sm text-foreground hover:bg-accent transition-colors">Profile settings</a>
                                <div class="h-px bg-border"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-destructive hover:bg-destructive/10 transition-colors">Log out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Mobile Header -->
                <header class="lg:hidden flex items-center justify-between px-4 py-3 bg-background border-b shadow-sm w-full">
                    <button @click="mobileSidebarOpen = true" class="p-2 text-muted-foreground hover:bg-accent rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    </button>

                    <div></div>

                    <div class="flex items-center gap-2">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative inline-flex items-center justify-center p-2 rounded-xl border border-border text-muted-foreground hover:text-foreground hover:border-primary transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                @if(auth()->user()->unreadNotifications->count())
                                    <span class="absolute top-0 right-0 inline-flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-destructive text-[10px] text-white px-1">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute right-0 mt-3 w-[calc(100vw-2rem)] max-w-sm rounded-3xl border border-border bg-popover text-popover-foreground shadow-xl z-50 overflow-hidden">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-border">
                                    <div>
                                        <p class="text-sm font-semibold">Notifications</p>
                                        <p class="text-xs text-muted-foreground">Latest alerts</p>
                                    </div>
                                    <span class="inline-flex items-center justify-center rounded-full bg-destructive text-[10px] text-white h-5 px-2">{{ auth()->user()->unreadNotifications->count() }}</span>
                                </div>
                                <div class="max-h-72 overflow-y-auto">
                                    @forelse(auth()->user()->notifications->sortByDesc('created_at')->take(5) as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-muted transition-colors {{ $notification->read_at ? '' : 'bg-primary/5' }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-9 h-9 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">🔔</div>
                                                <div class="min-w-0">
                                                    <div class="text-sm font-medium text-foreground truncate">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                                    <p class="text-sm text-muted-foreground truncate">{{ $notification->data['message'] ?? '' }}</p>
                                                    <p class="text-xs uppercase tracking-[0.18em] text-muted-foreground mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-6 text-center text-sm text-muted-foreground">
                                            No notifications yet.
                                        </div>
                                    @endforelse
                                </div>
                                <div class="border-t border-border px-4 py-3">
                                    <a href="{{ route('settings.notifications') }}" class="block text-center text-sm font-semibold text-primary hover:underline">View all notifications</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('settings.profile') }}" class="inline-flex items-center justify-center p-2 rounded-xl border border-border text-muted-foreground hover:text-foreground hover:border-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-3-3.87"/><path d="M4 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>
                        </a>
                    </div>
                </header>
                @endauth

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
