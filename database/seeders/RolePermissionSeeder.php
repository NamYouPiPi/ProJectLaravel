<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        $permissions = [
            // Customer permissions
            ['name' => 'view movies', 'display_name' => 'View Movies', 'group' => 'movies'],
            ['name' => 'book tickets', 'display_name' => 'Book Tickets', 'group' => 'bookings'],
            ['name' => 'view own bookings', 'display_name' => 'View Own Bookings', 'group' => 'bookings'],
            ['name' => 'cancel booking', 'display_name' => 'Cancel Booking', 'group' => 'bookings'],
            ['name' => 'view profile', 'display_name' => 'View Profile', 'group' => 'users'],
            ['name' => 'update profile', 'display_name' => 'Update Profile', 'group' => 'users'],
            ['name' => 'make payment', 'display_name' => 'Make Payment', 'group' => 'payments'],

            // Employee permissions
            ['name' => 'view all bookings', 'display_name' => 'View All Bookings', 'group' => 'bookings'],
            ['name' => 'checkin customers', 'display_name' => 'Check-in Customers', 'group' => 'bookings'],
            ['name' => 'manage seats', 'display_name' => 'Manage Seats', 'group' => 'seats'],
            ['name' => 'block seats', 'display_name' => 'Block Seats', 'group' => 'seats'],
            ['name' => 'release seats', 'display_name' => 'Release Seats', 'group' => 'seats'],
            ['name' => 'view customers', 'display_name' => 'View Customers', 'group' => 'customers'],
            ['name' => 'search movies', 'display_name' => 'Search Movies', 'group' => 'movies'],
            ['name' => 'view hall locations', 'display_name' => 'View Hall Locations', 'group' => 'locations'],
            ['name' => 'view analytics', 'display_name' => 'View Analytics', 'group' => 'analytics'],

            // Admin permissions
            ['name' => 'manage movies', 'display_name' => 'Manage Movies', 'group' => 'movies'],
            ['name' => 'manage showtimes', 'display_name' => 'Manage Showtimes', 'group' => 'showtimes'],
            ['name' => 'manage bookings', 'display_name' => 'Manage Bookings', 'group' => 'bookings'],
            ['name' => 'manage seats', 'display_name' => 'Manage Seats', 'group' => 'seats'],
            ['name' => 'manage customers', 'display_name' => 'Manage Customers', 'group' => 'customers'],
            ['name' => 'manage employees', 'display_name' => 'Manage Employees', 'group' => 'employees'],
            ['name' => 'manage users', 'display_name' => 'Manage Users', 'group' => 'users'],
            ['name' => 'manage roles', 'display_name' => 'Manage Roles', 'group' => 'roles'],
            ['name' => 'manage permissions', 'display_name' => 'Manage Permissions', 'group' => 'permissions'],
            ['name' => 'manage payments', 'display_name' => 'Manage Payments', 'group' => 'payments'],
            ['name' => 'manage suppliers', 'display_name' => 'Manage Suppliers', 'group' => 'suppliers'],
            ['name' => 'manage inventory', 'display_name' => 'Manage Inventory', 'group' => 'inventory'],
            ['name' => 'manage sales', 'display_name' => 'Manage Sales', 'group' => 'sales'],
            ['name' => 'manage hall locations', 'display_name' => 'Manage Hall Locations', 'group' => 'locations'],
            ['name' => 'manage genres', 'display_name' => 'Manage Genres', 'group' => 'genres'],
            ['name' => 'manage classifications', 'display_name' => 'Manage Classifications', 'group' => 'classifications'],
            ['name' => 'view all analytics', 'display_name' => 'View All Analytics', 'group' => 'analytics'],
            ['name' => 'system administration', 'display_name' => 'System Administration', 'group' => 'system'],

            // Super Admin permissions (additional)
            ['name' => 'super administration', 'display_name' => 'Super Administration', 'group' => 'system'],
            ['name' => 'manage system settings', 'display_name' => 'Manage System Settings', 'group' => 'system'],
            ['name' => 'view system logs', 'display_name' => 'View System Logs', 'group' => 'system'],
            ['name' => 'backup system', 'display_name' => 'Backup System', 'group' => 'system'],
            ['name' => 'restore system', 'display_name' => 'Restore System', 'group' => 'system'],
            ['name' => 'manage all roles', 'display_name' => 'Manage All Roles', 'group' => 'roles'],
            ['name' => 'delete any data', 'display_name' => 'Delete Any Data', 'group' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // Create roles
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'display_name' => 'Super Administrator',
            'description' => 'Ultimate system administrator with all permissions',
            'is_protected' => true
        ]);

        // Assign permissions to customer role
        $customerPermissions = Permission::whereIn('name', [
            'view movies',
            'book tickets',
            'view own bookings',
            'cancel booking',
            'view profile',
            'update profile',
            'make payment'
        ])->get();

        $customerRole->permissions()->sync($customerPermissions->pluck('id'));

        // Assign permissions to employee role
        $employeePermissions = Permission::whereIn('name', [
            'view movies',
            'view all bookings',
            'checkin customers',
            'manage seats',
            'block seats',
            'release seats',
            'view customers',
            'search movies',
            'view hall locations',
            'view analytics',
            'make payment'
        ])->get();

        $employeeRole->permissions()->sync($employeePermissions->pluck('id'));

        // Assign all permissions to admin role
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Assign all permissions to super admin role (including additional super admin permissions)
        $superAdminRole->permissions()->sync($allPermissions->pluck('id'));

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
