<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::select('id', 'name', 'state_id')->with('state')->paginate(20);
        $states = State::select('id', 'name')->get();
        return view('superAdmin.Institution.index', compact('institutions', 'states'));
    }

    public function create()
    {
        return view('superAdmin.Institution.create');
    }

    public function store(Request $request)
    {
        $user_id = auth()->id();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'nullable|exists:states,id',
        ]);


        $institutions = $request->only(['name', 'state_id']);
        $institutions['created_by'] = $user_id;
        Institution::create($institutions);

        return redirect()->route('institutions.index')->with('success', 'Institution created successfully.');
    }

    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'nullable|exists:states,id', // Ensure state_id is valid
        ]);

        $data = $request->only(['name', 'state_id']);
        $data['updated_by'] = auth()->id();
        $institution->update($data);

        return redirect()->route('institutions.index')->with('success', 'Institution updated successfully.');
    }

    public function destroy($id)
    {
        $institution = Institution::findOrFail($id);
        $institution->deleted_by = auth()->id(); 
        $institution->save(); 

        $institution->delete(); // Soft delete
        return redirect()->route('institutions.index')->with('success', 'Institution deleted successfully.');
    }

}
