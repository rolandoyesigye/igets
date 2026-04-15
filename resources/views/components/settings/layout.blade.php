<div class="flex items-start max-md:flex-col gap-10">
    <div class="w-full md:w-[220px]">
        <nav class="flex flex-col space-y-1">
            <x-ui.button
                variant="{{ request()->routeIs('settings.profile') ? 'secondary' : 'ghost' }}"
                class="justify-start font-medium w-full"
                :href="route('settings.profile')"
                wire:navigate
            >
                {{ __('Profile') }}
            </x-ui.button>
            <x-ui.button
                variant="{{ request()->routeIs('settings.password') ? 'secondary' : 'ghost' }}"
                class="justify-start font-medium w-full"
                :href="route('settings.password')"
                wire:navigate
            >
                {{ __('Password') }}
            </x-ui.button>
            <x-ui.button
                variant="{{ request()->routeIs('settings.appearance') ? 'secondary' : 'ghost' }}"
                class="justify-start font-medium w-full"
                :href="route('settings.appearance')"
                wire:navigate
            >
                {{ __('Appearance') }}
            </x-ui.button>
        </nav>
    </div>

    <div class="hidden md:block w-px self-stretch bg-border"></div>
    <div class="md:hidden w-full h-px bg-border my-2"></div>

    <div class="flex-1 space-y-6">
        <div class="space-y-0.5">
            <h2 class="text-2xl font-bold tracking-tight">{{ $heading ?? '' }}</h2>
            <p class="text-muted-foreground">{{ $subheading ?? '' }}</p>
        </div>

        <div class="w-full max-w-2xl">
            {{ $slot }}
        </div>
    </div>
</div>
