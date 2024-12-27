<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\AddKpi;
use App\Models\Sector;
use App\Models\Bahagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }
    
    public function index(Request $request)
    {
        $username = Auth::user();
        $user = auth()->user(); // Get the currently logged-in user
    
        // Check if the user is associated with a Bahagian
        if (!$user->userEntity || !$user->userEntity->bahagian_id) {
            return redirect()->back()->withErrors('No Bahagian is associated with your account.');
        }
    
        $bahagian = $user->userEntity->bahagian; // Get the user's Bahagian
        $sectorId = $bahagian->sector_id; // Get the sector ID for the Bahagian
        $sectors = Sector::all(); // Get all sectors for the dropdown filter
    
        // Get the selected sector ID from the request, defaulting to the user's sector
        $selectedSectorId = $request->input('sector_id', $sectorId);
    
        // Retrieve KPIs for all Bahagians in the selected sector
        $addKpis = \App\Models\KpiBahagian::all();
    
        // Assuming Bahagian model has a 'sector_id' relationship with sectors
        $bahagians = Bahagian::where('sector_id', $selectedSectorId)->get();
    
        // Prepare chart data for each Bahagian
        $chartData = $bahagians->map(function ($bahagian) {
            // Fetch all KPIs for the Bahagian
            $kpis = $bahagian->addKpis; // Fetch the related KPIs
        
            // Calculate the number of achieved, pending, and not achieved KPIs
            $achieved = $kpis->where('pivot.status', 'achieved')->count();
            $pending = $kpis->where('pivot.status', 'pending')->count();
            $notAchieved = $kpis->where('pivot.status', 'not achieved')->count();
        
            // Return chart data for each Bahagian including the KPI details
            return [
                'name' => $bahagian->nama_bahagian,
                'achieved' => $achieved,
                'pending' => $pending,
                'notAchieved' => $notAchieved,
                'color' => '#' . substr(md5($bahagian->id), 0, 6), // Generate color based on Bahagian ID
                'kpis' => $kpis->map(function ($kpi) {
                    // Return each KPI's details including the status and other information
                    return [
                        'pernyataan_kpi' => $kpi->pernyataan_kpi,
                        'sasaran' => $kpi->sasaran,
                        'pencapaian' => $kpi->pivot->pencapaian,
                        'status' => $kpi->pivot->status, // Assuming the status is in the pivot table
                    ];
                }),
            ];
        });
        
    
        // Calculate total achieved and not achieved KPIs across all Bahagians
        $totalAchieved = $chartData->sum('achieved');
        $totalNotAchieved = $chartData->sum('notAchieved');
    
        return view('admin.dashboard.index', compact(
            'addKpis', 'username', 'bahagian', 'bahagians', 
            'sectors', 'selectedSectorId', 'chartData', 'totalNotAchieved', 'totalAchieved'
        ));
    }
}
 
