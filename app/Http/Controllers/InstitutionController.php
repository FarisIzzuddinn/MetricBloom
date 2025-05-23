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
        $institutions = Institution::with('state')->paginate(20);
        $states = State::all();
        $username = Auth::User();
        return view('superAdmin.Institution.index', compact('institutions', 'states', 'username'));
    }

    public function create()
    {
        return view('superAdmin.Institution.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'nullable|exists:states,id',
        ]);

        Institution::create($request->all());

        return redirect()->route('institutions.index')->with('success', 'Institution created successfully.');
    }

    public function edit(Institution $institution)
    {
        $states = State::all();
        return view('institutions.edit', compact('institution', 'states'));
    }

    public function update(Request $request, Institution $institution)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'nullable|exists:states,id', // Ensure state_id is valid
        ]);

        // Update institution with all request data
        $institution->update($request->all());

        return redirect()->route('institutions.index')->with('success', 'Institution updated successfully.');
    }

    public function destroy($id){
        $institution = Institution::findOrFail($id);
        $institution->delete();
        return redirect()->route('institutions.index')->with('success', 'Institution deleted successfully.');
    }
}
