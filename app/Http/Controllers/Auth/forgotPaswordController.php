<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class forgotPaswordController extends Controller
{
    public function forgotPassword(){
        return view('auth.forgotPassword');
    }

    public function sendResetEmailLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // send reset link
        $status = Password::sendResetLink($request->only('email'));

        // respond status (no info leak)
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)]) : back()->withErrors(['error' => __($status)]);
    }
}
