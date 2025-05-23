<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Bahagian;
use Illuminate\Http\Request;

class BahagianController extends Controller
{
     /**
     * Display a listing of bahagians grouped by sector.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all sectors with their related bahagians
        $sectors = Sector::with('bahagians')->get();
        
        return view('bahagian.index', compact('sectors'));
    }

    /**
     * Store a newly created bahagian in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|file|mimes:svg|max:2048',
            'sector_id' => 'required|exists:sectors,id',
        ]);

        $iconPath = $request->file('icon')->store('uploads/icons', 'public');

        Bahagian::create([
            'nama_bahagian' => $request->name,
            'sector_id' => $request->sector_id,
            'icon' => $iconPath,
        ]);

        return redirect()->route('bahagian.index')
            ->with('status', 'Bahagian created successfully')
            ->with('alert-type', 'success');
    }

    /**
     * Update the specified bahagian in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bahagian  $bahagian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sector_id' => 'required|exists:sectors,id',
            'icon' => 'nullable|mimes:svg|max:2048', // Only SVG files, max size 2MB
        ]);

        $bahagian = Bahagian::findOrFail($id);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public'); // Save in storage/app/public/icons
            $bahagian->icon = $iconPath;
        }

        // Update other fields
        $bahagian->update([
            'nama_bahagian' => $request->name,
            'sector_id' => $request->sector_id,
        ]);

        // Save icon if uploaded
        $bahagian->save();

        return redirect()->route('bahagian.index')
            ->with('status', 'Bahagian updated successfully')
            ->with('alert-type', 'success');
    }


    /**
     * Remove the specified bahagian from storage.
     *
     * @param  \App\Models\Bahagian  $bahagian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bahagian = Bahagian::findOrFail($id);
        $bahagian->delete();

        return redirect()->route('bahagian.index')
            ->with('status', 'Bahagian deleted successfully')
            ->with('alert-type', 'success');
    }
}
