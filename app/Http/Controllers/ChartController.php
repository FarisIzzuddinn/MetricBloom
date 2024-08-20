<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use Illuminate\Http\Request;
use App\Models\ChartConfiguration;


class ChartController extends Controller
{
    public function getKpiData()
    {
        // Assuming you have a Kpi model and you want to get the KPI names and values
        $kpis = AddKpi::all(); // Modify this query according to your needs

        $labels = $kpis->pluck('kpi')->toArray(); // Replace 'name' with your KPI name column
        $data = $kpis->pluck('peratus_pencapaian')->toArray(); // Replace 'value' with your KPI value column

        return view('admin.dashboard.index', compact('labels', 'data'));
    }

    public function updateChartTitle(Request $request)
    {
        $request->validate([
            'chart_title' => 'required|string|max:255',
        ]);

        $chartConfiguration = ChartConfiguration::first();
        if (!$chartConfiguration) {
            $chartConfiguration = new ChartConfiguration();
        }
        $chartConfiguration->chart_title = $request->chart_title;
        $chartConfiguration->save();

        return redirect()->back()->with('success', 'Chart title updated successfully!');
    }

    public function create(){
        return view('chartTitle');
    }

}
