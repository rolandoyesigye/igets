<x-layouts.app :title="__('Create User')">
    <div class="space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-bold tracking-tight text-foreground">Create New User</h1>
                <p class="text-sm font-medium text-muted-foreground">Add a new team member and assign their role.</p>
            </div>
            <x-ui.button variant="outline" :href="route('admin.users.index')" wire:navigate>
                Back to Users
            </x-ui.button>
        </div>

        <x-ui.card class="overflow-hidden shadow-md">
            <div class="p-6">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid gap-6 lg:grid-cols-2">
                        <div class="space-y-2">
                            <x-ui.label for="name">Name</x-ui.label>
                            <x-ui.input id="name" name="name" type="text" value="{{ old('name') }}" required />
                            @error('name') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="email">Email</x-ui.label>
                            <x-ui.input id="email" name="email" type="email" value="{{ old('email') }}" required />
                            @error('email') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-2">
                        <div class="space-y-2">
                            <x-ui.label for="password">Password</x-ui.label>
                            <x-ui.input id="password" name="password" type="password" required autocomplete="new-password" />
                            @error('password') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <x-ui.label for="password_confirmation">Confirm Password</x-ui.label>
                            <x-ui.input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-ui.label for="role">Role</x-ui.label>
                        <select id="role" name="role" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/10">
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="text-xs text-destructive">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <x-ui.button variant="outline" :href="route('admin.users.index')" wire:navigate type="button">
                            Cancel
                        </x-ui.button>
                        <x-ui.button type="submit" variant="default">
                            Create User
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
