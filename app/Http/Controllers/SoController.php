<?php

namespace App\Http\Controllers;

use App\Models\So;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoController extends Controller
{
    public function index()
    {
        $so = So::all(); // Retrieve all SO records
        $username = Auth::User();
        return view('admin.SO.index', compact('so', 'username'));
    }

    public function renumberItems()
    {
        $items = So::orderBy('created_at')->get();
        foreach ($items as $index => $item) {
            $item->update(['position' => $index + 1]);
        }
    }

    public function create()
    {
        return view('admin.SO.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'SO' => 'required|string|max:255',
        ]);

        $duplicateSo = SO::where('so', $request->SO)->exists();

        if ($duplicateSo) {
            // If an active record already exists, return with an error message
            return redirect()->route('so.index')->with([
                'status' => "Duplicate data: Sector Operation already exists.",
                'alert-type' => "danger"
            ]);
        }

        // Check if a soft-deleted record with the same 'teras' value exists
        $existingSo = So::withTrashed()->where('so', $request->SO)->first();

        if ($existingSo) {
            // If a soft-deleted record exists, restore it instead of creating a new one
            $existingSo->restore();

            return redirect()->route('so.index')->with([
                'status' => "Sector Operation restored successfully.",
                'alert-type' => "success"
            ]);
        }

        So::create([
            'SO' => $request->SO,
        ]);

        return redirect()->route('so.index')->with([
            'status' => "Sector Operation created successfully.",
            'alert-type' => "success"
        ]);
    }

    public function edit(So $so)
    {
        return view('admin.SO.edit', compact('so'));
    }

    public function update(Request $request, So $so)
    {
        // Validate the request
        $request->validate([
            'SO' => 'required|string|max:255',
        ]);
    
        $existingSo = So::where('SO', $request->input('SO'))->where('id', '!=', $so->id)->first();
    
        if ($existingSo) {
            return redirect()->back()->with([
                'status' => 'The Sector Operation value already exists.',
                'alert-type' => 'danger'
            ]);
        }
    
        // Update the SO if no duplicate is found
        $so->update([
            'SO' => $request->input('SO'),
        ]);
    
        // Redirect back with success message
        return redirect()->route('so.index')->with([
            'status' => 'SO updated successfully.',
            'alert-type' => 'success'
        ]);
    }
    
   
    public function destroy($soId)
    {
        $so = So::find($soId);

        if ($so) {
            // Check if the SO record is in use by other records
            $isInUse = $so->addKpis()->exists(); 

            // Data have relation or in use
            if ($isInUse) {
                return redirect()->route('so.index')->with([
                    'status' => 'Sector Operational cannot be deleted because it is in use.',
                    'alert-type' => 'danger'
                ]);
            }

            // No data related
            $so->delete();
            $this->renumberItems(); 

            return redirect()->route('so.index')->with([
                'status' => 'Sector Operational deleted successfully',
                'alert-type' => 'success' 
            ]);
        }

        return redirect()->route('so.index')->with([
            'status' => 'Sector Operational not found.',
            'alert-type' => 'warning' 
        ]);
    }
}

