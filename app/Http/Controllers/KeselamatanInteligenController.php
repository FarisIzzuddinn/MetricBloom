<?php

namespace App\Http\Controllers;

use App\Models\KeselamatanInteligen;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;

class KeselamatanInteligenController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $data = KeselamatanInteligen::all();
            $institutions = Institution::all();
            return view('admin.KeselamatanInteligen', ['data' => $data, 'institutions' => $institutions]);
        } else if (Auth::check() && Auth::user()->role === 'superadmin') {
            $data = KeselamatanInteligen::all();
            $institutions = Institution::all();
            return view('superadmin.KeselamatanInteligen', ['data' => $data, 'institutions' => $institutions]);
        } else if (Auth::check()) {
            $data = KeselamatanInteligen::all();
            $institutions = Institution::all();
            return view('user.KeselamatanInteligen', ['data' => $data, 'institutions' => $institutions]);
        }

        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
