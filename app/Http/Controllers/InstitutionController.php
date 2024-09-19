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
        $institutions = Institution::with('state')->get();
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
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|exists:states,id',
            'description' => 'nullable|string',
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
            'state_id' => 'required|exists:states,id',
            'description' => 'nullable|string',
        ]);

        $institution->update($request->all());

        return redirect()->route('institutions.index')->with('success', 'Institution updated successfully.');
    }

    public function renumberItems(){
        $items = Institution::orderBy('created_at')->get();
        foreach ($items as $index => $item) {
            $item->update(['position' => $index + 1]);
        }
    }

    public function destroy(Institution $institution)
    {
        $institution->delete();
        $this->renumberItems();

        return redirect()->route('institutions.index')->with('success', 'Institution deleted successfully.');
    }
}
