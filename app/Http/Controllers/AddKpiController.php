<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\State;
use App\Models\Teras;
use App\Models\AddKpi;
use App\Models\Sector;
use App\Models\Bahagian;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AddKpiController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        $teras = Teras::all();
        $addKpis = AddKpi::with(['teras', 'sector', 'bahagians', 'states', 'institutions'])->paginate(10); 
        $username = Auth::User();
        $states = State::all();
        $bahagians = Bahagian::all();
        $institutions = Institution::all();
        
        return view('admin.KPI.IndexKPI', compact('addKpis', 'bahagians','institutions', 'teras', 'username', 'sectors', 'states'));
    }
    
    public function store(Request $request)
    {
        try {
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
            $createdAt = $request->input('created_at', now());
            $data = $request->except(['_token', 'owners', 'pdf_file_path']);
            $data['created_at'] = $createdAt;
            $data['quarter'] = Carbon::parse($createdAt)->quarter;
    
            // Handle file upload
            if ($request->hasFile('pdf_file_path')) {
                $file = $request->file('pdf_file_path');
                $filePath = $file->store('kpi_files', 'public');
                $data['pdf_file_path'] = $filePath;
            }
    
            // Create the KPI
            $kpi = AddKpi::create($data);
    
            // Process owners
            if ($request->has('owners')) {
                foreach ($request->owners as $owner) {
                    [$type, $id] = explode('-', $owner);
    
                    if ($type == 'state' && State::find($id)) {
                        DB::table('kpi_states')->insert([
                            'state_id' => $id,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                            'quarter' => $data['quarter'],
                        ]);
                        Log::info("KPI assigned to state ID: {$id}");
                    } elseif ($type == 'institution' && Institution::find($id)) {
                        DB::table('kpi_institutions')->insert([
                            'institution_id' => $id,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                            'quarter' => $data['quarter'],
                        ]);
                        Log::info("KPI assigned to institution ID: {$id}");
                    } elseif ($type == 'bahagian' && Bahagian::find($id)) {
                        DB::table('kpi_bahagian')->insert([
                            'bahagian_id' => $id,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                            'quarter' => $data['quarter'],
                        ]);
                        Log::info("KPI assigned to bahagian ID: {$id}");
                    } else {
                        Log::warning('Unknown or invalid owner type', ['type' => $type, 'id' => $id]);
                    }
                }
            }
    
            return redirect()->route('admin.kpi')->with([
                'status' => 'KPI created and assigned successfully.',
                'alert-type' => 'success'
            ]);
    
        } catch (QueryException $e) {
            Log::error('Database error during KPI creation', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with([
                'status' => 'A database error occurred. Please try again.',
                'alert-type' => 'danger'
            ]);
        } catch (\Exception $e) {
            Log::error('Unexpected error during KPI creation', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with([
                'status' => 'An unexpected error occurred. Please contact the administrator.',
                'alert-type' => 'danger'
            ]);
        }
    }    
    
    public function update(Request $request, $id)
    {
        try {
            // Find the user record by ID
            $user = User::findOrFail($id);
            Log::info("Attempting to update User with ID: {$id}");
    
            // Validate the input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|min:8|confirmed',
                'roles' => 'required|array',
                'state_id' => 'nullable|exists:states,id',
                'institution_id' => 'nullable|exists:institutions,id',
                'sector_id' => 'nullable|exists:sectors,id',
                'bahagian_id' => 'nullable|exists:bahagians,id',
            ]);
    
            // Update the user data
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
                'state_id' => $validatedData['state_id'] ?? $user->state_id,
                'institution_id' => $validatedData['institution_id'] ?? $user->institution_id,
                'sector_id' => $validatedData['sector_id'] ?? $user->sector_id,
                'bahagian_id' => $validatedData['bahagian_id'] ?? $user->bahagian_id,
            ]);
    
            // Sync roles
            $user->roles()->sync($validatedData['roles']);
    
            // Return success message
            return redirect()->route('users.index')->with([
                'status' => 'User updated successfully.',
                'alert-type' => 'success',
            ]);
        } catch (QueryException $e) {
            Log::error('Database error during User update', ['error' => $e->getMessage()]);
            return redirect()->back()->with([
                'status' => 'An error occurred while updating the user.',
                'alert-type' => 'error',
            ]);
        }
    }
    
    public function destroy($id)
    {
        try {
            // Check if the KPI is associated with any records (e.g., state, institution, bahagian)
            $kpi = AddKpi::findOrFail($id);
    
            // Check if the KPI is being used in other relationships (states, institutions, bahagians)
            if ($kpi->states()->exists() || $kpi->institutions()->exists() || $kpi->bahagians()->exists()) {
                // If it is associated with any state, institution, or bahagian, prevent deletion
                return redirect()->route('admin.kpi')->with('status', 'This KPI is in use and cannot be deleted.')->with('alert-type', 'danger');
            }
    
            // Proceed with deleting the KPI
            $kpi->delete();
    
            // Return success message
            return redirect()->route('admin.kpi')->with('status', 'KPI deleted successfully.')->with('alert-type', 'success');
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error deleting KPI: ' . $e->getMessage());
    
            // Return error message
            return redirect()->route('admin.kpi')->with('status', 'An error occurred while trying to delete the KPI.')->with('alert-type', 'danger');
        }
    }    
}
