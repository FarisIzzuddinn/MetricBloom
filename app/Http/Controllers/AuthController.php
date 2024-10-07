<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
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
        $user->assignRole('user');

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
        } elseif ($user->hasRole('Admin State')) {
            return redirect()->route('stateAdmin.dashboard')->with('success', 'Login Success');
        } elseif ($user->hasRole('Institution Admin')) {
            return redirect()->route('institutionAdmin.dashboard')->with('success', 'Login Success');
        } else {
            return redirect()->route('user.kpi.input')->with('success', 'Login Success');
        }
    }

    // Authentication failed
    return redirect()->back()->withErrors(['email' => 'wrong email or password'])->withInput();
}


    public function edit($id) {
        // $user = auth()->user();
        return view('profileEdit', [
            'username' => Auth::user(),
        ]);
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'password' => 'nullable|max:30',
        ]);
        if($request->password != '') {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $user = auth()->user();
        $user->fill($data);
        $user->save();
        // session()->flash('success', 'Data is saved');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
