<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div class="space-y-2">
            <x-ui.label for="email">{{ __('Email Address') }}</x-ui.label>
            <x-ui.input
                wire:model="email"
                id="email"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />
            @error('email')
                <p class="text-sm text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <x-ui.button variant="default" type="submit" class="w-full">{{ __('Email password reset link') }}</x-ui.button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-muted-foreground">
        {{ __('Or, return to') }}
        <a href="{{ route('login') }}" class="text-primary hover:underline font-medium" wire:navigate>{{ __('log in') }}</a>
    </div>
</div>
