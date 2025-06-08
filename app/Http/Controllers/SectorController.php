<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::paginate(20); // Retrieve all sectors
        $username = Auth::user();
        return view('admin.SO.index', compact('sectors', 'username'));
    }

    public function renumberItems()
    {
        $items = Sector::orderBy('created_at')->get();
        foreach ($items as $index => $item) {
            $item->update(['position' => $index + 1]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $duplicateSector = Sector::where('name', $request->name)->exists();

        if ($duplicateSector) {
            return redirect()->route('sector.index')->with('error', 'Nilai Sektor Sudah Wujud. Sila Masukkan Nilai Unik.');
        }

        Sector::create([
            'name' => $request->name,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dicipta.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $existingSector = Sector::where('name', $request->input('name'))->where('id', '!=', $id)->first();
    
        if ($existingSector) {
            return redirect()->back()->with('error', 'Nilai Sektor Sudah Wujud. Sila Masukkan Nilai Unik.');
        }
    

        $sector = Sector::findOrFail($id);
        $sector->update([
            'name' => $request->input('name'),
            'updated_by' => auth()->id(), 
        ]);

        return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dikemaskini.');
    }

    public function destroy($sectorId)
    {
        $sector = Sector::find($sectorId);

        if ($sector) {
            $isInUse = $sector->addKpis()->exists();

            if ($isInUse) {
                return redirect()->route('sector.index')->with('error', 'Sektor Tidak Boleh Dipadam Kerana Sedang Digunakan.');
            }

            $sector->deleted_by = auth()->id();
            $sector->save();

            $sector->delete();

            return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dipadam.');
        }

        return redirect()->route('sector.index')->with('error', 'Sektor Tidak Dijumpai.');
    }
}
