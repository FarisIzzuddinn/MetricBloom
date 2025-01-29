<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AddKpi;
use App\Models\KpiAccess;
use Illuminate\Http\Request;



class accessController extends Controller
{
    public function index()
    {
        $userWithRoleViewer = User::role('Viewer')->get(['id', 'name', 'email']);
        $allKpi = AddKpi::select('id', 'pernyataan_kpi')->get();
        $currentKpiAccess = KpiAccess::with('user', 'kpi')->paginate(5);
    
        return view("superAdmin.kpi_access_permission.index", compact(
            'userWithRoleViewer', 'allKpi', 'currentKpiAccess'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kpi_id' => 'required|exists:add_kpis,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Prevent duplicate access
        if (KpiAccess::where('kpi_id', $request->kpi_id)
            ->where('user_id', $request->user_id)
            ->exists()) {   
            return back()->with('status', 'This user already has access to the selected KPI.')->with('alert-type', 'warning');
        }
    
        // Create new access record and set 'assigned_by' to the authenticated user
        KpiAccess::create([
            'kpi_id' => $request->kpi_id,
            'user_id' => $request->user_id,
            'assigned_by' => auth()->id(),  
        ]);
    
        return back()->with('status', 'Access granted successfully.')->with('alert-type', 'success');
    }

    public function destroy($id)
    {
        // Find the KPI access record
        $access = KpiAccess::findOrFail($id);

        // Assign the current authenticated user as the 'deleted_by' user
        $access->deleted_by = auth()->id();
        $access->deleted_at = now();
        $access->save();

        // Optionally, delete the record
        $access->delete();

        return redirect()->back()->with('status', 'KPI access deleted!')->with('alert-type', 'success');
    }
    
    public function filterAccess(Request $request)
    {
        $userWithRoleViewer = User::role('Viewer')->get(['id', 'name', 'email']);
        $allKpi = AddKpi::select('id', 'pernyataan_kpi')->get();
        
        $query = KpiAccess::with(['kpi', 'user', 'assignedBy']);
    
        if ($request->has('search_kpi') && $request->search_kpi) {
            $query->whereHas('kpi', function ($q) use ($request) {
                $q->where('pernyataan_kpi', 'like', '%' . $request->search_kpi . '%');
            });
        }
    
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
    
        $currentKpiAccess = $query->paginate(5);
    
        return view('superAdmin.kpi_access_permission.index', compact(
            'userWithRoleViewer', 'allKpi', 'currentKpiAccess'
        ));
    }
}
