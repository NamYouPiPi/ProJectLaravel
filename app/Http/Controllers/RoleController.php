<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')
                    ->orderBy('id')
                    ->paginate(10);
        return view('ManagementEmployee.Role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            Role::create([
                'name' => Str::slug($request->name),
                'display_name' => $request->display_name,
                'description' => $request->description,
                'is_protected' => false
            ]);

            DB::commit();
            return redirect()->route('roles.index')
                           ->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')
                           ->with('error', 'Error creating role: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        return view('ManagementEmployee.Role.create', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        if ($role->is_protected) {
            return redirect()->route('roles.index')
                           ->with('error', 'Cannot modify protected roles');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => Str::slug($request->name),
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);

            DB::commit();
            return redirect()->route('roles.index')
                           ->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')
                           ->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        if ($role->is_protected) {
            return redirect()->route('roles.index')
                           ->with('error', 'Cannot delete protected roles');
        }

        try {
            DB::beginTransaction();

            // Check if role has users
            if ($role->users()->count() > 0) {
                return redirect()->route('roles.index')
                               ->with('error', 'Cannot delete role with assigned users');
            }

            // Remove role permissions first
            $role->permissions()->detach();

            // Delete the role
            $role->delete();

            DB::commit();
            return redirect()->route('roles.index')
                           ->with('success', 'Role deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('roles.index')
                           ->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }

    public function assignPermissions(Request $request, Role $role)
    {
        if ($role->is_protected) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot modify protected roles'
            ], 403);
        }

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            DB::beginTransaction();

            $role->permissions()->sync($request->permissions);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Permissions assigned successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error assigning permissions: ' . $e->getMessage()
            ], 500);
        }
    }
}
