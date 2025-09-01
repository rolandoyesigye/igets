<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions (idempotent)
        $dashboardPermission = Permission::firstOrCreate(['name' => 'access-dashboard']);
        $adminPermission = Permission::firstOrCreate(['name' => 'admin-access']);

        // Create admin role (idempotent)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions([$dashboardPermission, $adminPermission]);

        // Create default admin user if not exists
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@igets.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Ensure user has admin role
        if (! $adminUser->hasRole($adminRole->name)) {
            $adminUser->assignRole($adminRole);
        }

        // Create regular user role (optional, idempotent)
        $userRole = Role::firstOrCreate(['name' => 'user']);
        // Regular users don't get dashboard access by default
    }
}
