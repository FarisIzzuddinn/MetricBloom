<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\AddKpi;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }
    
    public function index()
    {
        // Retrieve data from the Kpi model
        $addKpis = AddKpi::orderBy('bil')->get();
        $totalKpis = AddKpi::count();
        $achievedKpis = AddKpi::where('peratus_pencapaian', '>=', '75')->count();
        $pendingKpis = AddKpi::where('peratus_pencapaian', '>=', 0)
                                ->where('peratus_pencapaian', '<', 75)
                                ->count();
        $averageAchievement = ($totalKpis > 0) ? round(($achievedKpis / $totalKpis) * 100) : 0;

        // Kira purata peratus pencapaian
        $totalAchievement = $addKpis->sum('peratus_pencapaian');
        $totalKpis = $addKpis->count();
 
        if ($totalKpis > 0) {
            $averageAchievement = number_format($totalAchievement / $totalKpis, 2);
        } else {
            $averageAchievement = number_format(0, 2);
        }
 
         // Tentukan status berdasarkan purata pencapaian
         $status = $averageAchievement >= 50 ? 'Hijau' : 'Merah';

         $kpis = AddKpi::all();
         $labels = $kpis->pluck('kpi')->toArray();
         $data = $kpis->pluck('peratus_pencapaian')->toArray();
    
         $username  = Auth::User();

         $stateData = $this->kpiCompleteRateByState();
         // Hantar data ke view
         return view('admin.dashboard.index', compact('addKpis', 'stateData', 'averageAchievement', 'pendingKpis', 'totalKpis', 'achievedKpis', 'username', 'status' , 'labels',  'data'));
    }

    public function kpiCompleteRateByState(){
        $states = State::withCount(['kpis as total_kpis_assigned', 'kpis as kpis_completed' => function($query) {
            $query->where('status', 'achieved'); 
        }])->get();
        
        $stateData = $states->map(function ($state) {
            $completionRate = $state->total_kpis_assigned > 0
                ? ($state->kpis_completed / $state->total_kpis_assigned) * 100
                : 0;
            return [
                'state' => $state->name,
                'completionRate' => $completionRate
            ];
        });

        return $stateData;
    }

    public function addKpi()
    {
        return view('admin.add-kpi');
    }

    public function getKpiDataByState($state)
    {
        // Fetch KPIs based on the selected state
        $kpis = AddKpi::where('negeri', $state)->get();
        
        // Prepare labels and data
        $labels = $kpis->pluck('kpi')->toArray();
        $data = $kpis->pluck('peratus_pencapaian')->toArray();
        
        // Return the data in JSON format
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
 
