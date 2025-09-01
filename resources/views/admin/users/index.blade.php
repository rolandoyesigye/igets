<x-layouts.app :title="__('User Management')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">User Management</h1>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table id="usersTable" class="w-full table-auto">
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
                                                <button onclick="if(confirm('Are you sure?')) window.location.href='{{ route('admin.users.destroy', $user) }}'"
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
