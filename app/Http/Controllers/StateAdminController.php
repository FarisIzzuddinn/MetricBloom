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
        $stateId = auth()->user()->state_id; // Assuming user has a state_id attribute
        $state = State::with('kpis')->find($stateId);

        $kpis = $state->kpis; // Fetching KPIs linked to the state

        // Additional data for KPI summary
        $totalKpis = AddKpi::where('state_id', $stateId)->count();

        $achievedKpis = AddKpi::where('state_id', $stateId)
                              ->where('peratus_pencapaian', '>=', 75)
                              ->count();
    
        $pendingKpis = AddKpi::where('state_id', $stateId)
                             ->where('peratus_pencapaian', '>=', 0)
                             ->where('peratus_pencapaian', '<', 75)
                             ->count();
    
        $averageAchievement = ($totalKpis > 0) ? round(($achievedKpis / $totalKpis) * 100) : 0;

        return view('stateAdmin.dashboard.index', compact('totalKpis', 'achievedKpis', 'pendingKpis', 'averageAchievement', 'kpis'));
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
    
        return view('stateAdmin.kpi.index', compact('kpis', 'institutions'));
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

        $kpis = AddKpi::with('states')
        ->whereHas('states', function ($query) use ($stateId) {
            $query->where('states.id', $stateId); // Specify the state table id
        })
        ->get();

        return view('stateAdmin.kpi.create', compact('institutions', 'kpis'));
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
