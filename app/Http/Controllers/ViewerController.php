<?php

namespace App\Http\Controllers;

use App\Models\KpiAccess;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalUserKpi = KpiAccess::where('user_id', $user->id)->count();

        // Fetch only KPIs assigned to the logged-in viewer
        if ($user->hasRole('Viewer')) {
            $currentKpiAccess = KpiAccess::with(['kpi.bahagians', 'kpi.states', 'kpi.institutions'])
                ->where('user_id', $user->id)
                ->paginate(10);
        } else {
            // If not a Viewer, show a 403 forbidden page or redirect
            abort(403, 'Unauthorized access');
        }

        $statusCounts = $this->countKpiStatus($currentKpiAccess);
        
        return view('viewer.dashboard.index', compact('currentKpiAccess', 'totalUserKpi', 'statusCounts'));
    }

    public function generateViewerReport(PDF $pdf)
    {
        // Get the logged-in user (Viewer)
        $user = auth()->user();

        // Fetch the KPIs for the viewer
        $currentKpiAccess = KpiAccess::with(['kpi.bahagians', 'kpi.states', 'kpi.institutions'])
            ->where('user_id', $user->id)
            ->get(); // Use `get()` instead of `paginate()` for full report data

        // Calculate the KPI status counts
        $statusCounts = $this->countKpiStatus($currentKpiAccess);

        // Prepare data to pass to the PDF view
        $data = [
            'user' => $user,
            'kpiData' => $currentKpiAccess,
            'statusCounts' => $statusCounts,
        ];

        // Generate the PDF using the viewer-specific data
        $pdf = $pdf->loadView('viewer.reports.index', $data);
        return $pdf->stream('kpi_report.pdf');
    }

    /**
     * Helper method to count KPI statuses (achieved, pending, not achieved)
     */
    private function countKpiStatus($currentKpiAccess)
    {
        $statusCounts = [
            'achieved' => 0,
            'pending' => 0,
            'not achieved' => 0,
        ];

        // Count statuses for each relation
        foreach ($currentKpiAccess as $access) {
            // Count for bahagians
            foreach ($access->kpi->bahagians as $bahagian) {
                $this->incrementStatus($bahagian->pivot->status, $statusCounts);
            }

            // Count for states
            foreach ($access->kpi->states as $state) {
                $this->incrementStatus($state->pivot->status, $statusCounts);
            }

            // Count for institutions
            foreach ($access->kpi->institutions as $institution) {
                $this->incrementStatus($institution->pivot->status, $statusCounts);
            }
        }

        return $statusCounts;
    }

    /**
     * Helper method to increment the appropriate status count
     */
    private function incrementStatus($status, &$statusCounts)
    {
        if ($status == 'achieved') {
            $statusCounts['achieved']++;
        } elseif ($status == 'pending') {
            $statusCounts['pending']++;
        } elseif ($status == 'not achieved') {
            $statusCounts['not achieved']++;
        }
    }
}

