<?php

namespace App\Http\Controllers;

use App\Models\Teras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerasController extends Controller
{
    public function index()
    {
        $teras = Teras::select('id', 'teras')->paginate(20);
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
            return redirect()->route('teras.index')->with('error', 'Nilai Teras Sudah Wujud. Sila Masukkan Nilai Unik.');
        }

        // Check if a soft-deleted record with the same 'teras' value exists
        // $existingTeras = Teras::withTrashed()->where('teras', $request->teras)->first();

        // if ($existingTeras) {
        //     // If a soft-deleted record exists, restore it instead of creating a new one
        //     $existingTeras->restore();

        //     return redirect()->route('teras.index')->with('success', 'Teras Berjaya Dikembalikan.');
        // }

        $teras = $request->only(['teras']);
        $teras['created_by'] = auth()->id();
        
        Teras::create($teras);

        return redirect()->route('teras.index')->with('success', 'Teras Berjaya Dicipta.');
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
            return redirect()->back()->with('error', 'Nilai Teras Sudah Wujud. Sila Masukkan Nilai Unik.');
        }
    
        $teras = Teras::findOrFail($id);
        $teras->update([
            'teras' => $request->input('teras'),
            'updated_by' => auth()->id(), 
        ]);


        // Redirect back with success message
        return redirect()->route('teras.index')->with('success', 'Teras Berjaya Dikemaskini.');
    }

    public function destroy($terasId)
    {
        $teras = Teras::find($terasId);

        if ($teras) {
            $isInUse = $teras -> AddKpis()->exists();

            if ($isInUse){
                return redirect()->route('teras.index')->with('danger', 'Teras Tidak Boleh Dipadam Kerana Sedang Digunakan.');
            }

            $teras->deleted_by = auth()->id();
            $teras->save();
            $teras->delete();

            return redirect()->route('teras.index')->with('success', 'Teras Berjaya Dipadam.');
        }

        return redirect()->route('teras.index')->with('danger', 'Teras Tidak Dijumpai.');
    }
}

