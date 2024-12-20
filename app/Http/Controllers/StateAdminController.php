<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\KpiState;
use App\Models\UserEntity;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StateAdminController extends Controller
{
//     public function index()
// {
//     // Retrieve the state ID of the logged-in user
//     $stateId = auth()->user()->state_id;
//     $username = Auth::user();
//     $chartData = Auth::user();
    
//     // Retrieve all institutions within the state
//     $institutions = Institution::where('state_id', $stateId)->get();
    
//     // Retrieve the state and its associated KPIs
//     $state = State::with('kpis')->find($stateId);
//     $kpis = $state ? $state->kpis : collect(); // Handle if state is null
    
//     // Calculate the total number of KPIs for the given state
//     $totalKpis = $kpis->count();
    
//     // Calculate the number of KPIs that have been achieved (progress >= 100%)
//     $achievedKpis = $kpis->where('peratus_pencapaian', '>=', 100)->count();
    
//     // Calculate the number of KPIs that are still pending (progress < 100%)
//     $pendingKpis = $kpis->where('peratus_pencapaian', '<', 100)->count();
    
//     // Calculate the average achievement percentage for all KPIs
//     $totalProgress = $kpis->sum('peratus_pencapaian');
//     $averageAchievement = ($totalKpis > 0) ? round($totalProgress / $totalKpis, 2) : 0;

//     $kpiCategories = $kpis->pluck('kpi')->unique();

//     $kpiData = $kpis->groupBy('category')->map(function ($group) {
//         return $group->pluck('peratus_pencapaian'); // This will give you the percentage of achievement
//     });
    
//     // Calculate KPI progress per institution
//     $institutionNames = [];
//     $kpiAchievements = [];
//     $financialPerformance = [];
//     $operationalEfficiency = [];
//     $customerSatisfaction = [];
    
//     foreach ($institutions as $institution) {
//         $institutionNames[] = $institution->name;
//         $kpisGroup = $kpis->where('institution_id', $institution->id);
        
//         $averageAchievement = $institution->kpis->avg('peratus_pencapaian');
//         $kpiAchievements[] = $averageAchievement ?: 0;

//         // Group KPIs by category
//         $financialKpis = $kpisGroup->where('category', 'financial_performance');
//         $operationalKpis = $kpisGroup->where('category', 'operational_efficiency');
//         $customerKpis = $kpisGroup->where('category', 'customer_satisfaction');
    
//         // Calculate average achievement for each category
//         $financialPerformance[] = $financialKpis->count() > 0 ? round($financialKpis->avg('peratus_pencapaian'), 2) : 0;
//         $operationalEfficiency[] = $operationalKpis->count() > 0 ? round($operationalKpis->avg('peratus_pencapaian'), 2) : 0;
//         $customerSatisfaction[] = $customerKpis->count() > 0 ? round($customerKpis->avg('peratus_pencapaian'), 2) : 0;
//     }

//     return view('stateAdmin.dashboard.index', compact(
//         'institutions', 'chartData', 'kpiData', 'totalKpis', 
//         'averageAchievement', 'kpis', 'username', 'kpiCategories',
//         'institutionNames', 'kpiAchievements', 'financialPerformance',
//         'operationalEfficiency', 'customerSatisfaction', 'achievedKpis', 'pendingKpis'
//     ));
// }

public function index()
{
    $username = Auth::user();
    $userEntity = UserEntity::where('user_id', Auth::id())->first();

    if (!$userEntity || !$userEntity->state_id) {
        return view('stateAdmin.dashboard.index', [
            'username' => $username,
            'state' => null,
            'institutions' => collect(),
            'kpis' => collect(),
            'chartData' => collect(),
        ]);
    }

    $state = State::find($userEntity->state_id);

    // Retrieve institutions related to the state and load KPIs
    $institutions = Institution::where('state_id', $state->id)
        ->with('kpis') // Use the correct relationship
        ->get();

    // Retrieve KPIs assigned to the state
    $kpis = AddKpi::whereHas('states', function ($query) use ($state) {
        $query->where('state_id', $state->id);
    })->get();

    // Prepare Data for Highcharts
    $chartData = $institutions->map(function ($institution) {
        $totalKpis = $institution->kpis->count();
        $achievedKpis = $institution->kpis->filter(function ($kpi) {
            return $kpi->pivot->status === 'achieved';
        })->count();
    
        $achievement = $totalKpis > 0 ? ($achievedKpis / $totalKpis) * 100 : 0;
    
        return [
            'name' => $institution->name,
            'achievement' => round($achievement, 2),
            'kpis' => $institution->kpis->map(function ($kpi) {
                return [
                    'name' => $kpi->pernyataan_kpi, // Replace with your actual KPI name field
                    'target' => $kpi->sasaran ?? 0, // Assuming 'target' exists in the pivot
                    'achievement' => $kpi->pivot->peratus_pencapaian ?? 0, // Assuming 'achievement' exists in the pivot
                    'status' => $kpi->pivot->status,
                ];
            }),
        ];
    });
    
    
    
    
    

    return view('stateAdmin.dashboard.index', compact('username', 'state', 'institutions', 'kpis', 'chartData'));
}


    public function manageKPI()
    {
        $username = auth::user();
        // Get the logged-in user
        $user = Auth::user();

        // Retrieve the user's entity, which contains the state_id
        $userEntity = UserEntity::where('user_id', $user->id)->first();

        // Check if the user has an associated entity
        if (!$userEntity || !$userEntity->state_id) {
            return redirect()->back()->with('error', 'You are not assigned to any state.');
        }

        // Retrieve the state
        $state = State::find($userEntity->state_id);

        if (!$state) {
            return redirect()->back()->with('error', 'State not found for your assignment.');
        }

        // Fetch KPIs related to the state
        $kpis = KpiState::with('state')
        ->where('state_id', $state->id)
        ->get();

        return view('stateAdmin.kpi.index', compact('state', 'kpis', 'username'));
    }


    public function updateKPI(Request $request)
    {
        $request->validate([
            'kpi_state_id' => 'required|exists:kpi_states,id',
            'pencapaian' => 'required|numeric|min:0',
        ]);
    
        $kpiState = KpiState::find($request->kpi_state_id);
    
        if (!$kpiState) {
            return redirect()->back()->with('error', 'The specified KPI does not exist.');
        }
    
        $kpiState->pencapaian = $request->pencapaian;
        $kpiState->peratus_pencapaian = ($request->pencapaian / $kpiState->kpi->sasaran) * 100;

        if ($kpiState->peratus_pencapaian >= 100) {
            $kpiState->status = 'achieved';
        } elseif ($kpiState->peratus_pencapaian >= 50) {
            $kpiState->status = 'pending';
        } else {
            $kpiState->status = 'not achieved';
        }
    
        $kpiState->save();
    
        return redirect()->back()->with('success', 'KPI updated successfully!');
    }
    
    

    public function assignKPI(Request $request, $kpiId)
    {
        $request->validate([
            'institutions' => 'required|array',
            'institutions.*' => 'exists:institutions,id',
        ]);

        $kpi = AddKpi::findOrFail($kpiId);

        // Sync institutions with the selected KPI
        $kpi->institutions()->sync($request->input('institutions'));

        return redirect()->route('stateAdmin.kpi.manage')->with('success', 'KPI assigned to institutions successfully.');
    }

    public function showAssignKPIForm($kpiId)
    {
        // Fetch all institutions
        $institutions = Institution::all();
        $kpi = AddKpi::findOrFail($kpiId); // Find the specific KPI

        return view('stateAdmin.kpi.assign', compact('kpi', 'institutions'));
    }

    public function create()
    {
        // Fetch institutions for the state
        $institutions = Institution::where('state_id', auth()->user()->state_id)->get();
        $stateId = Auth::user()->state_id;
        $username  = Auth::User();

        $kpis = AddKpi::with('states')
        ->whereHas('states', function ($query) use ($stateId) {
            $query->where('states.id', $stateId); // Specify the state table id
        })
        ->get();

        return view('stateAdmin.kpi.create', compact('institutions','username', 'kpis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kpi_id' => 'required|exists:add_kpis,id',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        $kpi = AddKpi::findOrFail($request->kpi_id);
        $kpi->institutions()->attach($request->institution_id);

        return redirect()->route('stateAdmin.kpi')->with('success', 'KPI assigned to institution successfully!');
    }

    public function edit($id)
    {
        // Fetch the KPI assignment for editing
        $kpiAssignment = Institution::with('kpis')->whereHas('kpis', function ($query) use ($id) {
            $query->where('kpi_id', $id); 
        })->first();
    
        // Fetch institutions for the state
        $institutions = Institution::where('state_id', auth()->user()->state_id)->get();
    
        return view('adminstate.kpis.edit', compact('kpiAssignment', 'institutions'));
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'kpi_id' => 'required|exists:add_kpis,id',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        // Update KPI assignment
        $institution = Institution::find($request->institution_id);
        $institution->kpis()->syncWithoutDetaching([$request->kpi_id]);

        return redirect()->route('admin-state-kpis.index')->with('success', 'KPI updated successfully.');
    }

    public function destroy($id)
    {
        // Find the KPI assignment
        $institution = Institution::whereHas('kpis', function ($query) use ($id) {
            $query->where('kpi_id', $id);
        })->first();
    
        if ($institution) {
            // Detach the KPI from the institution
            $institution->kpis()->detach($id);
            
            return redirect()->route('admin-state-kpis.index')->with('success', 'KPI assignment deleted successfully.');
        }
    
        return redirect()->route('admin-state-kpis.index')->with('error', 'KPI assignment not found.');
    }

    public function chart() 
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get all KPIs assigned to the user
        $addKpis = $user->addKpis;

        // Calculate the total number of KPIs
        $totalKpis = $addKpis->count();
        // Calculate the number of achieved, not started, and in progress KPIs
        $achievedKpis = $addKpis->where('status', 'Achieved')->count();
        $notStartedKpis = $addKpis->where('status', 'Not Started')->count();
        $inProgressKpis = $totalKpis - $achievedKpis - $notStartedKpis;

        // Create chart data
        $chartData = [
            'labels' => ['Achieved', 'Not Started', 'In Progress'],
            'datasets' => [
                [
                    'label' => 'KPI Status',
                    'data' => [$achievedKpis, $notStartedKpis, $inProgressKpis],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
    ];

    // Return chart data
    return response()->json($chartData);
    }
}
