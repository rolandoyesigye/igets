<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        // Prevent deleting admin users
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete admin users.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}


