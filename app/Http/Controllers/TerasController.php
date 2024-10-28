<?php

namespace App\Http\Controllers;

use App\Models\Teras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerasController extends Controller
{
    public function index()
    {
        $teras = Teras::all(); // Retrieve all SO records
        $username = Auth::User();
        return view('admin.teras.index', compact('teras', 'username'));
    }

    public function create()
    {
        return view('admin.teras.create');
    }

    public function store(Request $request)
    {
        // Validate the request input
        $request->validate([
            'teras' => 'required|string|max:255',
        ]);

        $duplicateTeras = Teras::where('teras', $request->teras)->exists();

        if ($duplicateTeras) {
            // If an active record already exists, return with an error message
            return redirect()->route('teras.index')->with([
                'status' => "Duplicate data: Teras already exists.",
                'alert-type' => "danger"
            ]);
        }

        // Check if a soft-deleted record with the same 'teras' value exists
        $existingTeras = Teras::withTrashed()->where('teras', $request->teras)->first();

        if ($existingTeras) {
            // If a soft-deleted record exists, restore it instead of creating a new one
            $existingTeras->restore();

            return redirect()->route('teras.index')->with([
                'status' => "Teras restored successfully.",
                'alert-type' => "success"
            ]);
        }

        // If no soft-deleted record exists, create a new one
        Teras::create([
            'teras' => $request->teras,
        ]);

        return redirect()->route('teras.index')->with([
            'status' => "Teras created successfully.",
            'alert-type' => "success"
        ]);
    }

    public function edit($id)
    {
        $teras = Teras::findOrFail($id);
        return view('admin.teras.edit', compact('teras'));
        
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'teras' => 'required|string|max:255',
        ]);
    
        // Check if the teras already exists with the same name but a different ID
        $existingTeras = Teras::where('teras', $request->input('teras'))->where('id', '!=', $id)->first();
    
        if ($existingTeras) {
            // Redirect back with an error message if duplicate found
            return redirect()->back()->with([
                'status' => 'The Teras value already exists. Please enter a unique value.',
                'alert-type' => 'danger'
            ]);
        }
    
        // Find the teras by ID and update it
        $teras = Teras::findOrFail($id);
        $teras->teras = $request->input('teras');
        $teras->save();
    
        // Redirect back with success message
        return redirect()->route('teras.index')->with([
            'status' => 'Teras updated successfully.',
            'alert-type' => 'success'
        ]);
    }
    

    public function renumberItems()
    {
        $items = Teras::orderBy('created_at')->get();
        foreach ($items as $index => $item) {
            $item->update(['position' => $index + 1]);
        }
    }

    public function destroy($terasId)
    {
        $teras = Teras::find($terasId);

        if ($teras) {
            // if teras has relation 
            $isInUse = $teras -> AddKpis()->exists();

            // Then the can't deleted 
            if ($isInUse){
                return redirect()->route('teras.index')->with([
                    'status' => "Teras cannot be deleted because it is in use.",
                    'alert-type' => "danger"
                ]);
            }

            // Else, delete the teras
            $teras->delete();
            $this->renumberItems(); 

            return redirect()->route('teras.index')->with([
                'status' => "Teras deleted successfully",
                'alert-type' => "success"
            ]);
        }

        return redirect()->route('teras.index')->with([
            'status' => "Teras not found",
            'alert-type' => "warning"
        ]);
    }
}

