<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        return view('superAdmin.role.index', [
            'roles' => $roles
        ]);
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

    public function destroy($roleId){
        $role = Role::find($roleId);
        $role->delete();

        return redirect()->route('roles.index')->with("status", "Roles Delete Successfully");
    }

    public function addPermissionToRole($roleId){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                            ->where('role_has_permissions.role_id', $roleId)        
                            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                            ->all();


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
