<?php
// app/Providers/BladeServiceProvider.php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Role directive
        Blade::if('role', function ($role) {
            $user = auth()->user();
            return $user && $user->hasRole($role);
        });

        // Any role directive
        Blade::if('anyrole', function ($roles) {
            $user = auth()->user();
            if (!$user) return false;

            $roles = is_array($roles) ? $roles : func_get_args();
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
            return false;
        });

        // Permission directive
        Blade::if('permission', function ($permission) {
            $user = auth()->user();
            return $user && $user->hasPermission($permission);
        });

        // Any permission directive
        Blade::if('anypermission', function ($permissions) {
            $user = auth()->user();
            if (!$user) return false;

            $permissions = is_array($permissions) ? $permissions : func_get_args();
            foreach ($permissions as $permission) {
                if ($user->hasPermission($permission)) {
                    return true;
                }
            }
            return false;
        });

        // All permissions directive
        Blade::if('allpermissions', function ($permissions) {
            $user = auth()->user();
            if (!$user) return false;

            $permissions = is_array($permissions) ? $permissions : func_get_args();
            foreach ($permissions as $permission) {
                if (!$user->hasPermission($permission)) {
                    return false;
                }
            }
            return true;
        });
    }
}
