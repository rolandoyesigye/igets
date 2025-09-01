<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')

        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">

        <!-- Sidebar -->
<!-- Sidebar -->
<flux:sidebar 
    sticky 
    stashable 
    class="border-e border-zinc-200 bg-white text-gray-800 shadow-md">

    <!-- Mobile toggle -->
    <flux:sidebar.toggle class="lg:hidden p-2 hover:bg-zinc-100 rounded-lg" icon="x-mark" />

    <!-- Logo -->
    <a href="{{ route('dashboard') }}" 
       class="me-5 flex items-center gap-2 p-3 text-xl font-bold text-gray-900 hover:text-indigo-600 transition"
       wire:navigate>
        <x-app-logo class="w-8 h-8 text-indigo-500" />
        <!-- <span class="hidden lg:block">Iget</span> -->
    </a>

    <!-- Navigation -->
    <flux:navlist variant="outline" class="mt-4 space-y-1">
        <flux:navlist.group :heading="__('Platform')" class="grid text-gray-500 uppercase text-xs tracking-wide px-3">
            <flux:navlist.item 
                icon="home" 
                :href="route('dashboard')" 
                :current="request()->routeIs('dashboard')" 
                class="rounded-lg transition-all px-3 py-2 flex items-center gap-2 
                       hover:bg-zinc-100 hover:text-indigo-600 
                       @if(request()->routeIs('dashboard')) border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700 font-medium @endif"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>

    <!-- Users -->
    <flux:navlist variant="outline" class="space-y-1">
        <flux:navlist.item 
            icon="users" 
            :href="route('admin.users.index')" 
            :current="request()->routeIs('admin.users.*')" 
            class="rounded-lg transition-all px-3 py-2 flex items-center justify-between gap-2
                   hover:bg-zinc-100 hover:text-indigo-600
                   @if(request()->routeIs('admin.users.*')) border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700 font-medium @endif"
            wire:navigate>
            {{ __('Users') }}
        </flux:navlist.item>
    </flux:navlist>

    <!-- Products Dropdown -->
    <flux:navlist variant="outline">
        <flux:dropdown position="bottom" align="start">
            <flux:navlist.item 
                icon="" 
                icon:trailing="chevron-down" 
                class="cursor-pointer rounded-lg transition px-3 py-2
                       hover:bg-zinc-100 hover:text-indigo-600"
            >
                {{ __('Products') }}
            </flux:navlist.item>

            <flux:navmenu class="rounded-lg shadow-lg border border-zinc-200 bg-white text-gray-800">
                <flux:navmenu.item 
                    icon="plus" 
                    href="{{ route('products.create') }}" 
                    :current="request()->routeIs('products.create')" 
                    class="hover:bg-zinc-100 hover:text-indigo-600"
                    wire:navigate>
                    {{ __('Add Products') }}
                </flux:navmenu.item>

                <flux:navmenu.item 
                    icon="eye" 
                    href="{{ route('products.index') }}" 
                    :current="request()->routeIs('products.index')" 
                    class="hover:bg-zinc-100 hover:text-indigo-600"
                    wire:navigate>
                    {{ __('View Products') }}
                </flux:navmenu.item>
            </flux:navmenu>
        </flux:dropdown>
    </flux:navlist>

    <!-- Orders -->
    <flux:navlist variant="outline" class="space-y-1">
        <flux:navlist.item 
            icon="shopping-cart" 
            :href="route('admin.orders.index')" 
            :current="request()->routeIs('admin.orders.index')" 
            class="rounded-lg transition-all px-3 py-2 flex items-center justify-between gap-2
                   hover:bg-zinc-100 hover:text-indigo-600
                   @if(request()->routeIs('admin.orders.index')) border-l-4 border-indigo-500 bg-indigo-50 text-indigo-700 font-medium @endif"
            wire:navigate>
            {{ __('Orders') }}
        </flux:navlist.item>
    </flux:navlist>

    <flux:spacer />

    <!-- Desktop User Menu -->
    <flux:dropdown class="hidden lg:block mt-4 border-t border-zinc-200 pt-3" position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            icon:trailing="chevrons-up-down"
            class="text-gray-900"
        />

        <flux:menu class="w-[220px] rounded-xl shadow-lg border border-zinc-200 bg-white text-gray-800">
            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" 
                    class="w-full text-red-600 hover:bg-red-100 hover:text-red-800">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>


        <!-- Page Content -->
        {{ $slot }}

        @fluxScripts

        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Toastr Config -->
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if(session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif

            @if(session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            @if(session('status'))
                toastr.success("{{ session('status') }}");
            @endif
        </script>
    </body>
</html>
