<?php

namespace App\Http\Controllers;
use App\Models\TahananRadikal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TahananRadikalController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            // User is an admin, proceed with fetching data
            $data = TahananRadikal::all();
            return view('admin.TahananRadikal', ['data' => $data]);
        }else if (Auth::check() && Auth::user()->role === 'superadmin') {
            $data = TahananRadikal::all();
            return view('superadmin.TahananRadikal', ['data' => $data]);
        }else {
            $data = TahananRadikal::all();
            return view('user.TahananRadikal', ['data' => $data]);
        }


        // If the user is not authenticated or is not an admin, redirect them or show an error
        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
