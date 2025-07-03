<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public User $user;
    public string $name = '';
    public array $selectedRoles = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->selectedRoles = $user->getRoleNames()->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'selectedRoles' => 'nullable|array',
        ];
    }

    public function updateUser()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
        ]);

        $this->user->syncRoles($this->selectedRoles);

        session()->flash('success', 'User updated successfully.');

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.edit-user', [
            'roles' => Role::all(),
        ]);
    }
}
