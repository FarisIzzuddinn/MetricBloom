<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use App\Models\Bahagian;
use App\Models\KpiBahagian;
use App\Models\Sector;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSectorController extends Controller
{
    
    public function index(Request $request)
    {
        $username = Auth::User();
        $user = auth()->user(); // Get the currently logged-in user

        // Check if the user is associated with a Bahagian
        if (!$user->userEntity || !$user->userEntity->sector_id) {
            return redirect()->back()->withErrors('No Bahagian is associated with your account.');
        }

        $sector = $user->userEntity->sector; // Get the user's Bahagian
        $bahagianId = $sector->bahagian_id; // Get the sector ID for the Bahagian
        $bahagians = Bahagian::all(); // Get all sectors for the dropdown filter

        // Get the selected sector ID from the request, defaulting to the user's sector
        $selectedBahagianId = $request->input('bahagian_id', $bahagianId);

        // Retrieve KPIs for all Bahagians in the selected sector
        $addKpis = AddKpi::whereHas('bahagians', function ($query) use ($selectedBahagianId) {
            $query->whereHas('sector', function ($sectorQuery) use ($selectedBahagianId) {
                $sectorQuery->where('id', $selectedBahagianId);
            });
        })->get();

        $sectorId = 1; // Example: Sektor Keselamatan dan Koreksional
        $bahagians = Bahagian::where('sector_id', $sectorId)->get();
    
        $chartData = $bahagians->map(function ($bahagian) {
            $achieved = $bahagian->addKpis()->wherePivot('status', 'achieved')->count();
            $notAchieved = $bahagian->addKpis()->wherePivot('status', 'not achieved')->count();
    
            return [
                'name' => $bahagian->nama_bahagian,
                'achieved' => $achieved,
                'notAchieved' => $notAchieved,
                'color' => '#' . substr(md5($bahagian->id), 0, 6),
            ];
        });
    
        $totalAchieved = $chartData->sum('achieved');
        $totalNotAchieved = $chartData->sum('notAchieved');


        return view('adminSector.dashboard.index', compact('addKpis', 'username', 'bahagians', 'selectedBahagianId', 'chartData', 'totalNotAchieved', 'totalAchieved'));
    }
    
}
