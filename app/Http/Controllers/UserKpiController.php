<?php

namespace App\Http\Controllers;

use App\Models\AddKpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserKpiController extends Controller
{
    public function index()
    {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // Ambil KPI yang berkaitan dengan pengguna tersebut
        $addKpis = AddKpi::where('user_id', $user->id)->get();

        // Paparkan ke view
        return view('user.KPI.IndexKPI', compact('addKpis'));
    }
    
    // public function inputForm()
    // {
    //     $addKpis = AddKpi::all();
    //     return view('user.KPI.IndexKPI', compact('addKpis'));
    // }

    // public function show($id)
    // {
    //     $addkpi = AddKpi::findOrFail($id);
    //     return view('add_kpi.show', compact('kpi'));
    // }

    public function storeInput(Request $request)
{
    // Validate the request data
    $request->validate([
        'kpi_id' => 'required|exists:add_kpis,id',
        'pencapaian' => 'required|numeric',
        'peratus_pencapaian' => 'required|numeric'
    ]);

    // Find the KPI entry
    $kpi = AddKpi::find($request->kpi_id);

    // Update the KPI data
    $kpi->pencapaian = $request->pencapaian;
    $kpi->peratus_pencapaian = $request->peratus_pencapaian;
    $kpi->save();

    // Redirect or return response
    return redirect()->back()->with('success', 'KPI updated successfully!');
}


    public function edit($id)
    {
        $addKpis = AddKpi::findOrFail($id);
        return view('user.edit', compact('addKpis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pencapaian' => 'required|string',
        ]);

        $addKpi = AddKpi::findOrFail($id);
        $addKpi->pencapaian = $request->input('pencapaian');
        $addKpi->peratus_pencapaian = $request->input('peratus_pencapaian');
        $addKpi->save();

        return redirect()->back()->with('success', 'KPI updated successfully');
    }

    // public function charts() {

    //     $userId = Auth::id();
 
    //     $data = AddKpi::where('user_id', $userId)
    //                  ->select('kpi','peratus_pencapaian')
    //                  ->get();
 
    //      $kpi = $data->pluck('kpi');
    //      $peratus_pencapaian = $data->pluck('peratus_pencapaian');
 
    //      return view('/user/KPI/IndexKPI', compact('kpi', 'peratus_pencapaian'));
 
    //  }

    private function validateKpi(Request $request)
    {
        $request->validate([
            'kpi_id' => 'required|exists:add_kpis,id',
            'pencapaian' => 'required|numeric',
        ]);
    }
}
