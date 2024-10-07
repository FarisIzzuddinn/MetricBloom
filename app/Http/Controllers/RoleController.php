<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        $permissions = Permission::all();
        $username = Auth::user();
    
        // Initialize an array to store role permissions
        $rolePermissions = [];
    
        foreach ($roles as $role) {
            // Fetch the permissions for each role
            $rolePermissions[$role->id] = $role->permissions->pluck('id')->toArray();
        }
    
        return view('superAdmin.role.index', compact('roles', 'permissions', 'rolePermissions'  , 'username'));
    }
    
    public function create(){
        return view('superAdmin.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect()->route('roles.index')->with('status', 'Roles created successfully.');
    }

    public function edit(Role $role){
        return view('superAdmin.role.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id
            ]
        ]);

        $role->update([
            'name' => $request->name
        ]);

        return redirect()->route('roles.index')->with('status', 'Roles updated successfully.');
    }

    public function destroy($id)
{
    $role = Role::findOrFail($id);
    $role->delete();
    
    return redirect()->back()->with('success', 'Role deleted successfully.');
}

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::all();
        $role = Role::findOrFail($roleId);
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('superAdmin.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function updatePermissionToRole(Request $request, $roleId){
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permissions added to the roles');
    }
}
