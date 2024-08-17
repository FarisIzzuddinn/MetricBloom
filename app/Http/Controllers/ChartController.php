<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function getKpiData()
    {
        // Assuming you have a Kpi model and you want to get the KPI names and values
        $kpis = AddKpi::all(); // Modify this query according to your needs

        $labels = $kpis->pluck('kpi')->toArray(); // Replace 'name' with your KPI name column
        $data = $kpis->pluck('peratus_pencapaian')->toArray(); // Replace 'value' with your KPI value column

        return view('/admin/dashboard/index', compact('labels', 'data'));
    }

}
