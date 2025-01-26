<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\State;
use App\Models\Sector;
use App\Models\Institution;
use App\Models\KpiBahagian;
use Illuminate\Http\Request;
use App\Models\KpiInstitution;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function showDataSectorStatusCard(){
        $sectorId = [1,2,3,4];

        $data = Sector::whereIn('id', $sectorId)
            ->with(['bahagians.kpiBahagian'=> function($query){
                $query->select('bahagian_id', 'status', DB::raw('count(*) as total'))
                ->groupBy('status', 'bahagian_id');
            }])
            ->get();

        // find the total status bahagian in same sector
        $statusSector = $data->map(function($sector){
            $countStatusSector = [
                'achieved' => 0,
                'pending' => 0,
                'not achieved' => 0,
            ];

            foreach($sector->bahagians as $bahagian){
                foreach($bahagian->kpiBahagian as $statusData){
                    if ($statusData->status === 'achieved') {
                        $countStatusSector['achieved'] += $statusData->total;
                    } elseif ($statusData->status === 'pending') {
                        $countStatusSector['pending'] += $statusData->total;
                    } elseif ($statusData->status === 'not achieved') {
                        $countStatusSector['not achieved'] += $statusData->total;
                    }
                }
            }

            $sector->aggregatedStatus = $countStatusSector;

            return $sector;
        });

        return $statusSector;
    }

    // ----------------------- get API data sector details ------------------------

    public function getSectorDetails($id, Request $request)
    {
        $status = $request->query('status'); // Get the status from the query string

        $sector = Sector::with(['bahagians.kpiBahagian' => function($query) use ($status) {
            if ($status) {
                $query->where('status', $status); // Filter the KPI records by the selected status
            }
        }])->find($id);

        if (!$sector) {
            return response()->json(['error' => 'Sector not found'], 404);
        }

        $filteredKPIs = [];
        foreach ($sector->bahagians as $bahagian) {
            foreach ($bahagian->kpiBahagian as $kpi) {
                $filteredKPIs[] = [
                    'pernyataan_kpi' => $kpi->kpi->pernyataan_kpi,
                ];
            }
        }

        return response()->json($filteredKPIs); // Return the filtered KPIs based on the status
    }


    public function index(Request $request){
        $username = Auth::User();

        // statistic card
        $totalState = State::count();
        $totalInstitution = Institution::count();
        $totalUser = User::count();

        // KPI performance overview
        $achievedKpi = $this->getStatusUpdate('achieved');
        $pendingKpi = $this->getStatusUpdate('pending');
        $notAchievedKpi = $this->getStatusUpdate('not achieved');
        $totalKpi = $achievedKpi +  $notAchievedKpi;

        if ($totalKpi > 0) {
            $achievedPercentage = ($achievedKpi / $totalKpi) * 100;
            $pendingPercentage = ($pendingKpi / $totalKpi) * 100;
            $notAchievedPercentage = ($notAchievedKpi / $totalKpi) * 100;
        } else {
            $achievedPercentage = $pendingPercentage = $notAchievedPercentage = 0;
        }
    
        // Fetch optional `status` parameter
        $status = $request->get('status');

        
        if($status){
            // Fetch KPIs from kpi_bahagian
            $kpiBahagian = DB::table('kpi_bahagian')
                ->join('add_kpis', 'kpi_bahagian.add_kpi_id', '=', 'add_kpis.id')
                ->select('add_kpis.id', 'add_kpis.pernyataan_kpi', 'add_kpis.sasaran', 'kpi_bahagian.pencapaian', 'kpi_bahagian.status')
                ->when($status, function ($query, $status) {
                    return $query->where('kpi_bahagian.status', $status);
                })
                ->get();

            // Fetch KPIs from kpi_states
            $kpiStates = DB::table('kpi_states')
                ->join('add_kpis', 'kpi_states.add_kpi_id', '=', 'add_kpis.id')
                ->select('add_kpis.id', 'add_kpis.pernyataan_kpi', 'add_kpis.sasaran', 'kpi_states.pencapaian', 'kpi_states.status')
                ->when($status, function ($query, $status) {
                    return $query->where('kpi_states.status', $status);
                })
                ->get();

            // Fetch KPIs from kpi_institutions
            $kpiInstitutions = DB::table('kpi_institutions')
                ->join('add_kpis', 'kpi_institutions.add_kpi_id', '=', 'add_kpis.id')
                ->select('add_kpis.id', 'add_kpis.pernyataan_kpi', 'add_kpis.sasaran', 'kpi_institutions.pencapaian', 'kpi_institutions.status')
                ->when($status, function ($query, $status) {
                    return $query->where('kpi_institutions.status', $status);
                })
                ->get();

            // Combine all KPIs into one collection
            $kpis = collect()
                ->merge($kpiBahagian)
                ->merge($kpiStates)
                ->merge($kpiInstitutions)
                ->unique('id'); 
            
            return response()->json($kpis);
        }

        // Bahagian KPI Data
        $bahagianPerformance = DB::table('kpi_bahagian')
        ->join('add_kpis', 'kpi_bahagian.add_kpi_id', '=', 'add_kpis.id')
        ->select(
            'kpi_bahagian.bahagian_id',
            DB::raw('AVG(CASE WHEN add_kpis.sasaran > 0 THEN (kpi_bahagian.pencapaian / add_kpis.sasaran * 100) ELSE 0 END) as avg_performance')
        )
        ->groupBy('kpi_bahagian.bahagian_id')
        ->get();

        // Get total KPI per bahagian
        $kpiBahagianData = DB::table('kpi_bahagian')
        ->join('bahagian', 'kpi_bahagian.bahagian_id', '=', 'bahagian.id')
        ->join('add_kpis', 'kpi_bahagian.add_kpi_id', '=', 'add_kpis.id')
        ->select(
            'bahagian.nama_bahagian as name',
            DB::raw('COUNT(kpi_bahagian.add_kpi_id) as total_kpi'),
            DB::raw('JSON_ARRAYAGG(
                JSON_OBJECT(
                    "name", add_kpis.pernyataan_kpi,
                    "target", add_kpis.sasaran,
                    "achievement", kpi_bahagian.pencapaian,
                    "percentage", kpi_bahagian.peratus_pencapaian,
                    "status", kpi_bahagian.status
                )
            ) as kpis')
        )
        ->groupBy('bahagian.id', 'bahagian.nama_bahagian')
        ->get();
    
        // Add 'name' for each bahagian
        $bahagianWithNames = $bahagianPerformance->map(function ($item) {
            $item->name = DB::table('bahagian')->where('id', $item->bahagian_id)->value('nama_bahagian') ?? 'Unknown';
            return $item;
        });

        $bahagianStatus = KpiBahagian::selectRaw('bahagian_id, status, COUNT(*) as count')
        ->groupBy('bahagian_id', 'status')
        ->get();

        // AdminState KPI Data
        $statePerformance = DB::table('kpi_states')
            ->join('add_kpis', 'kpi_states.add_kpi_id', '=', 'add_kpis.id')
            ->select(
                'kpi_states.state_id',
                DB::raw('AVG(CASE WHEN add_kpis.sasaran > 0 THEN (kpi_states.pencapaian / add_kpis.sasaran * 100) ELSE 0 END) as avg_performance')
            )
            ->groupBy('kpi_states.state_id')
            ->get();

        $stateTrends = DB::table('kpi_states')
            ->join('add_kpis', 'kpi_states.add_kpi_id', '=', 'add_kpis.id') // Join based on the relationship
            ->selectRaw('MONTH(kpi_states.updated_at) as month, AVG(kpi_states.pencapaian / add_kpis.sasaran * 100) as avg_performance')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Institution KPI Data
        $institutionPerformance = DB::table('kpi_institutions')
        ->join('add_kpis', 'kpi_institutions.add_kpi_id', '=', 'add_kpis.id')
        ->select(
            'kpi_institutions.institution_id',
            DB::raw('AVG(CASE WHEN add_kpis.sasaran > 0 THEN (kpi_institutions.pencapaian / add_kpis.sasaran * 100) ELSE 0 END) as avg_performance')
        )
        ->groupBy('kpi_institutions.institution_id')
        ->get();
    
        $institutionStatus = KpiInstitution::selectRaw('institution_id, status, COUNT(*) as count')
            ->groupBy('institution_id', 'status')
            ->get();

        // kpi summary
        $summary = DB::table(function ($query) {
            $query->select('states.name as state_name', 'kpi_states.peratus_pencapaian', 'states.id as state_id')
                ->from('kpi_states')
                ->join('states', 'kpi_states.state_id', '=', 'states.id')
                ->unionAll(
                    DB::table('kpi_institutions')
                        ->join('institutions', 'kpi_institutions.institution_id', '=', 'institutions.id')
                        ->join('states', 'institutions.state_id', '=', 'states.id')
                        ->select('states.name as state_name', 'kpi_institutions.peratus_pencapaian', 'states.id as state_id')
                );
        }, 'kpi_data')
        ->select(
            'kpi_data.state_name',
            DB::raw('COUNT(kpi_data.state_id) as total_kpis'),
            DB::raw('AVG(kpi_data.peratus_pencapaian) as average_performance')
        )
        ->groupBy('kpi_data.state_name')
        ->get();
    
        // Prepare drilldown data
        $drilldownData = [];
        $states = DB::table('states')->get();
    
        foreach ($states as $state) {
            // Fetch state-level KPIs
            $stateKpis = DB::table('kpi_states')
                ->join('add_kpis', 'kpi_states.add_kpi_id', '=', 'add_kpis.id')
                ->where('state_id', $state->id)
                ->select(
                    'add_kpis.pernyataan_kpi as name',
                    DB::raw('COALESCE(kpi_states.pencapaian, 0) as target'),
                    DB::raw('COALESCE(kpi_states.peratus_pencapaian, 0) as achievement'),
                    'kpi_states.status'
                )
                ->get();
    
            // Fetch institution-level KPIs
            $institutionKpis = DB::table('kpi_institutions')
                ->join('institutions', 'kpi_institutions.institution_id', '=', 'institutions.id')
                ->join('add_kpis', 'kpi_institutions.add_kpi_id', '=', 'add_kpis.id')
                ->where('institutions.state_id', $state->id)
                ->select(
                    'institutions.name as institution_name',
                    'add_kpis.pernyataan_kpi as name',
                    DB::raw('COALESCE(kpi_institutions.pencapaian, 0) as target'),
                    DB::raw('COALESCE(kpi_institutions.peratus_pencapaian, 0) as achievement'),
                    'kpi_institutions.status'
                )
                ->get();
    
            // Structure the data
            $drilldownData[strtolower($state->name)] = [
                'state_kpis' => $stateKpis,
                'institution_kpis' => $institutionKpis
            ];
        }

        $status = $request->get('status');

        $kpisData = null;
        if ($status) {
            $kpisData = $this->getKpisByStatus($status); // A method for fetching KPIs based on status
        }

        $stateNames = $summary->pluck('state_name');
        $totalKpis = $summary->pluck('total_kpis');
        $averagePerformance = $summary->pluck('average_performance');

        $sectorStatusCard = $this->showDataSectorStatusCard();

        // dd($sectorStatusCard); exit();

        return view('superAdmin.Dashboard.index', compact(
            'username', 'totalKpi', 'totalState', 'totalInstitution', 'totalUser', 'sectorStatusCard',
            'achievedKpi', 'pendingKpi', 'notAchievedKpi', 'bahagianPerformance', 'bahagianStatus',
            'bahagianWithNames', 'statePerformance', 'stateTrends', 'institutionPerformance', 'institutionStatus',
            'kpiBahagianData', 'achievedPercentage', 'notAchievedPercentage', 'pendingPercentage', 'drilldownData',
            'summary', 'stateNames', 'totalKpis', 'averagePerformance'
        ));
    }

    private function getStatusUpdate($status){
        // status kpi bahagian 
        $kpiBahagian = DB::table('kpi_bahagian')
            ->where('status', $status)
            ->count();
    
        // status kpi state 
        $kpiState = DB::table('kpi_states')
            ->where('status', $status)
            ->count();
    
        // status kpi institution 
        $kpiInstitution = DB::table('kpi_institutions')
            ->where('status', $status)
            ->count();

        return $kpiBahagian + $kpiState + $kpiInstitution;
    }
}
