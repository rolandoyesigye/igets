<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="max-w-2xl">
    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <div class="space-y-6">
            <div class="grid grid-cols-3 gap-4" x-data="{ 
                appearance: localStorage.getItem('appearance') || 'system',
                updateTheme(theme) {
                    this.appearance = theme;
                    localStorage.setItem('appearance', theme);
                    if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                    this.$dispatch('appearance-changed', { theme });
                }
            }">
                <button 
                    @click="updateTheme('light')" 
                    type="button" 
                    :class="appearance === 'light' ? 'border-primary ring-2 ring-primary/20' : 'border-border'"
                    class="group relative flex flex-col items-center justify-between rounded-md border-2 bg-popover p-4 hover:bg-accent hover:text-accent-foreground transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-3 h-6 w-6"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m4.93 19.07 1.41-1.41"/><path d="m17.66 6.34 1.41-1.41"/></svg>
                    <span class="text-sm font-medium">{{ __('Light') }}</span>
                </button>

                <button 
                    @click="updateTheme('dark')" 
                    type="button" 
                    :class="appearance === 'dark' ? 'border-primary ring-2 ring-primary/20' : 'border-border'"
                    class="group relative flex flex-col items-center justify-between rounded-md border-2 bg-popover p-4 hover:bg-accent hover:text-accent-foreground transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-3 h-6 w-6"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                    <span class="text-sm font-medium">{{ __('Dark') }}</span>
                </button>

                <button 
                    @click="updateTheme('system')" 
                    type="button" 
                    :class="appearance === 'system' ? 'border-primary ring-2 ring-primary/20' : 'border-border'"
                    class="group relative flex flex-col items-center justify-between rounded-md border-2 bg-popover p-4 hover:bg-accent hover:text-accent-foreground transition-all"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-3 h-6 w-6"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                    <span class="text-sm font-medium">{{ __('System') }}</span>
                </button>
            </div>
            
            <p class="text-[0.8rem] text-muted-foreground">{{ __('Select the appearance of the application. The system setting will automatically match your operating system colors.') }}</p>
        </div>
    </x-settings.layout>
</section>
