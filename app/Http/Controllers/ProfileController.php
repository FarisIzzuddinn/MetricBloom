<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profileEdit');
    }

    public function store(Request $request)
    {
        //validate incoming request data
        $request->validate([
            'name' => 'required', //name is required
            'email' => 'required', //email is required
            'confirm_password' => 'required_with:password|same:password', //confirm password is required if password is provided
            'avatar' => 'image', //avatar should be an image if uploaded
        ]);

        //get input data from the request
        $input = $request->all();

        if ($request->hasFile('avatar')) {
            //generate a unique name for the avatar file
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            //move the avatar to the public 'avatars' directory
            $request->avatar->move(public_path('avatars'), $avatarName);
            $input['avatar'] = $avatarName;
        } else {
            unset($input['avatar']);
        }

        //password hash
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }

        //update user profile information
        auth()->user()->update($input);

        //redirect back with a success message
        return back()->with('success', 'Profile updated successfully.');
    }
}
