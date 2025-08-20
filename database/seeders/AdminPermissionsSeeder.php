<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'manage roles',
            'manage movies',
            'manage screenings',
            'manage bookings',
            'view reports',
            // Add any other permissions your application needs
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Get admin role
        $adminRole = Role::where('name', 'admin')->first();
        
        if ($adminRole) {
            // Assign all permissions to admin role
            $adminRole->syncPermissions(Permission::all());
            $this->command->info('Admin role has been granted all permissions.');
        } else {
            $this->command->error('Admin role not found.');
        }
    }
}
