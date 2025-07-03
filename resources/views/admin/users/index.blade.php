<x-layouts.app :title="__('User Management')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>

        <div class="flex items-center">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search users..."
                   class="rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50">
        </div>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead>
                <tr class="text-left bg-gray-50">
                    <th class="px-6 py-3 text-xs font-bold uppercase">Name</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase">Email</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase">Role</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase">Joined</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase">Status</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <div class="h-10 w-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded mr-1">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @if($user->email_verified_at)
                                <span class="text-green-700 text-xs font-semibold">Verified</span>
                            @else
                                <span class="text-red-700 text-xs font-semibold">Unverified</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-orange-600 hover:underline">Edit</a>
                            @if(!$user->hasRole('admin'))
                                <button wire:click="deleteUser({{ $user->id }})"
                                        onclick="return confirm('Are you sure?')"
                                        class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editUser(userId) {
            // Implement edit functionality
            window.location.href = `/admin/users/${userId}/edit`;
        }
    </script>
    @endpush
</x-layouts.app> 