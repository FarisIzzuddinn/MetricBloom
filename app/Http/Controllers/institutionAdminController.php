<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\Sector;
use App\Models\UserEntity;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\KpiInstitution;
use Illuminate\Support\Facades\Auth;

class institutionAdminController extends Controller
{
    public function index()
    {
        $username  = auth::user();
        // Fetch the user entity for the authenticated user
        $userEntity = UserEntity::where('user_id', Auth::id())->first();

        if ($userEntity && $userEntity->institution_id) {
            // Get the institution using the institution_id
            $institution = Institution::find($userEntity->institution_id);
        } else {
            $institution = null; // No institution assigned
        }

        // Retrieve KPIs for the institution
        $kpis = $institution ? $institution->kpis : collect();
        
        return view('institutionAdmin.dashboard.index', compact('institution', 'kpis', 'username'));
    }

    public function kpiIndex()
    {
        $username = auth::user();
        // Get the logged-in user
        $user = Auth::user();
    
        // Retrieve the user's entity, which contains the institution_id
        $userEntity = UserEntity::where('user_id', $user->id)->first();
    
        // Check if the user has an associated entity
        if (!$userEntity || !$userEntity->institution_id) {
            return redirect()->back()->with('error', 'You are not assigned to any institution.');
        }
    
        // Retrieve the institution
        $institution = Institution::find($userEntity->institution_id);
    
        if (!$institution) {
            return redirect()->back()->with('error', 'Institution not found for your assignment.');
        }
    
        // Fetch KPIs related to the institution
        $kpis = KpiInstitution::with('kpi') // Assuming there is a relation to the KPI model
            ->where('institution_id', $institution->id)
            ->get();
    
        // Return the view with institution and KPIs
        return view('institutionAdmin.kpi.index', compact('institution', 'kpis', 'username'));
    }
    

    public function update(Request $request)
    {
        $request->validate([
            'kpi_institutions_id' => 'required|exists:kpi_institutions,id',
            'pencapaian' => 'required|numeric|min:0',
        ]);

        $kpiInstitution = KpiInstitution::find($request->kpi_institutions_id);
        $kpiInstitution->pencapaian = $request->pencapaian;
        $kpiInstitution->peratus_pencapaian = ($request->pencapaian / $kpiInstitution->kpi->sasaran) * 100;

        if ($kpiInstitution->peratus_pencapaian > 100) {
            $kpiInstitution->status = 'achieved';
        } elseif ($kpiInstitution->peratus_pencapaian > 50) {
            $kpiInstitution->status = 'pending';
        } else {
            $kpiInstitution->status = 'not achieved';
        }
        $kpiInstitution->save();

        return redirect()->back()->with('success', 'KPI achievement updated successfully.');
    }
    // public function index()
    // {
    //     $username = Auth::user();
    //     $user = Auth::user(); // Get the authenticated user
    //     $stateId = $user->state_id; // Get the state ID of the logged-in user
    //     $institutionId = $user->institution_id; // Get the institution ID of the logged-in user

    //     // Get state details
    //     $state = State::find($stateId); 

    //     // Fetch KPIs assigned to the institution by State Admin
    //     $kpis = AddKpi::whereHas('institutions', function ($query) use ($institutionId) {
    //         $query->where('institution_id', $institutionId);
    //     })->get();

    //     // Count KPIs for the institution
    //     $totalKPIs = $kpis->count(); 
    //     $achievedKPIs = $kpis->where('status', 'completed')->count(); 
    //     $notStartedKPIs = $kpis->where('status', 'not achieved')->count(); 

    //     // Calculate completed and pending KPIs
    //     $completedKPIs = $achievedKPIs;
    //     $pendingKPIs = $totalKPIs - $completedKPIs;

    //     // Custom method to calculate overall performance
    //     $overallPerformance = $this->calculateOverallPerformance($institutionId);

    //     // User statistics
    //     $totalUsers = User::count(); 
    //     // $activeUsers = $user->institution->users()->where('active', true)->count(); 
    //     // $inactiveUsers = $user->institution->users()->where('active', false)->count(); 

    //     // $this->chart();

    //     // Calculate the average achievement percentage for all KPIs
    //     $totalProgress = AddKpi::where('institution_id', $institutionId)->sum('peratus_pencapaian');
    //     $averageAchievement = ($totalKPIs > 0) ? round($totalProgress / $totalKPIs, 2) : 0;

