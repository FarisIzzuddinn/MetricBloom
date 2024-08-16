<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function register()
    {
        // Fetch all roles for selection in the registration form
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role to the user
        $role = Role::where('name', $request->role)->first();
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User */
            $user = Auth::user();

            // Check user role and redirect accordingly
            if ($user->hasRole('super admin')) {
                return redirect()->route('permissions.index')->with('success', 'Login Success');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('admin.index')->with('success', 'Login Success');
            } else {
                return redirect()->route('user.kpi.input')->with('success', 'Login Success');
            }
        }

        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
