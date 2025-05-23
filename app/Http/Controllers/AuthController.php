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
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Check if user is inactive
            // if ($user->status === 'inactive') {
            //     Auth::logout(); // Log them out immediately
            //     return back()->withErrors([
            //         'email' => 'Your account is inactive.<br>Please contact an administrator.',
            //     ]);                
            // }
            
            // Continue with the login process for active users
            $request->session()->put('login', true);
            // $user->last_login_at = now();
            $user->save();
    
            if ($user->hasRole('super admin', 'web')) {
                return redirect()->route('infografik.index')->with('success', 'Login Success');
            } elseif ($user->hasRole('admin', 'web')) {
                return redirect()->route('infografik.index')->with('success', 'Login Success');
            } elseif ($user->hasRole('Admin State', 'web')) {
                return redirect()->route('infografik.index')->with('success', 'Login Success');
            } elseif ($user->hasRole('Institution Admin', 'web')) {
                return redirect()->route('infografik.index')->with('success', 'Login Success');
            } elseif ($user->hasRole('Admin Bahagian', 'web')) {
                return redirect()->route('infografik.index')->with('success', 'Login Success');
            } elseif ($user->hasRole('Admin Sector', 'web')) {
                return redirect()->route('infografik.index')->with('success', 'Login Success');
            }  elseif ($user->hasRole('Viewer', 'web')) {
                return redirect()->route('viewerDashboard')->with('success', 'Login Success');
            } 
            
            return redirect()->route('login');
        }
    
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
    
        // Clear session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to login with cache prevention
        return redirect()->route('login')->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',
        ]);
    }

    public function unauthorized()
    {
        return response()->view('errors.403', [], 403);
    }

}
