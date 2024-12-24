<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class institusiReportController extends Controller
{
    public function generateReportInstitutions($stateId){
        $username = Auth::user();
        $state = State::with('institutions.kpis')->findOrFail($stateId);

        $reports = $state->institutions->map(function ($institution) {
            $kpis = $institution->kpis;

            return [
                'institution_name' => $institution->name,
                'achieved' => $kpis->where('status', 'achieved')->count(),
                'not_achieved' => $kpis->where('status', 'not achieved')->count(),
                'pending' => $kpis->where('status', 'pending')->count(),
            ];
        });

        return view('stateAdmin.reports.index', compact('username', 'state', 'reports'));
    }
}
