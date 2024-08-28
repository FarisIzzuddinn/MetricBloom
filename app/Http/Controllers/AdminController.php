<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use Illuminate\Support\Facades\Auth;
// use App\Models\AdminDashboard;


class AdminController extends Controller
{
    public function __construct()
{
    $this->middleware('role:admin');
}
    public function index()
    {
        // Retrieve data from the Kpi model
        // $akpis = AdminDashboard::orderBy('sortby', 'asc')->get();
        $addKpis = AddKpi::orderBy('bil')->get();
        
         // Kira purata peratus pencapaian
         $totalAchievement = $addKpis->sum('peratus_pencapaian');
         $totalKpis = $addKpis->count();
 
         if ($totalKpis > 0) {
             $averageAchievement = $totalAchievement / $totalKpis;
         } else {
             $averageAchievement = 0;
         }
 
         // Tentukan status berdasarkan purata pencapaian
         $status = $averageAchievement >= 50 ? 'Hijau' : 'Merah';

         $kpis = AddKpi::all();
         $labels = $kpis->pluck('kpi')->toArray();
         $data = $kpis->pluck('peratus_pencapaian')->toArray();
    
         $user = Auth::User();
         // Hantar data ke view
         return view('admin.dashboard.index', compact('addKpis', 'averageAchievement','user', 'status' , 'labels', 'data'));
    }

    public function addKpi()
    {
        return view('admin.add-kpi');
    }
}
