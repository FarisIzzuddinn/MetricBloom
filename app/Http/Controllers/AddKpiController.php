<?php

namespace App\Http\Controllers;

use App\Models\So;
use App\Models\User;
use App\Models\Teras;
use App\Models\AddKpi;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;


class AddKpiController extends Controller
{
    public function index()
    {
        $so = So::all();
        $teras = Teras::all();
        $users = User::all();
        $addKpis = AddKpi::with('teras')->orderBy('bil')->get(); 
        return view('admin.kpi.IndexKPI', compact('addKpis', 'users', 'teras', 'so'));
    }

    public function create()
    {
        return view('kpi.add');
    }

    public function store(Request $request)
    {
        $this->validateKpi($request);

        $bil = AddKpi::count() + 1;

        $data = $request->except(['_token']);
        $data['bil'] = $bil;
        $data['kpi'] = 'KPI ' . $bil;
        $data['pencapaian'] = $request->input('pencapaian', 0); // Default value of 0

        AddKpi::create($data);

        return redirect()->route('admin.kpi')->with('success', 'KPI created successfully.');
    }

    public function edit($id)
    {
        $addKpi = AddKpi::findOrFail($id);
        return view('kpi.edit', compact('addKpi'));
    }

    public function update(Request $request, $id)
    {
        $this->validateKpi($request);

        $addKpi = AddKpi::findOrFail($id);
        $addKpi->fill($request->except(['_token'])); 
        $addKpi->save();

        return redirect()->route('admin.kpi')->with('success', 'KPI updated successfully.');
    }

    public function destroy(AddKpi $addKpi)
    {
        $addKpi->delete();
        $this->recalculateBilAndKpi(); 

        return redirect()->route('admin.kpi')->with('success', 'KPI deleted successfully.');
    }

    private function recalculateBilAndKpi()
    {
        $addKpis = AddKpi::orderBy('id')->get();
        foreach ($addKpis as $index => $addKpi) {
            $addKpi->update([
                'bil' => $index + 1,
                'kpi' => 'KPI ' . ($index + 1),
            ]);
        }
    }

    private function validateKpi(Request $request)
    {
        $request->validate([
            'teras_id' => 'required|exists:teras,id',
            'so_id' => 'required|string|max:255',
            'negeri' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'pernyataan_kpi' => 'required|string|max:255',
            'sasaran' => 'required|numeric',
            'jenis_sasaran' => 'required|string|max:255',
            'pencapaian' => 'nullable|numeric',
            'peratus_pencapaian' => 'nullable|numeric',
        ]);
    }
}
