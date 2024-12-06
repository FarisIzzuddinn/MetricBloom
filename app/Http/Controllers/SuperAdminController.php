<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\Sector;
use App\Models\Bahagian;
use App\Models\KpiState;
use App\Models\Institution;
use App\Models\KpiBahagian;
use Illuminate\Http\Request;
use App\Models\KpiInstitution;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
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
    
        return view('superAdmin.Dashboard.index', compact(
            'username', 'totalKpi', 'totalState', 'totalInstitution', 'totalUser',
            'achievedKpi', 'pendingKpi', 'notAchievedKpi', 'bahagianPerformance', 'bahagianStatus',
            'bahagianWithNames', 'statePerformance', 'stateTrends', 'institutionPerformance', 'institutionStatus',
            'kpiBahagianData', 'achievedPercentage', 'notAchievedPercentage', 'pendingPercentage'
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
    

    // public function index(){
    //     // Dipslay username at navbar 
    //     $username = Auth::User();
        
    //     // Retrieve all bahagians and their corresponding KPIs
    //     $bahagians = Bahagian::with('kpis')->get();

    //     // total KPI
    //     $totalKPI = AddKpi::count(); 

    //     // Get total KPI per bahagian
    //     $kpiBahagianData = DB::table('kpi_bahagian')
    //     ->join('bahagian', 'kpi_bahagian.bahagian_id', '=', 'bahagian.id')
    //     ->select('bahagian.nama_bahagian as name', DB::raw('COUNT(kpi_bahagian.add_kpi_id) as total_kpi'))
    //     ->groupBy('bahagian.id', 'bahagian.nama_bahagian')
    //     ->get();

    //     $totalAchieved = 40; // Total KPIs achieved in this quarter
    //     $totalNotAchieved = 4; // Total KPIs not achieved in this quarter
    //     $totalKpis = $totalAchieved + $totalNotAchieved;

    //     $achievedPercentage = ($totalAchieved / $totalKpis) * 100;
    //     $notAchievedPercentage = ($totalNotAchieved / $totalKpis) * 100;

    //     // new one
    //     $totalBahagian = KpiBahagian::count();
    //     $totalState = KpiState::count();
    //     $totalInstitution = KpiInstitution::count();

    //     // Role-specific KPI performance percentages
    //     $rolePerformance = [
    //         'bahagian' => [
    //             'onTrack' => $totalBahagian > 0 ? (KpiBahagian::where('status', 'on_track')->count() / $totalBahagian) * 100 : 0,
    //             'overdue' => $totalBahagian > 0 ? (KpiBahagian::where('status', 'overdue')->count() / $totalBahagian) * 100 : 0,
    //         ],
    //         'state' => [
    //             'onTrack' => $totalState > 0 ? (KpiState::where('status', 'on_track')->count() / $totalState) * 100 : 0,
    //             'overdue' => $totalState > 0 ? (KpiState::where('status', 'overdue')->count() / $totalState) * 100 : 0,
    //         ],
    //         'institution' => [
    //             'onTrack' => $totalInstitution > 0 ? (KpiInstitution::where('status', 'on_track')->count() / $totalInstitution) * 100 : 0,
    //             'overdue' => $totalInstitution > 0 ? (KpiInstitution::where('status', 'overdue')->count() / $totalInstitution) * 100 : 0,
    //         ],
    //     ];

    //     // KPI summary totals
    //     $kpiStats = [
    //         'total' => $totalBahagian + $totalState + $totalInstitution,
    //         'onTrack' => KpiBahagian::where('status', 'on_track')->count() +
    //                      KpiState::where('status', 'on_track')->count() +
    //                      KpiInstitution::where('status', 'on_track')->count(),
    //         'atRisk' => KpiBahagian::where('status', 'at_risk')->count() +
    //                     KpiState::where('status', 'at_risk')->count() +
    //                     KpiInstitution::where('status', 'at_risk')->count(),
    //         'overdue' => KpiBahagian::where('status', 'overdue')->count() +
    //                      KpiState::where('status', 'overdue')->count() +
    //                      KpiInstitution::where('status', 'overdue')->count(),
    //     ];

        
    //     $kpis = [
    //         'Admin Bahagian' => KpiBahagian::with(['kpi'])->get(),
    //         'Admin State' => KpiState::with(['kpi'])->get(),
    //         'Institution Admin' => KpiInstitution::with(['kpi'])->get(),
    //     ];

    //     // Recent activities (optional, dummy data for now)
    //     $recentActivities = [
    //         ['timestamp' => now(), 'activity' => 'StateAdmin updated KPI ABC'],
    //         ['timestamp' => now(), 'activity' => 'BahagianAdmin completed KPI XYZ'],
    //     ];

        // Get KPI by sector
        // $sectors = Sector::withCount([
        //     'kpis as achieved' => function ($query) {
        //         $query->where('status', 'achieved');
        //     },
        //     'kpis as notAchieved' => function ($query) {
        //         $query->where('status', 'not_achieved');
        //     }
        // ])->get();

        // Get kpi by state
        // $kpisPerState = State::withCount('kpis')->get();

        // Card KPI overview
        // $totalKpi = AddKpi::count();
        // $kpisAchieved = AddKpi::where('peratus_pencapaian', '>=', 100)->count();
        // $kpisOnGoing = AddKpi::whereBetween('peratus_pencapaian', [50, 99])->count();
        // $kpisNotAchieved = AddKpi::whereBetween('peratus_pencapaian', [0, 49])->count();

        // Percentage Kpi based on achieved -> on going -> not achieved
        // $achievedPercentage = $totalKpi > 0 ? round(($kpisAchieved / $totalKpi) * 100, 2) : 0;
        // $onGoingPercentage = $totalKpi > 0 ? round(($kpisOnGoing / $totalKpi) * 100, 2) : 0;
        // $notAchievedPercentage = $totalKpi > 0 ? round(($kpisNotAchieved / $totalKpi) * 100, 2) : 0;

       

        // Reason KPI not achieved
    //     $kpis = AddKpi::where('status', 'not achieved')->get();

    //     // Group by reason and count each group
    //     $reasons = $kpis->groupBy('reason')->map(function ($group) {
    //         return ['reason' => $group->first()->reason, 'total' => $group->count()];
    //     })->values();

    //     // User overview
    //     $totalUser = User::count();
    //     $superAdmin = User::role('Super Admin')->count();
    //     $admin = User::role('Admin')->count();
    //     $stateAdmin = User::role('Admin State')->count();
    //     $institutionAdmin = User::role('Institution Admin')->count();
    //     $user = User::role('User')->count();
    //     $recentUser = User::orderBy('created_at', 'desc')->limit(5)->get();
        

    //     // States overview
    //     $totalState = State::count();
    //     $totalInstitution = Institution::count();
    //     $institutionPerState = State::withCount('institutions')->get();

    //     return view('superAdmin.Dashboard.index', compact(
    //         'username', 
    //         'bahagians',
    //         'totalKPI',
    //         'kpiBahagianData', 
    //         'totalAchieved',
    //         'totalNotAchieved',
    //         'totalKpis',
    //         'achievedPercentage',
    //         'notAchievedPercentage',
    //         'kpiStats',
    //         'recentActivities',
    //         'rolePerformance',
    //         'kpis',
    //         'totalUser',
    //         'superAdmin',
    //         'admin',
    //         'reasons',
    //         'stateAdmin',
    //         'institutionAdmin',
    //         'user',
    //         'recentUser',
    //         'totalState',
    //         'totalInstitution',
    //         'institutionPerState',
    //     ));
    // }
}
