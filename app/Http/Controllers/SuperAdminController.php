<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use App\Models\Institution;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index(){
        $username = Auth::User();

        $totalKpis = AddKpi::count();
        $achievedKpis = AddKpi::where('peratus_pencapaian', '>=', '75')->count();
        $pendingKpis = AddKpi::where('peratus_pencapaian', '>=', 0)
                                ->where('peratus_pencapaian', '<', 75)
                                ->count();
        $averageAchievement = ($totalKpis > 0) ? round(($achievedKpis / $totalKpis) * 100) : 0;

        $roles = Role::withCount('users')->get();

        
        return view('superAdmin.Dashboard.index', compact('username','totalKpis', 'achievedKpis', 'pendingKpis', 'averageAchievement', 'roles'));
    }
}
