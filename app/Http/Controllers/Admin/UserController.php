<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('roles');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('email', 'like', '%' . $request->input('search') . '%');
        }

        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            session()->flash('error', 'Cannot delete admin users.');
            return redirect()->route('admin.users.index');
        }
        
        $user->delete();
        
        session()->flash('success', 'User deleted successfully.');

        return redirect()->route('admin.users.index');
    }
}


