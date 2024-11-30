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
        $username = Auth::User();
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
        $addKpis = AddKpi::whereHas('bahagians', function ($query) use ($selectedSectorId) {
            $query->whereHas('sector', function ($sectorQuery) use ($selectedSectorId) {
                $sectorQuery->where('id', $selectedSectorId);
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

        return view('admin.dashboard.index', compact('addKpis', 'username', 'bahagian', 'bahagians', 'sectors', 'selectedSectorId', 'chartData', 'totalNotAchieved', 'totalAchieved'));
    }
    
    public function kpiCompleteRateByState(){
        $states = State::withCount(['kpis as total_kpis_assigned', 'kpis as kpis_completed' => function($query) {
            $query->where('status', 'achieved'); 
        }])->get();
        
        $stateData = $states->map(function ($state) {
            $completionRate = $state->total_kpis_assigned > 0
                ? ($state->kpis_completed / $state->total_kpis_assigned) * 100
                : 0;
            return [
                'state' => $state->name,
                'completionRate' => $completionRate
            ];
        });

        return $stateData;
    }

    public function getKpiDataByState($state)
    {
        // Fetch KPIs based on the selected state
        $kpis = AddKpi::where('negeri', $state)->get();
        
        // Prepare labels and data
        $labels = $kpis->pluck('kpi')->toArray();
        $data = $kpis->pluck('peratus_pencapaian')->toArray();
        
        // Return the data in JSON format
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
 
