<?php

namespace App\Http\Controllers;

use App\Models\So;
use App\Models\User;
use App\Models\Teras;
use App\Models\AddKpi;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;


class AddKpiController extends Controller
{
    public function index()
    {
        $so = So::all();
        $teras = Teras::all();
        $addKpis = AddKpi::with('teras')->orderBy('bil')->get(); 
        $username = Auth::User();
        $states = State::all();
        
        return view('admin.KPI.IndexKPI', compact('addKpis', 'teras', 'username', 'so', 'states'));
    }

    public function create()
    {
        return view('kpi.add');
    }

     // Store a new KPI
     public function store(Request $request)
    {
        // Validate the incoming request data
        $this->validateKpi($request);
      
        // Generate a unique bil number for the KPI
        $bil = AddKpi::count() + 1;

        // Prepare data for creating the KPI
        $data = $request->except(['_token']);
        $data['bil'] = $bil; // Set the bil number
        $data['kpi'] = 'KPI ' . $bil; // Set the KPI name
        $data['pencapaian'] = $request->input('pencapaian', 0); // Default value of 0 if not provided

        // Create the KPI and get the instance
        $kpi = AddKpi::create($data);

        // Sync the states with the newly created KPI
        if ($request->has('states')) {
            $kpi->states()->sync($request['states']);
        }

        // Redirect back with a success message
        return redirect()->route('admin.kpi')->with('success', 'KPI created successfully.');
    }


    public function edit($id)
    {
        
        $addKpi = AddKpi::with('states')->findOrFail($id);
        $states = State::all(); // Fetch all states

        return view('kpi.edit', compact('addKpi', 'states'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $this->validateKpi($request);
    
        // Find the existing AddKpi by ID
        $addKpi = AddKpi::with('states')->findOrFail($id);
        
        // Fill the AddKpi model with the request data, excluding the _token
        $addKpi->fill($request->except(['_token'])); 
        $addKpi->save();
    
        // Sync the states with the incoming states from the request
        // This will add new states and remove any states not included in the request
        if ($request->has('states')) {
            $addKpi->states()->sync($request['states']);
        }
    
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
            'states' => 'required|array',
            'states.*' => 'exists:states,id',
            'user_id' => 'nullable|exists:users,id',
            'pernyataan_kpi' => 'required|string|max:255',
            'sasaran' => 'required|numeric',
            'jenis_sasaran' => 'required|string|max:255',
            'pencapaian' => 'nullable|numeric',
            'peratus_pencapaian' => 'nullable|numeric',
        ]);
    }
}
