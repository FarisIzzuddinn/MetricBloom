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
        $username = auth()->user();
    
        if (!$username) {
            return redirect()->route('login')->with([
                'status' => 'You must be logged in to access this page.',
                'alert-type' => 'warning',
            ]);
        }

        // Fetch user entity
        $userEntity = UserEntity::where('user_id', auth()->id())->first();
    
        // Fetch institution and related KPIs
        $institution = $userEntity && $userEntity->institution_id
            ? Institution::with('kpiInstitutions.kpi')->find($userEntity->institution_id)
            : null;
    
        $kpis = $institution ? $institution->kpiInstitutions : collect();

        // Initialize counts
        $totalKpis = 0;
        $achievedCount = $pendingCount = $notAchievedCount = 0;
    
        if ($institution) {
            $kpis = $institution->kpiInstitutions;
    
            $totalKpis = $kpis->count();
            $achievedCount = $kpis->where('status', 'achieved')->count();
            $pendingCount = $kpis->where('status', 'pending')->count();
            $notAchievedCount = $kpis->where('status', 'not achieved')->count();
        }
    
        // Prepare chart data
        $chartData = $institution
            ? [
                'name' => $institution->name,
                'achieved' => $achievedCount,
                'pending' => $pendingCount,
                'notAchieved' => $notAchievedCount,
                'kpiInstitutions' => $institution->kpiInstitutions->map(function ($kpi) {
                    return [
                        'name' => $kpi->kpi->pernyataan_kpi ?? 'N/A',
                        'target' => $kpi->kpi->sasaran ?? 0,
                        'achievement' => $kpi->pencapaian ?? 0,
                        'status' => $kpi->status ?? 'unknown',
                    ];
                }),
            ]
            : [];
    
        return view('institutionAdmin.dashboard.index', compact(
            'username', 'institution', 'chartData', 'totalKpis', 'achievedCount', 'pendingCount',
            'kpis', 'notAchievedCount'
        ));
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
            'reason' => 'nullable|string',
            'other_reason' => 'required_if:reason,Other|max:255',
            'peratus_pencapaian' => 'nullable|numeric|min:0|max:100',
        ]);

        $kpiInstitution = KpiInstitution::find($request->kpi_institutions_id);
        $kpi = AddKpi::find($kpiInstitution->add_kpi_id);

        $reason = $request->reason === 'Other' ? $request->other_reason : $request->reason;
        $kpiInstitution->pencapaian = $request->pencapaian;
    
        // If peratus_pencapaian is not passed in the request, calculate it based on pencapaian and sasaran
        if ($request->has('peratus_pencapaian')) {
            $kpiInstitution->peratus_pencapaian = $request->peratus_pencapaian;
        } else {
            // Calculate the peratus_pencapaian based on sasaran (target)
            $kpiInstitution->peratus_pencapaian = ($kpiInstitution->pencapaian / $kpi->sasaran) * 100;
        }

        // Dynamically determine the status based on kpi_type (sasaran) and peratus_pencapaian
        if ($kpi->jenis_sasaran == 'peratus') {
            // If the KPI target (sasaran) is percentage-based
            if ($kpiInstitution->peratus_pencapaian >= $kpi->sasaran) {
                $kpiInstitution->status = 'achieved'; // Achieved if peratus_pencapaian >= sasaran
            } elseif ($kpiInstitution->peratus_pencapaian > 0 && $kpiInstitution->peratus_pencapaian < $kpi->sasaran) {
                $kpiInstitution->status = 'pending'; // Pending if between 1 and sasaran
            } else {
                $kpiInstitution->status = 'not achieved'; // Not achieved if 0
            }
        } else {
            // If the KPI target (sasaran) is count-based (numeric)
            if ($kpiInstitution->pencapaian >= $kpi->sasaran) {
                $kpiInstitution->status = 'achieved'; // Achieved if pencapaian >= sasaran
            } elseif ($kpiInstitution->pencapaian > 0 && $kpiInstitution->pencapaian < $kpi->sasaran) {
                $kpiInstitution->status = 'pending'; // Pending if between 1 and sasaran
            } else {
                $kpiInstitution->status = 'not achieved'; // Not achieved if 0
            }
        }

        $kpiInstitution->reason = $reason;
        $kpiInstitution->save();

        return redirect()->back()->with('success', 'KPI achievement updated successfully.');
    }

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
}