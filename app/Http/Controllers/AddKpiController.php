<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kjp;
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
use Illuminate\Support\Facades\Storage;

class AddKpiController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        $teras = Teras::all();
        $addKpis = AddKpi::with(['teras', 'sector', 'bahagians', 'states', 'institutions', 'kjps'])->paginate(10); 
        $username = Auth::User();
        $states = State::all();
        $bahagians = Bahagian::all();
        $institutions = Institution::all();
        $kjps = Kjp::all();

        
        return view('admin.KPI.IndexKPI', compact('addKpis', 'bahagians','institutions', 'teras', 'username', 'sectors', 'states', 'kjps'));
    }

    public function create (){
        return view ('admin.KPI.create');
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'teras_id' => 'required|exists:teras,id',
                'sectors_id' => 'required|exists:sectors,id',
                'pernyataan_kpi' => 'required|string|max:255|unique:add_kpis,pernyataan_kpi',
                'sasaran' => 'required|array|min:1',
                'sasaran.*' => 'required|numeric',
                'jenis_sasaran' => 'required|array|min:1',
                'jenis_sasaran.*' => 'required|string|in:peratus,bilangan,tempoh masa,hari,kelajuan',
                'indikator' => 'required|string|max:255',
                'strategi' => 'nullable|string|max:255',
                'program' => 'nullable|string|max:255',
                'kategori_report' => 'required|string|in:monthly,quarterly,semi_annually,annually',
                'aktiviti' => 'required|string|min:5|max:500',
                'outcome' => 'required|string|min:3|max:255',
                'keterangan' => 'required|string|min:3|max:255',
                'justifikasi' => 'required|string|min:3|max:255',
                'kaveat' => 'required|string|min:3|max:255',
                'formula' => 'required|string|min:3|max:255',
                'trend_pencapaian' => 'required|string|min:3|max:255',
                'owners' => 'nullable|array',
                'pdf_file_path' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            Log::info('KPI Store request received', [
                'request_data' => $request->all(),
                'owners' => $request->input('owners')
            ]);

            // Handle created_at and quarter
            $createdAt = $request->input('created_at', now());
            $data = $request->except(['_token', 'owners', 'pdf_file_path']);
            $data['created_at'] = $createdAt;
            $data['quarter'] = Carbon::parse($createdAt)->quarter;

            // Ensure `sasaran` is stored as valid JSON with float values
            $data['sasaran'] = json_encode(array_map('floatval', $request->input('sasaran')));

            // Store jenis_sasaran as JSON array
            $data['jenis_sasaran'] = json_encode(array_values($request->input('jenis_sasaran')));

            // Handle file upload
            if ($request->hasFile('pdf_file_path')) {
                // Get the uploaded file
                $file = $request->file('pdf_file_path');
                
                // Generate unique file name (avoid overwrites)
                $filename = time() . '-' . $file->getClientOriginalName();
                
                // Store the file in 'kpi_files' folder
                $filePath = $file->storeAs('kpi_files', $filename, 'public');
                
                // Save the file path to the data array
                $data['pdf_file_path'] = $filePath;
            }
            
            // Create the KPI
            $kpi = AddKpi::create($data);

            // Process owners
            if ($request->has('owners')) {
                foreach ($request->owners as $owner) {
                    [$type, $ownerId] = explode('-', $owner);

                    // Validate owner existence before inserting
                    if ($type == 'kjp' && Kjp::find($ownerId)) {
                        DB::table('kpi_kjp')->insert([
                            'kjp_id' => $ownerId,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                        ]);
                        Log::info("KPI assigned to KJP ID: {$ownerId}");
                    } elseif ($type == 'state' && State::find($ownerId)) {
                        DB::table('kpi_states')->insert([
                            'state_id' => $ownerId,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                            'quarter' => $data['quarter'],
                        ]);
                        Log::info("KPI assigned to state ID: {$ownerId}");
                    } elseif ($type == 'institution' && Institution::find($ownerId)) {
                        DB::table('kpi_institutions')->insert([
                            'institution_id' => $ownerId,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                            'quarter' => $data['quarter'],
                        ]);
                        Log::info("KPI assigned to institution ID: {$ownerId}");
                    } elseif ($type == 'bahagian' && Bahagian::find($ownerId)) {
                        DB::table('kpi_bahagian')->insert([
                            'bahagian_id' => $ownerId,
                            'add_kpi_id' => $kpi->id,
                            'created_at' => $createdAt,
                            'quarter' => $data['quarter'],
                        ]);
                        Log::info("KPI assigned to bahagian ID: {$ownerId}");
                    } else {
                        Log::warning('Invalid owner type', ['type' => $type, 'id' => $ownerId]);
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
    
    // public function store(Request $request)
    // {
    //     try {
    //         // Validate the request
    //         $request->validate([
    //             'teras_id' => 'required|exists:teras,id',
    //             'sectors_id' => 'required|exists:sectors,id',
    //             'pernyataan_kpi' => 'required|string|max:255|unique:add_kpis,pernyataan_kpi',
    //             'sasaran' => 'required|numeric',
    //             'indikator' => 'required|string|max:255',
    //             'jenis_sasaran' => 'required|string|max:255',
    //             'owners' => 'nullable|array',
    //             'pdf_file_path' => 'nullable|file|mimes:pdf|max:10240',
    //             'created_at' => 'nullable|date',
    //         ]);
    
    //         // Handle created_at and quarter
    //         $createdAt = $request->input('created_at', now());
    //         $data = $request->except(['_token', 'owners', 'pdf_file_path']);
    //         $data['created_at'] = $createdAt;
    //         $data['quarter'] = Carbon::parse($createdAt)->quarter;
    
    //         // Handle file upload
    //         if ($request->hasFile('pdf_file_path')) {
    //             // Get the uploaded file
    //             $file = $request->file('pdf_file_path');
                
    //             // Get the original file name
    //             $originalFileName = $file->getClientOriginalName();
                
    //             // Store the file with its original name in the 'kpi_files' folder under the 'public' disk
    //             $filePath = $file->storeAs('kpi_files', $originalFileName, 'public');
                
    //             // Save the file path to the data array
    //             $data['pdf_file_path'] = $filePath;
    //         }
            
    //         // Create the KPI
    //         $kpi = AddKpi::create($data);
    
    //         // Process owners
    //         if ($request->has('owners')) {
    //             foreach ($request->owners as $owner) {
    //                 [$type, $id] = explode('-', $owner);
    
    //                 if ($type == 'state' && State::find($id)) {
    //                     DB::table('kpi_states')->insert([
    //                         'state_id' => $id,
    //                         'add_kpi_id' => $kpi->id,
    //                         'created_at' => $createdAt,
    //                         'quarter' => $data['quarter'],
    //                     ]);
    //                     Log::info("KPI assigned to state ID: {$id}");
    //                 } elseif ($type == 'institution' && Institution::find($id)) {
    //                     DB::table('kpi_institutions')->insert([
    //                         'institution_id' => $id,
    //                         'add_kpi_id' => $kpi->id,
    //                         'created_at' => $createdAt,
    //                         'quarter' => $data['quarter'],
    //                     ]);
    //                     Log::info("KPI assigned to institution ID: {$id}");
    //                 } elseif ($type == 'bahagian' && Bahagian::find($id)) {
    //                     DB::table('kpi_bahagian')->insert([
    //                         'bahagian_id' => $id,
    //                         'add_kpi_id' => $kpi->id,
    //                         'created_at' => $createdAt,
    //                         'quarter' => $data['quarter'],
    //                     ]);
    //                     Log::info("KPI assigned to bahagian ID: {$id}");
    //                 } else {
    //                     Log::warning('Unknown or invalid owner type', ['type' => $type, 'id' => $id]);
    //                 }
    //             }
    //         }
    
    //         return redirect()->route('admin.kpi')->with([
    //             'status' => 'KPI created and assigned successfully.',
    //             'alert-type' => 'success'
    //         ]);
    
    //     } catch (QueryException $e) {
    //         Log::error('Database error during KPI creation', ['error' => $e->getMessage()]);
    //         return redirect()->back()->withInput()->with([
    //             'status' => 'A database error occurred. Please try again.',
    //             'alert-type' => 'danger'
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Unexpected error during KPI creation', ['error' => $e->getMessage()]);
    //         return redirect()->back()->withInput()->with([
    //             'status' => 'An unexpected error occurred. Please contact the administrator.',
    //             'alert-type' => 'danger'
    //         ]);
    //     }
    // }    
    
    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'teras_id' => 'required|exists:teras,id',
                'sectors_id' => 'required|exists:sectors,id',
                'pernyataan_kpi' => 'required|string|max:255|unique:add_kpis,pernyataan_kpi,' . $id,
                'sasaran' => 'required|array|min:1',
                'sasaran.*' => 'required|numeric',
                'jenis_sasaran' => 'required|array|min:1',
                'jenis_sasaran.*' => 'required|string|in:peratus,bilangan,tempoh masa,hari,kelajuan',
                'indikator' => 'nullable|string|max:255',
                'strategi' => 'nullable|string|max:255',
                'program' => 'nullable|string|max:255',
                'kategori_report' => 'required|string|in:monthly,quarterly,semi_annually,annually',
                'aktiviti' => 'required|string|min:5|max:500',
                'outcome' => 'required|string|min:3|max:255',
                'keterangan' => 'required|string|min:3|max:255',
                'justifikasi' => 'required|string|min:3|max:255',
                'kaveat' => 'required|string|min:3|max:255',
                'formula' => 'required|string|min:3|max:255',
                'trend_pencapaian' => 'required|string|min:3|max:255',
                'owners' => 'nullable|array',
                'pdf_file_path' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            Log::info('KPI Update request received', [
                'request_data' => $request->all(),
                'id' => $id,
                'owners' => $request->input('owners')
            ]);

            // Find the KPI record
            $kpi = AddKpi::findOrFail($id);

            // Update KPI data
            $data = $request->except(['_token', '_method', 'owners', 'pdf_file_path']);

            // Ensure `sasaran` is stored as valid JSON with float values
            $data['sasaran'] = json_encode(array_map('floatval', $request->input('sasaran')));

            // Store jenis_sasaran as JSON array
            $data['jenis_sasaran'] = json_encode(array_values($request->input('jenis_sasaran')));

            // Preserve quarter if it already exists
            $data['quarter'] = $kpi->quarter ?? Carbon::parse($kpi->created_at)->quarter;

            // Handle file upload
            if ($request->hasFile('pdf_file_path')) {
                // Delete the old file if it exists
                if ($kpi->pdf_file_path && Storage::disk('public')->exists($kpi->pdf_file_path)) {
                    Storage::disk('public')->delete($kpi->pdf_file_path);
                }

                // Get the uploaded file
                $file = $request->file('pdf_file_path');

                // Generate unique file name (avoid overwrites)
                $filename = time() . '-' . $file->getClientOriginalName();

                // Store the file in 'kpi_files' folder
                $filePath = $file->storeAs('kpi_files', $filename, 'public');

                // Update the file path in the database
                $data['pdf_file_path'] = $filePath;
            }

            // Update the KPI record
            $kpi->update($data);

            // Update owners
            if ($request->has('owners')) {
                // Clear existing owner relationships
                DB::table('kpi_states')->where('add_kpi_id', $kpi->id)->delete();
                DB::table('kpi_institutions')->where('add_kpi_id', $kpi->id)->delete();
                DB::table('kpi_bahagian')->where('add_kpi_id', $kpi->id)->delete();
                DB::table('kpi_kjp')->where('add_kpi_id', $kpi->id)->delete();

                // Add new owner relationships
                foreach ($request->owners as $owner) {
                    [$type, $ownerId] = explode('-', $owner);

                    // Validate owner existence before inserting
                    if ($type == 'kjp' && Kjp::find($ownerId)) {
                        DB::table('kpi_kjp')->updateOrInsert([
                            'kjp_id' => $ownerId,
                            'add_kpi_id' => $kpi->id
                        ], [
                            'created_at' => now()
                        ]);
                        Log::info("KPI reassigned to KJP ID: {$ownerId}");
                    } elseif ($type == 'state' && State::find($ownerId)) {
                        DB::table('kpi_states')->updateOrInsert([
                            'state_id' => $ownerId,
                            'add_kpi_id' => $kpi->id
                        ], [
                            'created_at' => now(),
                            'quarter' => $data['quarter']
                        ]);
                        Log::info("KPI reassigned to state ID: {$ownerId}");
                    } elseif ($type == 'institution' && Institution::find($ownerId)) {
                        DB::table('kpi_institutions')->updateOrInsert([
                            'institution_id' => $ownerId,
                            'add_kpi_id' => $kpi->id
                        ], [
                            'created_at' => now(),
                            'quarter' => $data['quarter']
                        ]);
                        Log::info("KPI reassigned to institution ID: {$ownerId}");
                    } elseif ($type == 'bahagian' && Bahagian::find($ownerId)) {
                        DB::table('kpi_bahagian')->updateOrInsert([
                            'bahagian_id' => $ownerId,
                            'add_kpi_id' => $kpi->id
                        ], [
                            'created_at' => now(),
                            'quarter' => $data['quarter']
                        ]);
                        Log::info("KPI reassigned to bahagian ID: {$ownerId}");
                    } else {
                        Log::warning('Invalid owner type', ['type' => $type, 'id' => $ownerId]);
                    }
                }
            }

            return redirect()->route('admin.kpi')->with([
                'status' => 'KPI updated successfully.',
                'alert-type' => 'success',
            ]);
        } catch (QueryException $e) {
            Log::error('Database error during KPI update', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with([
                'status' => 'A database error occurred. Please try again.',
                'alert-type' => 'danger',
            ]);
        } catch (\Exception $e) {
            Log::error('Unexpected error during KPI update', ['error' => $e->getMessage()]);
            return redirect()->back()->withInput()->with([
                'status' => 'An unexpected error occurred. Please contact the administrator.',
                'alert-type' => 'danger',
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
