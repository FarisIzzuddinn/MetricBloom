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
   

    public function destroy($soId)
    {
        $so = So::find($soId);
        if ($so) {
            $so->delete();
            $this->renumberItems(); // Renumber items after deletion
            return redirect()->route('so.index')->with("status", "SO deleted and renumbered successfully");
        }

        return redirect()->route('so.index')->with("status", "SO not found");
    }
}
