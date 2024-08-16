<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\PengurusanBanduan;

class PengurusanBanduanController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            // User is an admin, proceed with fetching data
            $data = PengurusanBanduan::all();
            return view('admin.PengurusanBanduan', ['data' => $data]);
        }else if (Auth::check() && Auth::user()->role === 'superadmin') {
            $data = PengurusanBanduan::all();
            return view('superadmin.PengurusanBanduan', ['data' => $data]);
        }else {
            $data = PengurusanBanduan::all();
            return view('user.PengurusanBanduan', ['data' => $data]);
        }


        // If the user is not authenticated or is not an admin, redirect them or show an error
        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
