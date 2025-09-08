<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        @include('partials.head')

        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <!-- Additional Meta Tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    </head>
    <body class="h-full bg-gray-50 dark:bg-zinc-900">
        <div class="flex h-full">
            <!-- Sidebar for Desktop -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex w-64">
                    <x-layouts.app.sidebar />
                </div>
            </div>

            <!-- Mobile Sidebar -->
            <div class="lg:hidden">
                <x-layouts.app.sidebar />
            </div>

            <!-- Main Content Area -->
            <div class="flex flex-1 flex-col min-w-0">
                <!-- Mobile Header -->
                <div class="lg:hidden">
                    <div class="bg-white shadow-sm border-b border-gray-200 px-4 py-3">
                        <div class="flex items-center justify-between">
                            <!-- Mobile Menu Toggle -->
                            <flux:sidebar.toggle class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" icon="bars-3" />

                            <!-- Mobile Logo -->
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2" wire:navigate>
                                <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                    <x-app-logo class="w-5 h-5 text-white" />
                                </div>
                                <span class="text-lg font-semibold text-gray-900">Igets</span>
                            </a>

                            <!-- Mobile User Menu -->
                            <flux:dropdown position="bottom" align="end">
                                <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-semibold text-sm cursor-pointer">
                                    {{ auth()->user()->initials() }}
                                </div>

                                <flux:menu class="w-[200px] rounded-xl shadow-lg border border-zinc-200 bg-white text-gray-800">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>

                                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate
                                        class="px-4 py-3 text-sm hover:bg-zinc-50 transition-colors duration-200">
                                        {{ __('Settings') }}
                                    </flux:menu.item>

                                    <flux:menu.separator />

                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                            class="w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                                            {{ __('Log Out') }}
                                        </flux:menu.item>
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="flex-1 overflow-auto">
                    <!-- Content Container -->
                    <div class="h-full">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- Global Loading Indicator -->
        <div id="loading-indicator" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                <span class="text-gray-900 font-medium">Loading...</span>
            </div>
        </div>

        <!-- Flash Messages Container -->
        <div id="flash-messages" class="fixed top-4 right-4 z-40 space-y-2">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md transition-all duration-300 transform translate-x-0" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md transition-all duration-300 transform translate-x-0" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg shadow-md transition-all duration-300 transform translate-x-0" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        {{ session('warning') }}
                    </div>
                </div>
            @endif
        </div>

        @fluxScripts

        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Global JavaScript -->
        <script>
            // Toastr Configuration
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showDuration": "300",
                "hideDuration": "1000"
            };

            // Auto-hide flash messages
            document.addEventListener('DOMContentLoaded', function() {
                const flashMessages = document.querySelectorAll('#flash-messages > div');
                flashMessages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.transform = 'translateX(100%)';
                        message.style.opacity = '0';
                        setTimeout(function() {
                            message.remove();
                        }, 300);
                    }, 5000);
                });
            });

            // Global loading state management
            function showLoading() {
                document.getElementById('loading-indicator').classList.remove('hidden');
            }

            function hideLoading() {
                document.getElementById('loading-indicator').classList.add('hidden');
            }

            // Wire navigation loading states
            document.addEventListener('livewire:navigating', () => {
                showLoading();
            });

            document.addEventListener('livewire:navigated', () => {
                hideLoading();
            });

            // Form submission loading states
            document.addEventListener('submit', function(e) {
                if (e.target.tagName === 'FORM') {
                    showLoading();
                }
            });

            // Hide loading on page load complete
            window.addEventListener('load', function() {
                hideLoading();
            });

            // Responsive table handling
            function makeTablesResponsive() {
                const tables = document.querySelectorAll('table:not(.dataTable)');
                tables.forEach(function(table) {
                    if (!table.parentNode.classList.contains('table-responsive')) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'table-responsive overflow-x-auto';
                        table.parentNode.insertBefore(wrapper, table);
                        wrapper.appendChild(table);
                    }
                });
            }

            // Run on page load and navigation
            document.addEventListener('DOMContentLoaded', makeTablesResponsive);
            document.addEventListener('livewire:navigated', makeTablesResponsive);

            // Mobile sidebar handling
            function handleMobileSidebar() {
                const sidebar = document.querySelector('[data-flux-sidebar]');
                const overlay = document.querySelector('[data-flux-sidebar-overlay]');

                if (sidebar && overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.add('hidden');
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', handleMobileSidebar);
        </script>

        <!-- Additional Scripts Stack -->
        @stack('scripts')
    </body>
</html>
