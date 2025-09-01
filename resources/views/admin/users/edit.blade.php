<x-layouts.app :title="__('Edit User')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Edit User: {{ $user->name }}</h1>

                    @livewire('admin.users.edit-user', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 