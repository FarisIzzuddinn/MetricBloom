<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\State;
use App\Models\Teras;
use App\Models\AddKpi;
use App\Models\Sector;
use App\Models\Bahagian;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AddKpiController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        $teras = Teras::all();
        $addKpis = AddKpi::with('teras', 'sector')->get(); 
        $username = Auth::User();
        $states = State::all();
        $bahagians = Bahagian::all();
        $institutions = Institution::all();
        
        return view('admin.KPI.IndexKPI', compact('addKpis', 'bahagians','institutions', 'teras', 'username', 'sectors', 'states'));
    }

    public function create()
    {
        return view('kpi.add');
    }
    
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'teras_id' => 'required|exists:teras,id',
            'sectors_id' => 'required|exists:sectors,id',
            'pernyataan_kpi' => 'required|string|max:255|unique:add_kpis,pernyataan_kpi',
            'sasaran' => 'required|numeric',
            'jenis_sasaran' => 'required|string|max:255',
            'owners' => 'nullable|array',
            'pdf_file_path' => 'nullable|file|mimes:pdf|max:10240',
            'created_at' => 'nullable|date',
        ]);
    
        // Handle created_at and quarter
        $createdAt = $request->input('created_at', now()); // Use provided date or the current date
        $data = $request->except(['_token', 'owners', 'pdf_file_path']);
        $data['created_at'] = $createdAt; // Set the created_at value
        $data['quarter'] = Carbon::parse($createdAt)->quarter; // Calculate the quarter based on created_at
    
        // Handle file upload
        if ($request->hasFile('pdf_file_path')) {
            $file = $request->file('pdf_file_path');
            $filePath = $file->store('kpi_files', 'public');
            $data['pdf_file_path'] = $filePath; // Save the file path
        }
    
        // Create the KPI
        $kpi = AddKpi::create($data);
    
        // Process owners
        if ($request->has('owners')) {
            foreach ($request->owners as $owner) {
                [$type, $id] = explode('-', $owner);
    
                switch ($type) {
                    case 'state':
                        $state = State::find($id);
                        if ($state) {
                            DB::table('kpi_states')->insert([
                                'state_id' => $id,
                                'add_kpi_id' => $kpi->id,
                                'created_at' => $createdAt,
                                'quarter' => $data['quarter'],
                            ]);
                            Log::info("KPI assigned to state ID: {$id}");
                        } else {
                            Log::error("State not found: ID {$id}");
                        }
                        break;
    
                    case 'institution':
                        $institution = Institution::find($id);
                        if ($institution) {
                            DB::table('kpi_institutions')->insert([
                                'institution_id' => $id,
                                'add_kpi_id' => $kpi->id,
                                'created_at' => $createdAt,
                                'quarter' => $data['quarter'],
                            ]);
                            Log::info("KPI assigned to institution ID: {$id}");
                        } else {
                            Log::error("Institution not found: ID {$id}");
                        }
                        break;
    
                    case 'bahagian':
                        $bahagian = Bahagian::find($id);
                        if ($bahagian) {
                            DB::table('kpi_bahagian')->insert([
                                'bahagian_id' => $id,
                                'add_kpi_id' => $kpi->id,
                                'created_at' => $createdAt,
                                'quarter' => $data['quarter'],
                            ]);
                            Log::info("KPI assigned to bahagian ID: {$id}");
                        } else {
                            Log::error("Bahagian not found: ID {$id}");
                        }
                        break;
    
                    default:
                        Log::warning('Unknown owner type:', ['type' => $type]);
                        break;
                }
            }
        }
    
        return redirect()->route('admin.kpi')->with('success', 'KPI created and assigned successfully.');
    }
    

     


    // public function edit($id)
    // {
        
    //     $addKpi = AddKpi::with('states')->findOrFail($id);
    //     $states = State::all(); // Fetch all states

    //     return view('kpi.edit', compact('addKpi', 'states'));
    // }

   public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'teras_id' => 'required|exists:teras,id',
            'sectorid' => 'required|string|max:255',
            'pernyataan_kpi' => 'required|string|max:255|unique:add_kpis,pernyataan_kpi,' . $id,
            'sasaran' => 'required|numeric',
            'jenis_sasaran' => 'required|string|max:255',
            'owners' => 'nullable|array',
        ]);

        // Find the existing KPI
        $kpi = AddKpi::findOrFail($id);

        // Update the KPI
        $kpi->fill($request->except(['_token', 'owners']));
        $kpi->save();

        // Detach all previous owners and reassign
        $kpi->states()->detach();
        $kpi->institutions()->detach();
        $kpi->bahagians()->detach();

        if ($request->has('owners')) {
            foreach ($request->owners as $owner) {
                [$type, $id] = explode('-', $owner);

                switch ($type) {
                    case 'state':
                        $state = State::findOrFail($id);
                        $state->kpis()->attach($kpi->id);
                        break;

                    case 'institution':
                        $institution = Institution::findOrFail($id);
                        $institution->kpis()->attach($kpi->id);
                        break;

                    case 'bahagian':
                        $bahagian = Bahagian::findOrFail($id);
                        $bahagian->kpis()->attach($kpi->id);
                        break;

                    default:
                        // Ignore unknown types
                        break;
                }
            }
        }

        return redirect()->route('admin.kpi')->with('success', 'KPI updated and reassigned successfully.');
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

    // private function validateKpi(Request $request)
    // {
    //     $request->validate([
    //         'teras_id' => 'required|exists:teras,id',
    //         'so_id' => 'required|string|max:255',
    //         'states' => 'required|array',
    //         'states.*' => 'exists:states,id',
    //         'bahagians' => 'required|array',
    //         'bahagians.*' => 'exists:bahagian,id',
    //         'user_id' => 'nullable|exists:users,id',
    //         'pernyataan_kpi' => 'required|string|max:255',
    //         'sasaran' => 'required|numeric',
    //         'jenis_sasaran' => 'required|string|max:255',
    //         'pencapaian' => 'nullable|numeric',
    //         'peratus_pencapaian' => 'nullable|numeric',
    //     ]);
    // }
}
