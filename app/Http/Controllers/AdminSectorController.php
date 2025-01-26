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
            return redirect()->back()->withErrors('No Sector is associated with your account.');
        }
    
        $sector = $user->userEntity->sector; // Get the user's Sector
        $bahagianId = $sector->bahagian_id; // Get the Bahagian ID for the Sector
    
        // Retrieve Bahagians only related to the user's sector
        $bahagians = Bahagian::where('sector_id', $sector->id)
        ->with('kpiBahagian.kpi') 
        ->get();
    
        // Initialize counters
        $totalKpis = 0;
        $achievedKpis = 0;
        $pendingKpis = 0;
        $notAchievedKpis = 0;
    
        // Loop through Bahagians and count the KPIs    
        foreach ($bahagians as $bahagian) {
            // Total KPIs
            $totalKpis += $bahagian->kpiBahagian->count();
            
            // Achieved KPIs (assuming status is 'achiekpiBahagianved' when 100%)
            $achievedKpis += $bahagian->kpiBahagian->where('status', 'achieved')->count();

            // Pending KPIs (assuming status is 'pending' when between 1% and 99%)
            $pendingKpis += $bahagian->kpiBahagian->where('status', 'pending')->count();

            // Not Achieved KPIs (assuming status is 'not achieved' when 0%)
            $notAchievedKpis += $bahagian->kpiBahagian->where('status', 'not achieved')->count();
        }
    
        // Get the selected Bahagian ID from the request, defaulting to the user's Bahagian
        $selectedBahagianId = $request->input('bahagian_id', $bahagianId);
    
        // Retrieve KPIs related to the selected Bahagian
        $addKpis = AddKpi::whereHas('kpiBahagian', function ($query) use ($selectedBahagianId) {
            $query->where('bahagian_id', $selectedBahagianId);
        })->get();
    
        // Retrieve KPI statuses grouped by Bahagian
        $chartData = $bahagians->map(function ($bahagian) {
            // Group the statuses by 'status' field in kpi_bahagian table
            $statuses = $bahagian->kpiBahagian->groupBy('status');
        
            return [
                'name' => $bahagian->nama_bahagian,
                'achieved' => $statuses->get('achieved', collect())->count(),
                'pending' => $statuses->get('pending', collect())->count(),
                'notAchieved' => $statuses->get('not achieved', collect())->count(),
                'color' => '#' . substr(md5($bahagian->id), 0, 6),
                'kpis' => $bahagian->kpiBahagian->map(function ($kpiBahagian) {
                    return [
                        'pernyataan_kpi' => $kpiBahagian->kpi->pernyataan_kpi, // From add_kpis table
                        'sasaran' => $kpiBahagian->kpi->sasaran,               // From add_kpis table
                        'pencapaian' => $kpiBahagian->pencapaian,                  // From kpi_bahagian table
                        'status' => $kpiBahagian->status,
                    ];
                }),
            ];
        });
        
    
        $totalAchieved = $chartData->sum('achieved');
        $totalNotAchieved = $chartData->sum('notAchieved');
    
        return view('adminSector.dashboard.index', compact('addKpis', 'username', 'bahagians', 'selectedBahagianId', 'chartData', 'totalNotAchieved', 'totalAchieved', 'totalKpis', 'achievedKpis', 'pendingKpis', 'notAchievedKpis'));
    }
    
}
