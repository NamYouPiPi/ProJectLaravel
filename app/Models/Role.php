<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description', 'is_protected'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }


     public function givePermissionTo($permissionName)
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission && !$this->hasPermission($permissionName)) {
            $this->permissions()->attach($permission->id);
        }
    }

    // Remove permission from role
    public function revokePermissionTo($permissionName)
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }

    // Sync permissions
    public function syncPermissions($permissions)
    {
        $permissionIds = Permission::whereIn('name', $permissions)->pluck('id');
        $this->permissions()->sync($permissionIds);
    }
}
