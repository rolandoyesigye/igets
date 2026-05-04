<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="max-w-2xl">
    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6">
            <div class="space-y-4">
                <div class="grid gap-2">
                    <x-ui.label for="current_password">{{ __('Current password') }}</x-ui.label>
                    <x-ui.input
                        wire:model="current_password"
                        id="current_password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    @error('current_password') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="password">{{ __('New password') }}</x-ui.label>
                    <x-ui.input
                        wire:model="password"
                        id="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimum 8 characters"
                    />
                    @error('password') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="password_confirmation">{{ __('Confirm Password') }}</x-ui.label>
                    <x-ui.input
                        wire:model="password_confirmation"
                        id="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    @error('password_confirmation') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-ui.button variant="default" type="submit">
                    {{ __('Update Password') }}
                </x-ui.button>

                <x-action-message class="text-sm text-muted-foreground italic" on="password-updated">
                    {{ __('Password updated successfully.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
