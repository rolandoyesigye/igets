<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="max-w-2xl">
    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 space-y-6">
            <div class="space-y-4">
                <div class="grid gap-2">
                    <x-ui.label for="name">{{ __('Name') }}</x-ui.label>
                    <x-ui.input 
                        wire:model="name" 
                        id="name" 
                        type="text" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        placeholder="Your full name"
                    />
                    @error('name') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="email">{{ __('Email') }}</x-ui.label>
                    <x-ui.input 
                        wire:model="email" 
                        id="email" 
                        type="email" 
                        required 
                        autocomplete="email" 
                        placeholder="email@example.com"
                    />
                    @error('email') <p class="text-xs text-destructive">{{ $message }}</p> @enderror

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                        <div class="mt-2 text-sm">
                            <p class="text-muted-foreground">
                                {{ __('Your email address is unverified.') }}
                                <button type="button" class="text-primary hover:underline font-medium ml-1" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Resend verification email') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-xs font-medium text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-ui.button variant="default" type="submit">
                    {{ __('Save Changes') }}
                </x-ui.button>

                <x-action-message class="text-sm text-muted-foreground italic" on="profile-updated">
                    {{ __('Settings saved successfully.') }}
                </x-action-message>
            </div>
        </form>

        <div class="border-t pt-8">
            <livewire:settings.delete-user-form />
        </div>
    </x-settings.layout>
</section>
