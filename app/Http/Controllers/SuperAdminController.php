<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\State;
use App\Models\AddKpi;
use App\Models\Institution;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index(){
        // Dipslay username at navbar 
        $username = Auth::User();
        
        // Get kpi by state
        $kpisPerState = State::withCount('kpis')->get();

        // Kpi overview
        $totalKpi = AddKpi::count();
        $kpisAchieved = AddKpi::where('peratus_pencapaian', '>=', 100)->count();
        $kpisOnTrack = AddKpi::whereBetween('peratus_pencapaian', [50, 99])->count();
        $kpisUnderperforming = AddKpi::whereBetween('peratus_pencapaian', [0, 49])->count();

        // User overview
        $totalUser = User::count();
        $superAdmin = User::role('Super Admin')->count();
        $admin = User::role('Admin')->count();
        $stateAdmin = User::role('Admin State')->count();
        $institutionAdmin = User::role('Institution Admin')->count();
        $user = User::role('User')->count();
        $recentUser = User::orderBy('created_at', 'desc')->limit(5)->get();
        

        // States overview
        $totalState = State::count();
        $totalInstitution = Institution::count();
        $institutionPerState = State::withCount('institutions')->get();
        
        // KPI Performance Summary
        $topInstitutions = Institution::with('addKpis') // Load the related KPIs
        ->get()
        ->map(function ($institution) {
            // Calculate the average achievement for each institution
            $institution->avg_achievement = $institution->addKpis->avg('peratus_pencapaian');
            return $institution;
        })
        ->sortByDesc('avg_achievement') // Sort by the calculated average achievement
        ->take(5); // Limit to top 5 institutions


        return view('superAdmin.Dashboard.index', compact(
            'username', 
            'kpisPerState', 
            'totalKpi', 
            'kpisAchieved', 
            'kpisOnTrack', 
            'kpisUnderperforming',
            'totalUser',
            'superAdmin',
            'admin',
            'stateAdmin',
            'institutionAdmin',
            'user',
            'recentUser',
            'totalState',
            'totalInstitution',
            'institutionPerState',
            'topInstitutions'
        ));
    }
}
