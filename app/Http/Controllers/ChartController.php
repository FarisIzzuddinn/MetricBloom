<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    // public function charts() {

    //    $userId = Auth::id();

    //    $data = AddKpi::where('user_id', $userId)
    //                 ->select('kpi','peratus_pencapaian')
    //                 ->get();

    //     $kpi = $data->pluck('kpi');
    //     $peratus_pencapaian = $data->pluck('peratus_pencapaian');

    //     return view('/user/KPI/IndexKPI', compact('kpi', 'peratus_pencapaian'));

    // }
}
