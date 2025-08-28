<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function indexRoles()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        $permissions = Permission::orderBy('created_at', 'desc')->get();
        return view('pages.roles.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required']);

        $validasiRole = Role::where('name', $request->name)->first();
        if ($validasiRole) {
            return redirect()->back()->with('error', 'Role is ready!');
        }
        Role::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Successfully.');
    }


    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id'
        ]);

        $role->update(['name' => $request->name]);

        $permissions = array_map('intval', $request->input('permissions', []));
        $role->syncPermissions($permissions);

        return response()->json(['success' => 'Successfully']);
    }

    public function destroyRole(string $id)
    {

        $roles = DB::table('roles')->where('id', $id)->delete();

        if ($roles) {
            return response()->json(['success' => 'updated Successfully']);
        } else {
            return response()->json(['error' => 'Role not found or could not be deleted.']);
        }
    }

    // PERMISSIONS
    public function indexPermissions()
    {
        $permissions = Permission::get();
        return view('pages.permissions.index', compact('permissions'));
    }

    public function storePermission(Request $request)
    {
        
        $request->validate(
            ['name' => 'required']
        );

        $validasi = Permission::where('name', $request->name)->first();

        if ($validasi) {
            return redirect()->back()->with('error', 'permission access is ready!');
        }

        Permission::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required']);

        $validasi = Permission::where('name', $request->name)->first();

        if ($validasi) {
            return redirect()->back()->with('error', 'permission access is ready!');
        }

        $permission->update(['name' => $request->name]);
        return response()->json(['success' => 'Permission updated successfully.']);
    }

    public function destroyPermission($id)
    {
        $permission = DB::table('permissions')->where('id', $id)->delete();

        if ($permission) {
            return response()->json(['success' => 'Successfully']);
        } else {
            return response()->json(['error' => 'Permission not found or could not be deleted.']);
        }
    }

    public function getRolePermissions(Role $role)
    {
        return response()->json([
            'permissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }
}
