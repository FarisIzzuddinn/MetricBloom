<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            $request->session()->regenerate();
            return redirect('all/infografik')->with('success', 'Login Successfull!');
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }
}
