<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <form wire:submit.prevent="updateUser">
        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" 
                   wire:model.defer="name"
                   id="name"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200 focus:ring-opacity-50"
                   required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email (Read-only) -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" 
                   id="email" 
                   value="{{ $user->email }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"
                   disabled>
        </div>

        <!-- Roles -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Roles</label>
            <div class="mt-2 space-y-2">
                @foreach($roles as $role)
                    <div class="flex items-center">
                        <input type="checkbox" 
                               wire:model.defer="selectedRoles"
                               id="role_{{ $role->id }}" 
                               value="{{ $role->name }}"
                               class="h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                        <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('selectedRoles')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600">
                Update User
            </button>
        </div>
    </form>
</div>
