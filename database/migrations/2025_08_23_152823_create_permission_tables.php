<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->boolean('is_protected')->default(false);
            $table->timestamps();
        });

        // Permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Role-Permission pivot table
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);
        });

        // Add role_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('avatar')->nullable()->constrained()->onDelete('set null');
        });

        // Insert default data
        $this->seedDefaultData();
    }

    private function seedDefaultData()
    {
        $now = now();

        // Insert default roles
        $roles = [
            ['name' => 'superadmin', 'display_name' => 'Super Administrator', 'description' => 'Has full system access', 'is_protected' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Has administrative privileges', 'is_protected' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'manager', 'display_name' => 'Manager', 'description' => 'Can manage content and bookings', 'is_protected' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'employee', 'display_name' => 'Employee', 'description' => 'Regular staff member', 'is_protected' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'customer', 'display_name' => 'Customer', 'description' => 'External customer', 'is_protected' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('roles')->insert($roles);

        // Clean permissions array (REMOVED DUPLICATES)
        $permissions = [
            // Suppliers
            ['name' => 'view_suppliers', 'display_name' => 'View Suppliers', 'description' => 'Can view suppliers list', 'group' => 'suppliers'],
            ['name' => 'create_suppliers', 'display_name' => 'Create Suppliers', 'description' => 'Can create new suppliers', 'group' => 'suppliers'],
            ['name' => 'edit_suppliers', 'display_name' => 'Edit Suppliers', 'description' => 'Can edit existing suppliers', 'group' => 'suppliers'],
            ['name' => 'delete_suppliers', 'display_name' => 'Delete Suppliers', 'description' => 'Can delete suppliers', 'group' => 'suppliers'],

            // Inventory
            ['name' => 'view_inventory', 'display_name' => 'View Inventory', 'description' => 'Can view inventory list', 'group' => 'inventory'],
            ['name' => 'create_inventory', 'display_name' => 'Create Inventory', 'description' => 'Can create new inventory items', 'group' => 'inventory'],
            ['name' => 'edit_inventory', 'display_name' => 'Edit Inventory', 'description' => 'Can edit existing inventory items', 'group' => 'inventory'],
            ['name' => 'delete_inventory', 'display_name' => 'Delete Inventory', 'description' => 'Can delete inventory items', 'group' => 'inventory'],

            // Employees
            ['name' => 'view_employees', 'display_name' => 'View Employees', 'description' => 'Can view employees list', 'group' => 'employees'],
            ['name' => 'create_employees', 'display_name' => 'Create Employees', 'description' => 'Can create new employees', 'group' => 'employees'],
            ['name' => 'edit_employees', 'display_name' => 'Edit Employees', 'description' => 'Can edit existing employees', 'group' => 'employees'],
            ['name' => 'delete_employees', 'display_name' => 'Delete Employees', 'description' => 'Can delete employees', 'group' => 'employees'],

            // Movies
            ['name' => 'view_movies', 'display_name' => 'View Movies', 'description' => 'Can view movies list', 'group' => 'movies'],
            ['name' => 'create_movies', 'display_name' => 'Create Movies', 'description' => 'Can create new movies', 'group' => 'movies'],
            ['name' => 'edit_movies', 'display_name' => 'Edit Movies', 'description' => 'Can edit existing movies', 'group' => 'movies'],
            ['name' => 'delete_movies', 'display_name' => 'Delete Movies', 'description' => 'Can delete movies', 'group' => 'movies'],
            ['name' => 'search_movies', 'display_name' => 'Search Movies', 'description' => 'Can search movies', 'group' => 'movies'],
            ['name' => 'filter_movies', 'display_name' => 'Filter Movies', 'description' => 'Can filter movies', 'group' => 'movies'],
            ['name' => 'sort_movies', 'display_name' => 'Sort Movies', 'description' => 'Can sort movies', 'group' => 'movies'],

            // Genres
            ['name' => 'view_genres', 'display_name' => 'View Genres', 'description' => 'Can view genres list', 'group' => 'genres'],
            ['name' => 'create_genres', 'display_name' => 'Create Genres', 'description' => 'Can create new genres', 'group' => 'genres'],
            ['name' => 'edit_genres', 'display_name' => 'Edit Genres', 'description' => 'Can edit existing genres', 'group' => 'genres'],
            ['name' => 'delete_genres', 'display_name' => 'Delete Genres', 'description' => 'Can delete genres', 'group' => 'genres'],
            ['name' => 'filter_genres', 'display_name' => 'Filter Genres', 'description' => 'Can filter genres', 'group' => 'genres'],
            ['name' => 'search_genres', 'display_name' => 'Search Genres', 'description' => 'Can search genres', 'group' => 'genres'],

            // Sales
            ['name' => 'view_sales', 'display_name' => 'View Sales', 'description' => 'Can view sales data', 'group' => 'sales'],
            ['name' => 'create_sales', 'display_name' => 'Create Sales', 'description' => 'Can create new sales records', 'group' => 'sales'],
            ['name' => 'edit_sales', 'display_name' => 'Edit Sales', 'description' => 'Can edit existing sales records', 'group' => 'sales'],
            ['name' => 'delete_sales', 'display_name' => 'Delete Sales', 'description' => 'Can delete sales records', 'group' => 'sales'],

            // Classification
            ['name' => 'view_classification', 'display_name' => 'View Classification', 'description' => 'Can view classification', 'group' => 'classification'],
            ['name' => 'create_classification', 'display_name' => 'Create Classification', 'description' => 'Can create classification', 'group' => 'classification'],
            ['name' => 'edit_classification', 'display_name' => 'Edit Classification', 'description' => 'Can edit classification', 'group' => 'classification'],
            ['name' => 'delete_classification', 'display_name' => 'Delete Classification', 'description' => 'Can delete classification', 'group' => 'classification'],

            // Hall Locations
            ['name' => 'view_hall_locations', 'display_name' => 'View Hall Locations', 'description' => 'Can view hall locations', 'group' => 'hall_locations'],
            ['name' => 'create_hall_locations', 'display_name' => 'Create Hall Locations', 'description' => 'Can create new hall locations', 'group' => 'hall_locations'],
            ['name' => 'edit_hall_locations', 'display_name' => 'Edit Hall Locations', 'description' => 'Can edit existing hall locations', 'group' => 'hall_locations'],
            ['name' => 'delete_hall_locations', 'display_name' => 'Delete Hall Locations', 'description' => 'Can delete hall locations', 'group' => 'hall_locations'],
            ['name' => 'search_hall_locations', 'display_name' => 'Search Hall Locations', 'description' => 'Can search hall locations', 'group' => 'hall_locations'],
            ['name' => 'export_hall_locations', 'display_name' => 'Export Hall Locations', 'description' => 'Can export hall locations', 'group' => 'hall_locations'],
            ['name' => 'filter_hall_locations', 'display_name' => 'Filter Hall Locations', 'description' => 'Can filter hall locations', 'group' => 'hall_locations'],
            ['name' => 'city_hall_locations', 'display_name' => 'City Hall Locations', 'description' => 'Can manage city hall locations', 'group' => 'hall_locations'],
            ['name' => 'state_hall_locations', 'display_name' => 'State Hall Locations', 'description' => 'Can manage state hall locations', 'group' => 'hall_locations'],
            ['name' => 'country_hall_locations', 'display_name' => 'Country Hall Locations', 'description' => 'Can manage country hall locations', 'group' => 'hall_locations'],

            // Hall Cinemas
            ['name' => 'view_hall_cinemas', 'display_name' => 'View Hall Cinemas', 'description' => 'Can view hall cinemas', 'group' => 'hall_cinemas'],
            ['name' => 'create_hall_cinemas', 'display_name' => 'Create Hall Cinemas', 'description' => 'Can create new hall cinemas', 'group' => 'hall_cinemas'],
            ['name' => 'edit_hall_cinemas', 'display_name' => 'Edit Hall Cinemas', 'description' => 'Can edit existing hall cinemas', 'group' => 'hall_cinemas'],
            ['name' => 'delete_hall_cinemas', 'display_name' => 'Delete Hall Cinemas', 'description' => 'Can delete hall cinemas', 'group' => 'hall_cinemas'],
            ['name' => 'search_hall_cinemas', 'display_name' => 'Search Hall Cinemas', 'description' => 'Can search hall cinemas', 'group' => 'hall_cinemas'],

            // Hall Seats
            ['name' => 'view_hall_seats', 'display_name' => 'View Hall Seats', 'description' => 'Can view hall seats', 'group' => 'hall_seats'],
            ['name' => 'create_hall_seats', 'display_name' => 'Create Hall Seats', 'description' => 'Can create new hall seats', 'group' => 'hall_seats'],
            ['name' => 'edit_hall_seats', 'display_name' => 'Edit Hall Seats', 'description' => 'Can edit existing hall seats', 'group' => 'hall_seats'],
            ['name' => 'delete_hall_seats', 'display_name' => 'Delete Hall Seats', 'description' => 'Can delete hall seats', 'group' => 'hall_seats'],

            // Hall Seat Types
            ['name' => 'view_hall_seat_types', 'display_name' => 'View Hall Seat Types', 'description' => 'Can view hall seat types', 'group' => 'hall_seat_types'],
            ['name' => 'create_hall_seat_types', 'display_name' => 'Create Hall Seat Types', 'description' => 'Can create new hall seat types', 'group' => 'hall_seat_types'],
            ['name' => 'edit_hall_seat_types', 'display_name' => 'Edit Hall Seat Types', 'description' => 'Can edit existing hall seat types', 'group' => 'hall_seat_types'],
            ['name' => 'delete_hall_seat_types', 'display_name' => 'Delete Hall Seat Types', 'description' => 'Can delete hall seat types', 'group' => 'hall_seat_types'],

            // Showtimes
            ['name' => 'view_showtimes', 'display_name' => 'View Showtimes', 'description' => 'Can view showtimes', 'group' => 'showtimes'],
            ['name' => 'create_showtimes', 'display_name' => 'Create Showtimes', 'description' => 'Can create new showtimes', 'group' => 'showtimes'],
            ['name' => 'edit_showtimes', 'display_name' => 'Edit Showtimes', 'description' => 'Can edit existing showtimes', 'group' => 'showtimes'],
            ['name' => 'delete_showtimes', 'display_name' => 'Delete Showtimes', 'description' => 'Can delete showtimes', 'group' => 'showtimes'],

            // Bookings
            ['name' => 'view_bookings', 'display_name' => 'View Bookings', 'description' => 'Can view bookings', 'group' => 'bookings'],
            ['name' => 'create_bookings', 'display_name' => 'Create Bookings', 'description' => 'Can create new bookings', 'group' => 'bookings'],
            ['name' => 'edit_bookings', 'display_name' => 'Edit Bookings', 'description' => 'Can edit existing bookings', 'group' => 'bookings'],
            ['name' => 'delete_bookings', 'display_name' => 'Delete Bookings', 'description' => 'Can delete bookings', 'group' => 'bookings'],
            ['name' => 'cancel_bookings', 'display_name' => 'Cancel Bookings', 'description' => 'Can cancel bookings', 'group' => 'bookings'],

            // Payments (CONSOLIDATED - removed duplicates)
            ['name' => 'view_payments', 'display_name' => 'View Payments', 'description' => 'Can view payments', 'group' => 'payments'],
            ['name' => 'process_payments', 'display_name' => 'Process Payments', 'description' => 'Can process payments', 'group' => 'payments'],
            ['name' => 'refund_payments', 'display_name' => 'Refund Payments', 'description' => 'Can process refunds', 'group' => 'payments'],
            ['name' => 'view_payment_reports', 'display_name' => 'View Payment Reports', 'description' => 'Can view payment reports', 'group' => 'payments'],
            ['name' => 'export_payment_reports', 'display_name' => 'Export Payment Reports', 'description' => 'Can export payment reports', 'group' => 'payments'],
            ['name' => 'print_payment_reports', 'display_name' => 'Print Payment Reports', 'description' => 'Can print payment reports', 'group' => 'payments'],
            ['name' => 'download_payment_reports', 'display_name' => 'Download Payment Reports', 'description' => 'Can download payment reports', 'group' => 'payments'],
            ['name' => 'success_payment_reports', 'display_name' => 'Success Payment Reports', 'description' => 'Can view successful payment reports', 'group' => 'payments'],

            // Users
            ['name' => 'view_users', 'display_name' => 'View Users', 'description' => 'Can view users', 'group' => 'users'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'description' => 'Can create users', 'group' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'description' => 'Can edit users', 'group' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'description' => 'Can delete users', 'group' => 'users'],

            // Roles
            ['name' => 'view_roles', 'display_name' => 'View Roles', 'description' => 'Can view roles', 'group' => 'roles'],
            ['name' => 'create_roles', 'display_name' => 'Create Roles', 'description' => 'Can create roles', 'group' => 'roles'],
            ['name' => 'edit_roles', 'display_name' => 'Edit Roles', 'description' => 'Can edit roles', 'group' => 'roles'],
            ['name' => 'delete_roles', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles', 'group' => 'roles'],

            // Audit
            ['name' => 'view_audit_logs', 'display_name' => 'View Audit Logs', 'description' => 'Can view audit logs', 'group' => 'audit'],
            ['name' => 'export_audit_logs', 'display_name' => 'Export Audit Logs', 'description' => 'Can export audit logs', 'group' => 'audit'],

            // Dashboard & Reports
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'description' => 'Can view dashboard', 'group' => 'dashboard'],
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'description' => 'Can view reports', 'group' => 'reports'],
        ];

        // Add timestamps to permissions
        foreach ($permissions as &$permission) {
            $permission['created_at'] = $now;
            $permission['updated_at'] = $now;
        }

        DB::table('permissions')->insert($permissions);

        // Assign permissions to roles
        $this->assignRolePermissions();
    }

    private function assignRolePermissions()
    {
        // Get roles
        $superadminRole = DB::table('roles')->where('name', 'superadmin')->first();
        $adminRole = DB::table('roles')->where('name', 'admin')->first();
        $managerRole = DB::table('roles')->where('name', 'manager')->first();
        $employeeRole = DB::table('roles')->where('name', 'employee')->first();
        $customerRole = DB::table('roles')->where('name', 'customer')->first();

        $allPermissionIds = DB::table('permissions')->pluck('id');

        // Manager permissions (exclude sensitive permissions)
        $managerPermissionIds = DB::table('permissions')
            ->whereNotIn('name', [
                'delete_users', 'create_users', 'delete_roles',
                'create_roles', 'edit_roles', 'view_audit_logs',
                'export_audit_logs'
            ])
            ->pluck('id');

        // Employee permissions
        $employeePermissionIds = DB::table('permissions')
            ->whereIn('name', [
                'view_movies', 'edit_movies', 'search_movies', 'filter_movies',
                'view_inventory', 'edit_inventory',
                'view_showtimes', 'edit_showtimes',
                'view_bookings', 'create_bookings', 'edit_bookings',
                'view_payments', 'process_payments'
            ])
            ->pluck('id');

        // Customer permissions
        $customerPermissionIds = DB::table('permissions')
            ->whereIn('name', [
                'view_movies', 'search_movies', 'filter_movies',
                'view_showtimes', 'create_bookings', 'edit_bookings',
                'process_payments', 'view_payment_reports'
            ])
            ->pluck('id');

        // Assign permissions
        $rolePermissions = [
            $superadminRole->id => $allPermissionIds,
            $adminRole->id => $allPermissionIds, // Admin gets all for now
            $managerRole->id => $managerPermissionIds,
            $employeeRole->id => $employeePermissionIds,
            $customerRole->id => $customerPermissionIds,
        ];

        foreach ($rolePermissions as $roleId => $permissionIds) {
            foreach ($permissionIds as $permissionId) {
                DB::table('role_permission')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
