<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class institutionAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
        $stateId = $user->state_id; // Get the state ID of the logged-in user
        $institutionId = $user->institution_id; // Get the institution ID of the logged-in user

        // Get state details
        $state = State::find($stateId); 
    
        // Fetch KPIs assigned to the institution by State Admin
        $kpis = AddKpi::whereHas('institutions', function ($query) use ($institutionId) {
            $query->where('institution_id', $institutionId);
        })->get();

        // Fetch users (end users) in the institution to whom KPIs can be assigned
        $users = User::where('institution_id', $institutionId)->get(); // Get users of the same institution

        // Count KPIs for the institution
        $totalKPIs = $kpis->count(); // Count of retrieved KPIs
        $achievedKPIs = $kpis->where('status', 'Achieved')->count(); // Count of achieved KPIs
        $notStartedKPIs = $kpis->where('status', 'Not Started')->count(); // Count of not started KPIs

        // Custom method to calculate overall performance
        $overallPerformance = $this->calculateOverallPerformance($institutionId);

        // User statistics
        $totalUsers = User::count(); // Total number of users
        $activeUsers = $user->institution->users()->where('active', true)->count(); // Count of active users
        $inactiveUsers = $user->institution->users()->where('active', false)->count(); // Count of inactive users

        // Prepare data for Sector-wise KPI Breakdown (Bar Chart)
        // $sectors = Sector::where('institution_id', $institutionId)->get(); // Assuming you have a 'Sector' model
        // $sectorKpiData = [];
        // foreach ($sectors as $sector) {
        //     $sectorKpis = $sector->kpis()->where('institution_id', $institutionId)->get(); // Assuming a relationship between Sector and KPIs
        //     $sectorKpiData[] = [
        //         'sector_name' => $sector->name,
        //         'achieved' => $sectorKpis->where('status', 'Achieved')->count(),
        //         'in_progress' => $sectorKpis->where('status', 'In Progress')->count(),
        //         'not_started' => $sectorKpis->where('status', 'Not Started')->count(),
        //     ];
        // }

        // Return view with all necessary data, including users and chart data
        return view('institutionAdmin.dashboard.index', compact(
            'institutionId', 
            'kpis', 
            'user', 
            'state', 
            'totalKPIs', 
            'achievedKPIs', 
            'notStartedKPIs', 
            'overallPerformance', 
            'totalUsers', 
            'activeUsers', 
            'inactiveUsers', 
            'users' // Add users to the view
        ));
    }

    public function assignKpi(Request $request)
{
    // Validate the request
    $request->validate([
        'kpi_id' => 'required|exists:add_kpis,id',
        'user_id' => 'required|array',
        'user_id.*' => 'exists:users,id', // Validate each user ID
    ]);

        // Find the selected KPI
        $kpi = AddKpi::find($request->kpi_id);

        // Attach the selected user to the KPI
        $kpi->users()->attach($request->user_id);

    // Redirect back with a success message
    return redirect()->route('institutionAdmin.kpi') // Change to your desired route
        ->with('success', 'KPI assigned successfully to the selected users.');
}
    
    public function manageKPI()
    {
        // Get the state ID of the authenticated user
        $stateId = Auth::user()->state_id;
    
        // Fetch institutions related to the state
        $institutions = Institution::where('state_id', $stateId)->get();

       // Fetch KPIs associated with the institutions in the user's state
        $kpis = AddKpi::whereHas('institutions', function ($query) use ($stateId) {
            $query->where('state_id', $stateId);
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
        // Fetch all users
        $users = User::all(); 

        // Fetch KPIs associated with the user's state
        $kpis = AddKpi::with('states')
            ->whereHas('states', function ($query) use ($stateId) {
                $query->where('states.id', $stateId);
            })
            ->get();

        return view('institutionAdmin.kpi.create', compact('users', 'kpis'));
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
}