    //     // Return view with all necessary data, including chart data
    //     return view('institutionAdmin.dashboard.index', compact(
    //         'username',
    //         'institutionId', 
    //         'kpis', 
    //         'totalKPIs', 
    //         'completedKPIs', // Pass to view
    //         'pendingKPIs',   // Pass to view
    //         'achievedKPIs', 
    //         'notStartedKPIs', 
    //         'overallPerformance', 
    //         'totalUsers', 
    //         'averageAchievement',
            
    //     ));
    // }


    public function assignKpi(Request $request)
{
    // Validate the request
    $request->validate([
        'kpi_id' => 'required|exists:add_kpis,id', // Ensure the KPI exists
        'user_id' => 'required|exists:users,id', // Ensure the user ID exists
    ]);

    // Find the selected KPI
    $kpi = AddKpi::find($request->kpi_id);

    // Attach the selected user to the KPI
    $kpi->users()->attach($request->user_id);

    // Get the currently authenticated user
   
    // Redirect back with a success message
    return redirect()->route('institutionAdmin.kpi')->with('success', 'KPI assigned successfully to the selected user.');
}

    
    public function manageKPI()
    {
        // Get the state ID of the authenticated user
        $stateId = Auth::user()->institution_id;
    
        // Fetch institutions related to the state
        $institutions = Institution::where('state_id', $stateId)->get();

       // Fetch KPIs associated with the institutions in the user's state
        $kpis = AddKpi::whereHas('institutions', function ($query) use ($stateId) {
            $query->where('institution_id', $stateId);
        })->get();
       

        $user = Auth::user();
        $institutionId = $user->institution_id; 
        $users = User::All();
        $username = Auth::user();
        

    
        return view('institutionAdmin.kpi.index', compact( 'kpis', 'institutions', 'users','username'));
    }
    
    private function calculateOverallPerformance()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get all KPIs assigned to the user
        $addKpis = $user->addKpis;

        // Calculate the total number of KPIs
        $totalKpis = $addKpis->count();

        // If no KPIs are assigned, return 0 to avoid division by zero
        if ($totalKpis === 0) {
            return 0;
        }

        // Calculate the sum of achievement percentages for all KPIs
        $totalAchievement = $addKpis->sum('peratus_pencapaian');

        // Calculate the average performance
        $averagePerformance = $totalAchievement / $totalKpis;

        // Round to 2 decimal places if desired
        return round($averagePerformance, 2);
    }


  
    

    public function assignToUsers($kpiId)
    {
        $kpi = AddKpi::findOrFail($kpiId);
        $users = User::where('role', 'sector')->get(); // Assuming you have a 'sector' role

        return view('kpis.assignToUsers', compact('kpi', 'users'));
    }

    public function create()
    {
        $user = Auth::user(); // Get the authenticated user
        $stateId = $user->state_id; // Get the state ID of the logged-in user
        $institutionId = $user->institution_id; // Get the institution ID of the logged-in user
        $username = Auth::user();

    
        // Fetch KPIs associated with the user's state
        $kpis = AddKpi::with('states')
            ->whereHas('states', function ($query) use ($stateId) {
                $query->where('states.id', $stateId);
            })
            ->get();
    
        // Fetch users who belong to the given institution and state and group them by sector
        $usersGroupedBySector = User::where('state_id', $stateId)
            ->where('institution_id', $institutionId)
            ->with('sector') // Assuming a relationship between User and Sector
            ->get()
            ->groupBy(function ($user) {
                return $user->sector ? $user->sector->name : 'Institution Admin'; // Group by sector name or 'No Sector' if not assigned
            });
    
        return view('institutionAdmin.kpi.create', compact('usersGroupedBySector', 'kpis','username'));
    }
    
    public function storeUserKpiAssignment(Request $request, $kpiId)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id', // Validate user IDs
        ]);

        $kpi = AddKpi::findOrFail($kpiId);
        $kpi->users()->sync($request->user_ids); // Sync users with the KPI

        return redirect()->route('kpis.index')->with('success', 'KPI assigned to users successfully.');
    }

    public function destroy($id)
    {
        // Find the KPI assignment
        $user = User::whereHas('kpis', function ($query) use ($id) {
            $query->where('kpi_id', $id);
        })->first();
    
        if ($user) {
            // Detach the KPI from the institution
            $user->kpis()->detach($id);
            
            return redirect()->route('institutionAdmin.kpi')->with('success', 'KPI assignment deleted successfully.');
        }
    
        return redirect()->route('institutionAdmin.kpi')->with('error', 'KPI assignment not found.');
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