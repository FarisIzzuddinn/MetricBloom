<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserKpiController extends Controller
{
    public function index()
    {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();
        $username = Auth::user();

        $addKpi = Auth::user();
    
        // Total KPIs for the logged-in user
        $userTotalKpis = $user->kpis()->count();
    
        // KPIs with achievement percentage >= 75% for the logged-in user
        $userAchievedKpis = $user->kpis()->where('peratus_pencapaian', '>=', 75)->count();
    
        // KPIs with achievement percentage < 75% for the logged-in user
        $userPendingKpis = $user->kpis()->whereBetween('peratus_pencapaian', [0, 75])->count();
    
        // Average achievement percentage for the logged-in user
        $userAverageAchievement = ($userTotalKpis > 0) ? round(($userAchievedKpis / $userTotalKpis) * 100) : 0;
    
        // Get all KPIs related to the logged-in user
       $addKpis = $user->kpis;
    
        // Prepare data for the chart
        $labels = $addKpis->pluck('kpi')->toArray();
        $data = $addKpis->pluck('peratus_pencapaian')->toArray();

        // \log::info('Total KPIs: ' . $userTotalKpis);
        // \Log::info('Achieved KPIs: ' . $userAchievedKpis);
        // \Log::info('Pending KPIs: ' . $userPendingKpis);
            
        // Paparkan ke view
        return view('user.KPI.IndexKPI', compact('addKpis','addKpi', 'labels', 'userTotalKpis', 'userAchievedKpis', 'userPendingKpis', 'userAverageAchievement', 'data', 'user', 'username'));
    }
    
    

    public function storeInput(Request $request)
    {
        // Validate the request data
        $request->validate([
            'kpi_id' => 'required|exists:add_kpis,id',
            'pencapaian' => 'required|numeric',
            'peratus_pencapaian' => 'required|numeric',
            'reason' => 'nullable|string'
        ]);

        // Find the KPI entry
        $kpi = AddKpi::find($request->kpi_id);

        // Update the KPI data
        $kpi->pencapaian = $request->pencapaian;
        $kpi->peratus_pencapaian = $request->peratus_pencapaian;

        // If `peratus_pencapaian` is below the threshold, save the reason
        if ($request->peratus_pencapaian < 100) {
            $kpi->reason = $request->reason;
        } else {
            $kpi->reason = null; // Clear the reason if the KPI is achieved
        }

        $kpi->save();

        // Redirect or return response
        return redirect()->back()->with('success', 'KPI updated successfully!');
    }


    public function edit($id)
    {
        $addKpis = AddKpi::findOrFail($id);
        return view('user.edit', compact('addKpis'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'pencapaian' => 'required|numeric',
            'peratus_pencapaian' => 'required|numeric',
            'reason' => 'nullable|string'
        ]);

        $addKpi = AddKpi::findOrFail($id);
        $addKpi->pencapaian = $request->input('pencapaian');
        $addKpi->peratus_pencapaian = $request->input('peratus_pencapaian');

        // If `peratus_pencapaian` is below the threshold, save the reason
        if ($request->peratus_pencapaian < 100) {
            $addKpi->reason = $request->input('reason');
        } else {
            $addKpi->reason = null; // Clear the reason if the KPI is achieved
        }

        $addKpi->save();

        return redirect()->back()->with('success', 'KPI updated successfully');
    }

    private function validateKpi(Request $request)
    {
        $request->validate([
            'kpi_id' => 'required|exists:add_kpis,id',
            'pencapaian' => 'required|numeric',
        ]);
    }
}
