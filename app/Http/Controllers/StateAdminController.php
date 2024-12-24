<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\Report;
use App\Models\KpiState;
use Barryvdh\DomPDF\PDF;
use App\Models\UserEntity;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StateAdminController extends Controller
{
    public function generateReportInstitutions(Request $request, $stateId)
{
    $username = Auth::user();

    // Fetch the state with related institutions and KPIs
    $state = State::with(['institutions.kpis' => function ($query) {
        $query->withPivot(['quarter', 'status', 'pencapaian', 'peratus_pencapaian']);
    }])->findOrFail($stateId);

    // Get filters
    $quarter = $request->get('quarter', null);

    // Generate reports
    $reports = $state->institutions->map(function ($institution) use ($quarter) {
        $kpis = $institution->kpis;

        // Log all KPIs before filtering
        logger()->debug('All KPIs for Institution with Pivot:', $kpis->toArray());

        // Filter KPIs by the selected quarter
        if ($quarter) {
            $quarter = (int) $quarter; // Ensure quarter is an integer
            $kpis = $kpis->filter(fn($kpi) => (int) $kpi->pivot->quarter === $quarter);
        }

        // Log filtered KPIs
        logger()->debug('Filtered KPIs: ', $kpis->toArray());

        return [
            'institution_name' => $institution->name,
            'achieved' => $kpis->where('pivot.status', 'achieved')->count(),
            'not_achieved' => $kpis->where('pivot.status', 'not achieved')->count(),
            'pending' => $kpis->where('pivot.status', 'pending')->count(),
        ];
    });

    // Log reports
    logger()->debug('Reports: ', $reports->toArray());

    // Pass data to the view
    return view('stateAdmin.reports.index', compact('state', 'reports', 'quarter', 'username'));
}

    
public function exportStateReportToPdf(PDF $pdf, $stateId)
{
    // Assuming $stateId is passed from the controller or route
    $quarter = request('quarter');
    $institutionId = request('institution_id');

    // Fetch the report data based on raw SQL query
    $reports = DB::select(
        "SELECT 
            'Institution' AS type,
            ak.pernyataan_kpi AS kpi_statement,
            i.name AS entity_name,
            ki.institution_id AS entity_id,
            ki.pencapaian,
            ki.peratus_pencapaian,
            ki.status,
            ki.quarter
        FROM kpi_institutions ki
        JOIN institutions i ON ki.institution_id = i.id
        JOIN add_kpis ak ON ki.add_kpi_id = ak.id
        WHERE (? IS NULL OR ki.institution_id = ?)
        AND (? IS NULL OR ki.quarter = ?)
        AND (? IS NULL OR i.state_id = ?)",
        [$institutionId, $institutionId, $quarter, $quarter, $stateId, $stateId]
    );

    // Fetch state data
    $state = State::find($stateId); 

    // Pass data to the view and generate the PDF
    $pdf = $pdf->loadView('stateAdmin.reports.pdf', compact('state', 'reports'));

    // Download the generated PDF
    return $pdf->download('state_performance_report.pdf');
}

    
    

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
