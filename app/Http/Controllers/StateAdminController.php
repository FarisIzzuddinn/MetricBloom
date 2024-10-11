<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StateAdminController extends Controller
{
    public function index()
    {
        // Retrieve the state ID of the logged-in user
        $stateId = auth()->user()->state_id; 
        $username  = Auth::User();

        $chartData  = Auth::User();
    
        // Retrieve all institutions within the state
        $institutions = Institution::where('state_id', $stateId)->get();
    
        // Retrieve the state and its associated KPIs
        $state = State::with('kpis')->find($stateId);
        $kpis = $state->kpis;
    
        // Calculate the total number of KPIs for the given state
        $totalKpis = AddKpi::where('state_id', $stateId)->count();
    
        // Calculate the number of KPIs that have been achieved (progress >= 75%)
        $achievedKpis = AddKpi::where('state_id', $stateId)
                              ->where('peratus_pencapaian', '>=', 75)
                              ->count();
    
        // Calculate the number of KPIs that are still pending (0% <= progress < 75%)
        $pendingKpis = AddKpi::where('state_id', $stateId)
                             ->where('peratus_pencapaian', '<', 75)
                             ->count();
    
        // Calculate the average achievement percentage for all KPIs
        $totalProgress = AddKpi::where('state_id', $stateId)->sum('peratus_pencapaian');
        $averageAchievement = ($totalKpis > 0) ? round($totalProgress / $totalKpis, 2) : 0;

        $kpiCategories = $kpis->pluck('kpi')->unique();
    
        // Calculate KPI progress per institution
        $institutionNames = [];
        $kpiAchievements = [];
        $financialPerformance = [];
        $operationalEfficiency = [];
        $customerSatisfaction = [];
    
        foreach ($institutions as $institution) {
            $institutionNames[] = $institution->name;
    
            // Get KPIs related to this institution
            $kpisGroup = $kpis->where('institution_id', $institution->id);
    
            // Calculate average KPI achievement for each institution
            // $averageProgress = $kpisGroup->count() > 0 ? round($kpisGroup->avg('peratus_pencapaian'), 2) : 0;
            // $kpiAchievements[] = $averageProgress;

            $averageAchievement = $institution->kpis->avg('peratus_pencapaian');
            $kpiAchievements[] =  $averageAchievement ?: 0;
            $chartData  = Auth::User();

    
            // Group KPIs by category
            $financialKpis = $kpisGroup->where('category', 'financial_performance');
            $operationalKpis = $kpisGroup->where('category', 'operational_efficiency');
            $customerKpis = $kpisGroup->where('category', 'customer_satisfaction');
    
            // Calculate average achievement for each category
            $financialPerformance[] = $financialKpis->count() > 0 ? round($financialKpis->avg('peratus_pencapaian'), 2) : 0;
            $operationalEfficiency[] = $operationalKpis->count() > 0 ? round($operationalKpis->avg('peratus_pencapaian'), 2) : 0;
            $customerSatisfaction[] = $customerKpis->count() > 0 ? round($customerKpis->avg('peratus_pencapaian'), 2) : 0;
        }
    

        return view('stateAdmin.dashboard.index', compact('totalKpis','chartData','kpis','username','kpiCategories' ,'achievedKpis', 'pendingKpis', 'averageAchievement', 'institutionNames', 'kpiAchievements', 'financialPerformance', 'operationalEfficiency', 'customerSatisfaction'));
    }
    

    


    public function manageKPI()
    {
        // Get the state ID of the authenticated user
        $stateId = Auth::user()->state_id;

        $username = Auth::user();

    
        // Fetch institutions related to the state
        $institutions = Institution::where('state_id', $stateId)->get();

        // Fetch KPIs associated with the institutions in the user's state
        $kpis = AddKpi::whereHas('institutions', function ($query) use ($stateId) {
            $query->where('state_id', $stateId);
        })->get();
    
        return view('stateAdmin.kpi.index', compact('kpis', 'institutions','username'));
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
}
