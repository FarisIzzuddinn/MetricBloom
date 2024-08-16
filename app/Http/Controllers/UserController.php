<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan senarai pengguna dengan fungsi carian dan penapis peranan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function ($query, $role) {
                return $query->whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role);
                });
            })
            ->get();

        $roles = Role::all()->pluck('name'); // Dapatkan senarai peranan untuk dropdown

        return view('superAdmin.user.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    // Menampilkan borang untuk membuat pengguna baharu
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('superAdmin.user.create', [
            'roles' => $roles
        ]);
    }

    // Menyimpan pengguna baharu ke dalam pangkalan data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with("status", "User created successfully with roles");
    }

    // Menampilkan borang untuk mengedit pengguna
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('superAdmin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    // Mengemaskini maklumat pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with("status", "User updated successfully with the roles");
    }

    // Memadam pengguna dari pangkalan data
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/users')->with("status", "User deleted successfully");
    }
}
