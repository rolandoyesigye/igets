<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $dashboardPermission = Permission::create(['name' => 'access-dashboard']);
        $adminPermission = Permission::create(['name' => 'admin-access']);

        // Create admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([$dashboardPermission, $adminPermission]);

        // Create default admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@igets.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Assign admin role to the user
        $adminUser->assignRole($adminRole);

        // Create regular user role (optional)
        $userRole = Role::create(['name' => 'user']);
        // Regular users don't get dashboard access by default
    }
}
