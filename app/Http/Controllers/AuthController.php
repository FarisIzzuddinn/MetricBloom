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
    // public function register()
    // {
    //     return view('auth.register');
    // }

    // public function registerPost(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // Assign role to the user
    //     $user->assignRole('user');

    //     Auth::login($user);

    //     return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    // }

    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                Auth::login($user);
                return $this->redirectToDashboard($user);
            }

            $hashedPassword = hash('sha512', $user->salt . $request->password);
            for ($i = 0; $i < 10000; $i++) {
                $hashedPassword = hash('sha512', $hashedPassword);
            }

            if (password_verify($hashedPassword, $user->password)) {
                Auth::login($user);
                return $this->redirectToDashboard($user);
            }
        }
        return redirect()->back()->withErrors(['email' => 'Wrong email or password'])->withInput();
    }


    /**
     * Redirects the user to their respective dashboard based on their role.
     */
    private function redirectToDashboard($user)
    {
        if ($user->hasRole('super admin', 'web')) {
            return redirect()->route('superAdminDashboard')->with('success', 'Login Success');
        } elseif ($user->hasRole('admin', 'web')) {
            return redirect()->route('admin.index')->with('success', 'Login Success');
        } elseif ($user->hasRole('Admin State', 'web')) {
            return redirect()->route('stateAdmin.dashboard')->with('success', 'Login Success');
        } elseif ($user->hasRole('Institution Admin', 'web')) {
            return redirect()->route('institutionAdmin.dashboard')->with('success', 'Login Success');
        } elseif ($user->hasRole('Admin Bahagian', 'web')) {
            return redirect()->route('admin.index')->with('success', 'Login Success');
        } elseif ($user->hasRole('Admin Sector', 'web')) {
            return redirect()->route('adminSector.index')->with('success', 'Login Success');
        }  elseif ($user->hasRole('Viewer', 'web')) {
            return redirect()->route('viewerDashboard')->with('success', 'Login Success');
        } 
    
        return redirect()->route('unauthorized')->with('error', 'Role not recognized.');
    }
    
    public function unauthorized()
    {
        return response()->view('errors.unauthorized', [], 403);
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
