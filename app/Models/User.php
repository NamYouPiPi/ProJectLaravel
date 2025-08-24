<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role_id'
        ,'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permissionName)
    {
        if (!$this->role) return false;

        return $this->role->hasPermission($permissionName);
    }

    public function hasAnyPermission($permissions)
    {
        if (!$this->role) return false;

        foreach ((array)$permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasAllPermissions($permissions)
    {
        if (!$this->role) return false;

        foreach ((array)$permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    public function isSuperAdmin()
    {
        return $this->role && $this->role->name === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->role && in_array($this->role->name, ['superadmin', 'admin']);
    }

    public function isCustomer()
    {
        return $this->role && $this->role->name === 'customer';
    }

        public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->role_id = $role->id;
            $this->save();
        }
    }

    // Helper method to remove role
    public function removeRole()
    {
        $this->role_id = null;
        $this->save();
    }

}
