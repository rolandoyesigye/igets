<x-layouts.app :title="__('User Management')">
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-bold tracking-tight text-foreground">
                    User Management
                </h1>
                <p class="text-sm font-medium text-muted-foreground">
                    Manage users, roles, and permissions across your platform.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col items-end px-4 border-r">
                    <span class="text-xs font-semibold text-muted-foreground uppercase tracking-wider">Total Users</span>
                    <span class="text-sm font-bold">{{ $users->total() }}</span>
                </div>
                <x-ui.button variant="default" :href="route('admin.users.create')" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Add New User
                </x-ui.button>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Verified Users</h3>
                    <div class="bg-green-100 dark:bg-green-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 dark:text-green-400"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $users->where('email_verified_at', '!=', null)->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Confirmed accounts</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Unverified</h3>
                    <div class="bg-yellow-100 dark:bg-yellow-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-600 dark:text-yellow-400"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $users->where('email_verified_at', null)->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Pending verification</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">Administrators</h3>
                    <div class="bg-purple-100 dark:bg-purple-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600 dark:text-purple-400"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1">Full access users</p>
            </x-ui.card>

            <x-ui.card class="p-6 transition-all hover:border-primary/50 group">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-muted-foreground">New This Month</h3>
                    <div class="bg-blue-100 dark:bg-blue-900/40 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="16" x2="22" y1="11" y2="11"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                <p class="text-xs text-muted-foreground mt-1 text-green-600 font-medium">+{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }} growth</p>
            </x-ui.card>
        </div>

        <!-- Users Table Section -->
        <x-ui.card class="overflow-hidden shadow-md">
            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between border-b gap-4">
                <div>
                    <h3 class="text-lg font-semibold">All Users</h3>
                    <p class="text-sm text-muted-foreground">Manage accounts, roles, and verification status.</p>
                </div>
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                    <x-ui.input name="search" id="userSearch" value="{{ request('search') }}" placeholder="Search users..." class="max-w-[300px]" />
                    <x-ui.button variant="outline" type="submit" size="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" x2="16.65" y1="21" y2="16.65"/></svg>
                    </x-ui.button>
                </form>
            </div>

            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&_tr]:border-b bg-muted/30">
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">User</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Role</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">Joined</th>
                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        @forelse($users as $user)
                            <tr class="border-b transition-colors hover:bg-muted/50 user-row" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
                                <td class="p-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold">{{ $user->name }}</span>
                                            <span class="text-xs text-muted-foreground">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($user->roles as $role)
                                            <x-ui.badge variant="secondary" class="text-[10px] py-0 px-2">
                                                {{ $role->name }}
                                            </x-ui.badge>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="p-4 align-middle">
                                    <x-ui.badge :variant="$user->email_verified_at ? 'default' : 'secondary'" class="gap-1">
                                        @if($user->email_verified_at)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        @endif
                                        {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                    </x-ui.badge>
                                </td>
                                <td class="p-4 align-middle hidden md:table-cell">
                                    <div class="flex flex-col">
                                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                                        <span class="text-[10px] text-muted-foreground">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-ui.button variant="ghost" size="icon" :href="route('admin.users.edit', $user)" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground hover:text-primary transition-colors"><path d="M12 22h6.5"/><path d="M12 14.5l6.469-6.469a1 1 0 0 0-1.414-1.414L10.586 13.086a1 1 0 0 0-.293.707V15.5h1.707a1 1 0 0 0 .707-.293Z"/></svg>
                                        </x-ui.button>
                                        @if(!$user->hasRole('admin'))
                                            <x-ui.button
                                                variant="ghost"
                                                size="icon"
                                                type="button"
                                                class="group user-delete-button"
                                                data-delete-url="{{ route('admin.users.destroy', $user) }}"
                                                data-user-name="{{ $user->name }}"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground group-hover:text-destructive transition-colors"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </x-ui.button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-24 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="bg-muted p-4 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                        </div>
                                        <h3 class="text-xl font-bold">No users found</h3>
                                        <p class="text-muted-foreground">Try adjusting your search or filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-6 border-t">
                    {{ $users->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>

    <x-ui.modal name="confirm-delete-user">
        <form id="user-delete-form" method="POST" action="" class="space-y-6">
            @csrf
            @method('DELETE')

            <div class="space-y-2">
                <h2 class="text-xl font-bold text-destructive">Confirm delete</h2>
                <p class="text-sm text-muted-foreground">
                    Are you sure you want to delete <span id="delete-user-name" class="font-semibold"></span>? This action cannot be undone.
                </p>
            </div>

            <div class="flex justify-end gap-3">
                <x-ui.button
                    variant="outline"
                    type="button"
                    x-on:click="$dispatch('close-modal', 'confirm-delete-user')"
                >
                    Cancel
                </x-ui.button>

                <x-ui.button variant="destructive" type="submit">
                    Delete User
                </x-ui.button>
            </div>
        </form>
    </x-ui.modal>

</x-layouts.app>
