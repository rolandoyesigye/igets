<x-layouts.app :title="__('Edit User')">
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 lg:p-8 text-gray-900">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Edit User</h1>
                            <p class="text-sm text-gray-600 mt-1">{{ $user->name }} · {{ $user->email }}</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-gray-700 border border-gray-200 rounded hover:bg-gray-50">Back</a>
                    </div>

                    @livewire('admin.users.edit-user', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 