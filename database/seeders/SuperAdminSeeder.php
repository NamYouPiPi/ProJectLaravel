<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the super admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();

        if (!$superAdminRole) {
            $this->command->error('Super admin role not found! Please run RolePermissionSeeder first.');
            return;
        }

        // Check if super admin already exists
        $existingSuperAdmin = User::where('email', 'superadmin@cinema.com')->first();

        if ($existingSuperAdmin) {
            $this->command->info('Super admin user already exists!');
            return;
        }

        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@cinema.com',
            'password' => Hash::make('superadmin123'),
            'email_verified_at' => now(),
            'role_id' => $superAdminRole->id,
        ]);

        $this->command->info('Super admin user created successfully!');
        $this->command->info('Email: superadmin@cinema.com');
        $this->command->info('Password: superadmin123');
        $this->command->warn('Please change the default password after first login!');
    }
}
