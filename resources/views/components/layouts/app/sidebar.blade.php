<!-- Sidebar Component -->
<flux:sidebar
    sticky
    stashable
    class="border-r border-zinc-200 bg-white text-gray-800 shadow-lg min-h-screen">

    <!-- Mobile toggle -->
    <flux:sidebar.toggle class="lg:hidden p-3 hover:bg-zinc-50 rounded-lg transition-colors" icon="x-mark" />

    <!-- Logo -->
    <div class="px-4 py-6 border-b border-zinc-200">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 text-xl font-bold text-gray-900 hover:text-indigo-600 transition-colors duration-200"
           wire:navigate>
            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center">
                <x-app-logo class="w-6 h-6 text-white" />
            </div>
            <span class="hidden lg:block font-semibold tracking-tight">Technologies</span>
        </a>
    </div>

    <!-- Navigation -->
    <div class="px-4 py-6 space-y-6">
        <!-- Dashboard -->
        <div class="space-y-3">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3">Platform</h3>
            <flux:navlist variant="outline" class="space-y-1">
                <flux:navlist.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    class="group rounded-xl transition-all duration-200 mx-2 px-3 py-3 flex items-center gap-3 text-sm font-medium
                           hover:bg-indigo-50 hover:text-indigo-700
                           @if(request()->routeIs('dashboard')) bg-indigo-100 text-indigo-700 shadow-sm @else text-gray-700 @endif"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item>
            </flux:navlist>
        </div>

        <!-- Users -->
        <div class="space-y-1">
            <flux:navlist variant="outline">
                <flux:navlist.item
                    icon="users"
                    :href="route('admin.users.index')"
                    :current="request()->routeIs('admin.users.*')"
                    class="group rounded-xl transition-all duration-200 mx-2 px-3 py-3 flex items-center gap-3 text-sm font-medium
                           hover:bg-indigo-50 hover:text-indigo-700
                           @if(request()->routeIs('admin.users.*')) bg-indigo-100 text-indigo-700 shadow-sm @else text-gray-700 @endif"
                    wire:navigate>
                    {{ __('Users') }}
                </flux:navlist.item>
            </flux:navlist>
        </div>

        <!-- Products Dropdown -->
        <div class="space-y-1">
            <flux:navlist variant="outline">
                <flux:dropdown position="bottom" align="start">
                    <flux:navlist.item
                        icon="cube"
                        icon-trailing="chevron-down"
                        class="group cursor-pointer rounded-xl transition-all duration-200 mx-2 px-3 py-3 flex items-center gap-3 text-sm font-medium text-gray-700
                               hover:bg-indigo-50 hover:text-indigo-700"
                    >
                        {{ __('Products') }}
                    </flux:navlist.item>

                    <flux:navmenu class="rounded-xl shadow-lg border border-zinc-200 bg-white text-gray-800 ml-4 mt-2">
                        <flux:navmenu.item
                            icon="plus"
                            href="{{ route('products.create') }}"
                            :current="request()->routeIs('products.create')"
                            class="px-4 py-3 text-sm hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200"
                            wire:navigate>
                            {{ __('Add Products') }}
                        </flux:navmenu.item>

                        <flux:navmenu.item
                            icon="eye"
                            href="{{ route('products.index') }}"
                            :current="request()->routeIs('products.index')"
                            class="px-4 py-3 text-sm hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200"
                            wire:navigate>
                            {{ __('View Products') }}
                        </flux:navmenu.item>
                    </flux:navmenu>
                </flux:dropdown>
            </flux:navlist>
        </div>

        <!-- Orders -->
        <div class="space-y-1">
            <flux:navlist variant="outline">
                <flux:navlist.item
                    icon="shopping-cart"
                    :href="route('admin.orders.index')"
                    :current="request()->routeIs('admin.orders.index')"
                    class="group rounded-xl transition-all duration-200 mx-2 px-3 py-3 flex items-center gap-3 text-sm font-medium
                           hover:bg-indigo-50 hover:text-indigo-700
                           @if(request()->routeIs('admin.orders.index')) bg-indigo-100 text-indigo-700 shadow-sm @else text-gray-700 @endif"
                    wire:navigate>
                    {{ __('Orders') }}
                </flux:navlist.item>
            </flux:navlist>
        </div>
    </div>

    <!-- User Profile Section (Desktop) -->
    <flux:dropdown class="hidden lg:block" position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            icon-trailing="chevrons-up-down"
        />

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
            />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
</flux:sidebar>
