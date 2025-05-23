<?php

namespace App\Http\Controllers\all;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class infografikController extends Controller
{
     public function index(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));
        $totalKpi = $this->getTotalKpi($selectedYear);

        // KPI counts
        $skkKpi = $this->getTotalKpiBySector($selectedYear, 'Sektor Keselamatan Dan Koreksional');
        $smKpi = $this->getTotalKpiBySector($selectedYear, 'Sektor Pemasyarakatan');
        $spKpi = $this->getTotalKpiBySector($selectedYear, 'Sektor Pengurusan');
        $bduKpi = $this->getTotalKpiBySector($selectedYear, 'Bahagian & Unit');

        // pecahan kpi bahagian & unit
        $sectors = Sector::with(['bahagian.addKpis' => function ($query) use ($selectedYear) {
            $query->where('year', $selectedYear);
        }])->get()->map(function ($sector) {
            return [
                'name' => $sector->name,
                'bahagian' => $sector->bahagian->map(function ($bahagian) {
                    return [
                        'nama_bahagian' => $bahagian->nama_bahagian,
                        'icon' => $bahagian->icon,
                        'kpis' => $bahagian->addKpis->map(function ($kpi) {
                            return [
                                'pernyataan_kpi' => $kpi->pernyataan_kpi,
                                'indikator' => $kpi->indikator,
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ];
        })->toArray();

        // pemilik kpi chart

        $data = [
            'kjp' => DB::table('kpi_kjp')->distinct()->count('add_kpi_id'),  
            'states' => DB::table('kpi_states')->distinct()->count('add_kpi_id'),  
            'institutions' => DB::table('kpi_institutions')->distinct()->count('add_kpi_id'),  
            'bahagian' => DB::table('kpi_bahagian')->distinct()->count('add_kpi_id'),  
        ];
    
        // ringkasan kpi
        $kpis = DB::table('add_kpis')
        ->select('pernyataan_kpi', 'indikator')
        ->where('year', $selectedYear)
        ->get();

        return view('all.infografik', compact('totalKpi', 'skkKpi', 'smKpi', 'spKpi', 'bduKpi', 'sectors', 'kpis', 'selectedYear', 'data'));
    }

    public function infografik(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        // Get total KPI count
        $totalKpi = $this->getTotalKpi($year);
        
        // Get KPI counts by sector 
        $skkKpi = $this->getTotalKpiBySector($year, 'Sektor Keselamatan Dan Koreksional');
        $smKpi = $this->getTotalKpiBySector($year, 'Sektor Pemasyarakatan');
        $spKpi = $this->getTotalKpiBySector($year, 'Sektor Pengurusan');
        $bduKpi = $this->getTotalKpiBySector($year, 'Bahagian & Unit');
        
        // Get sector data with bahagian and their KPIs
        $sectors = Sector::with(['bahagian.addKpis' => function ($query) use ($year) {
            $query->where('year', $year);
        }])->get()->map(function ($sector) {
            return [
                'name' => $sector->name,
                'bahagian' => $sector->bahagian->map(function ($bahagian) {
                    return [
                        'nama_bahagian' => $bahagian->nama_bahagian,
                        'icon' => $bahagian->icon ?? 'default-icon.svg',
                        'kpi_count' => $bahagian->addKpis->count(),
                        'kpis' => $bahagian->addKpis->map(function ($kpi) {
                            return [
                                'pernyataan_kpi' => $kpi->pernyataan_kpi,
                                'indikator' => $kpi->indikator,
                                'pemilik' => $kpi->pemilik
                            ];
                        })->toArray()
                    ];
                })->toArray()
            ];
        })->toArray();
        
        // Return response with all necessary data
        return response()->json([
            'Jumlah KPI' => $totalKpi,
            'Sektor Keselamatan Dan Koreksional' => $skkKpi,
            'Sektor Pemasyarakatan' => $smKpi,
            'Sektor Pengurusan' => $spKpi,
            'Bahagian & Unit' => $bduKpi,
            'sectors' => $sectors,
            'year' => $year
        ]);
    }

    // Helper methods (assuming these are already defined in your controller)
    private function getTotalKpi($year)
    {
        return DB::table('add_kpis')
            ->where('year', $year)
            ->count();
    }

    private function getTotalKpiBySector($year, $sectorName)
    {
        return DB::table('add_kpis')
            // ->join('bahagian', 'add_kpis.bahagian_id', '=', 'bahagians.id')
            ->join('sectors', 'add_kpis.sectors_id', '=', 'sectors.id')
            ->where('sectors.name', $sectorName)
            ->where('add_kpis.year', $year)
            ->count();
    }
}
