<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $kpis = $user->kpis; 

        if ($kpis === null) {
            $kpis = collect(); // If no KPIs, use an empty collection
        }
        
        return view('viewer.dashboard.index', compact('kpis'));
    }
}
