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
    //  Manage KPI for admin bahagian user
    public function index()
    {
        try {
            // Get the currently authenticated user
            $username = auth()->user();
    
            // Check if the user is authenticated
            if (!$username) {
                return redirect()->route('login')->with([
                    'status' => 'You must be logged in to access this page.',
                    'alert-type' => 'warning',
                ]);
            }
    
            // Get the user's bahagian and sector
            $userBahagian = $username->userEntity->bahagian ?? null;
    
            // Ensure the user has a valid bahagian and sector
            if (!$userBahagian || !$userBahagian->sector_id) {
                return redirect()->route('dashboard')->with([
                    'status' => 'No Bahagian or Sector is associated with your account.',
                    'alert-type' => 'danger',
                ]);
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
    
            // Return the view with data
            return view('admin.kpi-achievement', compact('groupedKpis', 'username', 'sector'));
    
        } catch (\Exception $e) {
            // Redirect back with an error message
            return redirect()->route('dashboard')->with([
                'status' => 'An unexpected error occurred while fetching KPI data. Please try again later.',
                'alert-type' => 'danger',
            ]);
        }
    }
    
    
    /**
     * Store the user's KPI achievement.
     */
    public function update(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'kpi_bahagian_id' => 'required|exists:kpi_bahagian,id', 
                'pencapaian' => 'required|numeric|min:0',
                'reason' => 'required',
                'other_reason' => 'required_if:reason,Other|max:255',
            ]);
    
            // Find the existing record in kpi_bahagian
            $kpiBahagian = KpiBahagian::find($request->kpi_bahagian_id);
    
            if (!$kpiBahagian) {
                return redirect()->back()->with([
                    'status' => 'The KPI record could not be found.',
                    'alert-type' => 'danger',
                ]);
            }
    
            // Fetch the related KPI details
            $kpi = AddKpi::find($kpiBahagian->add_kpi_id);
    
            if (!$kpi) {
                return redirect()->back()->with([
                    'status' => 'The related KPI record could not be found.',
                    'alert-type' => 'danger',
                ]);
            }
    
            // Assign the reason: either the selected value or the custom input
            $reason = $request->reason === 'Other' ? $request->other_reason : $request->reason;
    
            // Update the kpi_bahagian record
            $kpiBahagian->pencapaian = $request->pencapaian;
            
            $kpiBahagian->peratus_pencapaian = ($request->pencapaian / $kpi->sasaran) * 100;
    
            // Dynamically determine the status
            if ($kpiBahagian->peratus_pencapaian >= 100) {
                $kpiBahagian->status = 'achieved';
            } elseif ($kpiBahagian->peratus_pencapaian > 50) {
                $kpiBahagian->status = 'pending';
            } else {
                $kpiBahagian->status = 'not achieved';
            }
    
            // Save the reason and changes
            $kpiBahagian->reason = $reason;
            $kpiBahagian->save();
    
            // Return success response with custom alert
            return redirect()->route('user.kpi.index')->with([
                'status' => 'Achievement updated successfully.',
                'alert-type' => 'success',
            ]);
    
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'An unexpected error occurred. Please try again later.',
                'alert-type' => 'danger',
            ]);
        }
    }
}
