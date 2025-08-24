<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all()->groupBy('group');
        $roles = Role::with('permissions')->get();

        return view('ManagementEmployee.Permission.index', compact('permissions', 'roles'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get all roles except protected ones
            $roles = Role::where('is_protected', false)->get();

            foreach ($roles as $role) {
                $permissionIds = $request->input('permissions.' . $role->id, []);
                $role->permissions()->sync($permissionIds);
            }

            DB::commit();

            return redirect()->route('permissions.index')
                           ->with('success', 'Permissions updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Permission Update Error: ' . $e->getMessage());
            return redirect()->route('permissions.index')
                           ->with('error', 'Error updating permissions. Please try again.');
        }
    }

    public function getRolePermissions(Role $role)
    {
        return response()->json([
            'success' => true,
            'permissions' => $role->permissions->pluck('id')
        ]);
    }

    public function getPermissionsByGroup()
    {
        $permissions = Permission::all()->groupBy('group')->map(function ($group) {
            return $group->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'display_name' => $permission->display_name,
                    'description' => $permission->description
                ];
            });
        });

        return response()->json([
            'success' => true,
            'permissions' => $permissions
        ]);
    }
}
