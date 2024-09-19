<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(15);

        return view('superAdmin.permission.index', [
            'permissions' => $permissions,
            'username' => Auth::user(),
        ]);
    }

    public function create(){
        return view('superAdmin.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')->with('status', 'Permission created successfully.');
    }

    public function edit(Permission $permission){
        return view('superAdmin.permission.edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,' . $permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')->with('status', 'Permission updated successfully.');
    }

    public function renumberItems()
    {
        $items = Permission::orderBy('created_at')->get();
        foreach ($items as $index => $item) {
            $item->update(['position' => $index + 1]);
        }
    }

    public function destroy($permissionId){
        $permission = Permission::find($permissionId);
        $permission->delete();
        $this->renumberItems();

        return redirect()->route('permissions.index')->with("status", "Permission Delete Successfully");
    }
}
    

