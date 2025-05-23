<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoController extends Controller
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
            'name' => 'required|string|max:255', // Use 'name' instead of 'SO'
        ]);

        $duplicateSector = Sector::where('name', $request->name)->exists();

        if ($duplicateSector) {
            return redirect()->route('sector.index')->with('danger', 'Nilai Sektor Sudah Wujud. Sila Masukkan Nilai Unik.');
        }

        // Check for soft-deleted record with the same name
        $existingSector = Sector::withTrashed()->where('name', $request->name)->first();

        if ($existingSector) {
            $existingSector->restore();

            return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dikembalikan.');
        }

        Sector::create([
            'name' => $request->name,
        ]);

        return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dicipta.');
    }

    public function update(Request $request, Sector $sector)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Use 'name' instead of 'SO'
        ]);

        $existingSector = Sector::where('name', $request->name)
            ->where('id', '!=', $sector->id)
            ->first();

        if ($existingSector) {
            return redirect()->back()->with('danger', 'Nilai Sektor Sudah Wujud. Sila Masukkan Nilai Unik.');
        }

        $sector->update([
            'name' => $request->name,
        ]);

        return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dikemaskini.');
    }

    public function destroy($sectorId)
    {
        $sector = Sector::find($sectorId);

        if ($sector) {
            $isInUse = $sector->addKpis()->exists();

            if ($isInUse) {
                return redirect()->route('sector.index')->with('danger', 'Sektor Tidak Boleh Dipadam Kerana Sedang Digunakan.');
            }

            $sector->delete();
            $this->renumberItems();

            return redirect()->route('sector.index')->with('success', 'Sektor Berjaya Dipadam.');
        }

        return redirect()->route('sector.index')->with('danger', 'Sektor Tidak Dijumpai.');
    }
}
