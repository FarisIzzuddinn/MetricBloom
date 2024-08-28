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
        $user = Auth::User();
        return view('admin.teras.index', compact('teras', 'user'));
    }

    public function create()
    {
        return view('admin.teras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'teras' => 'required|string|max:255',
        ]);

        Teras::create([
            'teras' => $request->teras,
        ]);

        return redirect()->route('teras.index')->with("status", "SO created successfully");
    }

    public function edit(Teras $teras)
    {
        return view('admin.teras.edit', compact('teras'));
    }

    public function update(Request $request, Teras $teras)
    {
        $request->validate([
            'teras' => [
                'required',
                'string',
                'unique:teras,teras,' . $teras->id // Ensure table name is correct
            ]
        ]);

        $teras->update([
            'teras' => $request->teras,
        ]);

        return redirect()->route('teras.index')->with("status", "SO updated successfully");
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
            $teras->delete();
            $this->renumberItems(); // Renumber items after deletion
            return redirect()->route('teras.index')->with("status", "Teras delete successfully");
        }

        return redirect()->route('teras.index')->with("status", "SO not found");
    }
}
