<x-layouts.app :title="__('User Management')">
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 lg:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                        <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>
                            <p class="text-sm text-gray-600 mt-1">View roles and manage user access</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-xl border border-gray-100">
                        <table id="usersTable" class="w-full table-auto">
                            <thead>
                                <tr class="text-left bg-gray-50">
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600">Name</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600">Email</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600">Role</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600">Joined</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                                    <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wide text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border-b hover:bg-gray-50/50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-2">
                                                <div class="h-10 w-10 rounded-full bg-orange-500/90 flex items-center justify-center text-white font-semibold shadow-sm">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            @foreach($user->roles as $role)
                                                <span class="px-2.5 py-1 text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 rounded mr-1">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if($user->email_verified_at)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">Verified</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">Unverified</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 flex space-x-3">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-orange-700 border border-orange-200 rounded hover:bg-orange-50">Edit</a>
                                            @if(!$user->hasRole('admin'))
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-rose-700 border border-rose-200 rounded hover:bg-rose-50">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-gray-500">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                pageLength: 10,
                order: [],
                language: { search: "Search:" }
            });
        });
    </script>
</x-layouts.app>
