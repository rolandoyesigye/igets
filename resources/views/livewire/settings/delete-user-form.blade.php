<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <div class="space-y-1">
        <h3 class="text-lg font-bold text-destructive">{{ __('Delete Account') }}</h3>
        <p class="text-sm text-muted-foreground">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
    </div>

    <x-ui.button 
        variant="destructive" 
        x-data="" 
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Delete Account') }}
    </x-ui.button>

    <x-ui.modal name="confirm-user-deletion">
        <form wire:submit="deleteUser" class="space-y-6">
            <div class="space-y-2">
                <h2 class="text-xl font-bold">{{ __('Are you absolutely sure?') }}</h2>
                <p class="text-sm text-muted-foreground">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="grid gap-2">
                <x-ui.label for="delete_password" class="sr-only">{{ __('Password') }}</x-ui.label>
                <x-ui.input 
                    wire:model="password" 
                    id="delete_password"
                    type="password" 
                    placeholder="Enter your password to confirm"
                    required
                />
                @error('password') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <x-ui.button 
                    variant="outline" 
                    type="button" 
                    x-on:click="$dispatch('close-modal', 'confirm-user-deletion')"
                >
                    {{ __('Cancel') }}
                </x-ui.button>

                <x-ui.button 
                    variant="destructive" 
                    type="submit"
                >
                    {{ __('Permanently Delete Account') }}
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>
</section>
