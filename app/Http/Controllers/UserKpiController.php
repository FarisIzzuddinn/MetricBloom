<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\AddKpi;
use App\Models\Bahagian;
use App\Models\KpiBahagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserKpiController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $username = auth()->user();
    
        // Get the user's bahagian and sector
        $userBahagian = $username->userEntity->bahagian;
    
        // Ensure the user has a valid bahagian and sector
        if (!$userBahagian || !$userBahagian->sector_id) {
            return redirect()->back()->withErrors('No Bahagian or Sector is associated with your account.');
        }
    
        $sectorId = $userBahagian->sector_id;
        $sector = $userBahagian->sector->name ?? 'Unknown Sector';

        // Retrieve KPIs related to the same sector
        $kpis = KpiBahagian::with(['kpi', 'bahagian'])
            ->whereHas('bahagian', function ($query) use ($sectorId) {
                $query->where('sector_id', $sectorId);
            })
            ->get();
    
        // Group KPIs by Bahagian name
        $groupedKpis = $kpis->groupBy(function ($item) {
            return $item->bahagian ? $item->bahagian->nama_bahagian : 'Unassigned Bahagian';
        });
    
        return view('admin.kpi-achievement', compact('groupedKpis', 'username', 'sector'));
    }
    
    
    /**
     * Store the user's KPI achievement.
     */
    public function update(Request $request)
    {
        // Validate the input
        $request->validate([
            'kpi_bahagian_id' => 'required|exists:kpi_bahagian,id', 
            'pencapaian' => 'required|numeric|min:0',
            // 'numerator' => 'required|numeric|min:0', // Input numerator
            // 'denominator' => 'required|numeric|min:1', // Input denominator to avoid division by zero
        ]);

        // Find the existing record in kpi_bahagian
        $kpiBahagian = KpiBahagian::find($request->kpi_bahagian_id);

        if (!$kpiBahagian) {
            return redirect()->back()->withErrors('The KPI record could not be found.');
        }

        // Fetch the related KPI details
        $kpi = AddKpi::find($kpiBahagian->add_kpi_id);

        if (!$kpi) {
            return redirect()->back()->withErrors('The related KPI record could not be found.');
        }

        // Fetch PDF file URL for any future use
        // $pdfFileUrl = $kpi->pdf_file_path ? Storage::url($kpi->pdf_file_path) : null;

        // Calculate the percentage based on the numerator and denominator
        // $numerator = $request->numerator;
        // $denominator = $request->denominator;
        // $percentage = ($numerator / $denominator) * 100;

        // Update the achievement and calculate percentage
        $kpiBahagian->pencapaian = $request->pencapaian;
        $kpiBahagian->peratus_pencapaian = ($request->pencapaian / $kpi->sasaran) * 100;

        // Determine the status dynamically
        if ($kpiBahagian->peratus_pencapaian >= 100) {
            $kpiBahagian->status = 'achieved';
        } elseif ($kpiBahagian->peratus_pencapaian > 50) {
            $kpiBahagian->status = 'pending';
        } else {
            $kpiBahagian->status = 'not achieved';
        }

        // Save the changes
        $kpiBahagian->save();

        // Prepare calculation summary
        // $calculationDetails = [
        //     'numerator' => $numerator,
        //     'denominator' => $denominator,
        //     'percentage' => round($percentage, 2) . '%',
        //     'status' => ucfirst($kpiBahagian->status), // Capitalize the status for better readability
        //     'pdf_file_url' => $pdfFileUrl, // Optional: Include the PDF file URL
        // ];
        
        
        // Return success response with calculation details
        return redirect()->route('user.kpi.index')
            ->with('success', 'Achievement updated successfully.');
    }

    
    
    
    


    
   
    
    
    
    // public function index()
    // {
    //     $username = Auth::user();
    //     $user = Auth::user();

    //     // Fetch KPIs for the logged-in user, including the 'so' and 'teras' relationships
    //     $addKpis = $user->kpis()->with(['so', 'teras'])->get();

    //     // Total KPIs for the logged-in user
    //     $userTotalKpis = $addKpis->count();

    //     // KPIs with achievement percentage >= 75% for the logged-in user
    //     $userAchievedKpis = $addKpis->where('peratus_pencapaian', '>=', 75)->count();

    //     // KPIs with achievement percentage < 75% for the logged-in user
    //     $userPendingKpis = $addKpis->whereBetween('peratus_pencapaian', [0, 75])->count();

    //     // Average achievement percentage for the logged-in user
    //     $userAverageAchievement = ($userTotalKpis > 0) ? round(($userAchievedKpis / $userTotalKpis) * 100) : 0;

    //     // Prepare data for the chart
    //     $labels = $addKpis->pluck('kpi')->toArray();
    //     $data = $addKpis->pluck('peratus_pencapaian')->toArray();

    //     // Pass data to the view
    //     return view('user.KPI.IndexKPI', compact('addKpis', 'labels', 'userTotalKpis','username', 'userAchievedKpis', 'userPendingKpis', 'userAverageAchievement', 'data', 'user'));
    // }

    
    

    // public function storeInput(Request $request)
    // {
    //     // Validate the request data
    //     $request->validate([
    //         'kpi_id' => 'required|exists:add_kpis,id',
    //         'pencapaian' => 'required|numeric',
    //         'peratus_pencapaian' => 'required|numeric',
    //         'reason' => 'nullable|string'
    //     ]);

    //     // Find the KPI entry
    //     $kpi = AddKpi::find($request->kpi_id);

    //     // Update the KPI data
    //     $kpi->pencapaian = $request->pencapaian;
    //     $kpi->peratus_pencapaian = $request->peratus_pencapaian;

    //     // If `peratus_pencapaian` is below the threshold, save the reason
    //     if ($request->peratus_pencapaian < 100) {
    //         $kpi->reason = $request->reason;
    //     } else {
    //         $kpi->reason = null; // Clear the reason if the KPI is achieved
    //     }

    //     $kpi->save();

    //     // Redirect or return response
    //     return redirect()->back()->with('success', 'KPI updated successfully!');
    // }

    // public function edit($id)
    // {
    //     $addKpis = AddKpi::findOrFail($id);
    //     return view('user.edit', compact('addKpis'));
    // }
    
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'pencapaian' => 'required|numeric',
    //         'peratus_pencapaian' => 'required|numeric',
    //         'reason' => 'nullable|string'
    //     ]);

    //     $addKpi = AddKpi::findOrFail($id);
    //     $addKpi->pencapaian = $request->input('pencapaian');
    //     $addKpi->peratus_pencapaian = $request->input('peratus_pencapaian');

    //     // If `peratus_pencapaian` is below the threshold, save the reason
    //     if ($request->peratus_pencapaian < 100) {
    //         $addKpi->reason = $request->input('reason');
    //     } else {
    //         $addKpi->reason = null; // Clear the reason if the KPI is achieved
    //     }

    //     $addKpi->save();

    //     return redirect()->back()->with('success', 'KPI updated successfully');
    // }

    

    // // public function charts() {

    // //     $userId = Auth::id();
 
    // //     $data = AddKpi::where('user_id', $userId)
    // //                  ->select('kpi','peratus_pencapaian')
    // //                  ->get();
 
    // //      $kpi = $data->pluck('kpi');
    // //      $peratus_pencapaian = $data->pluck('peratus_pencapaian');
 
    // //      return view('/user/KPI/IndexKPI', compact('kpi', 'peratus_pencapaian'));
 
    // //  }

    // private function validateKpi(Request $request)
    // {
    //     $request->validate([
    //         'kpi_id' => 'required|exists:add_kpis,id',
    //         'pencapaian' => 'required|numeric',
    //     ]);
    // }
}
