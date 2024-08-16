<?php

namespace App\Http\Controllers;

use App\Models\So;
use Illuminate\Http\Request;

class SoController extends Controller
{
    public function index()
    {
        $so = So::all(); // Retrieve all SO records
        return view('admin.SO.index', compact('so'));
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

        So::create([
            'SO' => $request->SO,
        ]);

        return redirect()->route('so.index')->with("status", "SO created successfully");
    }

    public function edit(So $so)
    {
        return view('admin.SO.edit', compact('so'));
    }

    public function update(Request $request, So $so)
    {
        $request->validate([
            'SO' => [
                'required',
                'string',
                'unique:sos,SO,' . $so->id // Ensure table name is correct
            ]
        ]);

        $so->update([
            'SO' => $request->SO,
        ]);

        return redirect()->route('so.index')->with("status", "SO updated successfully");
    }
    public function destroy($soId){
        $so = So::find($soId);
        $so->delete();

        return redirect()->route('so.index')->with("status", "Permission Delete Successfully");
    }
}
