<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Report;
use App\Models\Bahagian;
use Barryvdh\DomPDF\PDF;
use App\Models\Institution;
use App\Models\KpiBahagian;
use Illuminate\Http\Request;
use App\Models\KpiAchievement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    private function prepareReportData(Request $request)
    {
        $username = Auth::user();
    
        // Collect filter values
        $year = $request->input('year');
        $quarter = $request->input('quarter'); // New quarter filter
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $stateId = $request->input('state_id');
        $institutionId = $request->input('institution_id');
        $bahagianId = $request->input('bahagian_id');
    
        // SQL Query with Positional Placeholders
        $query = "
            SELECT 
                'Bahagian' AS type,
                ak.pernyataan_kpi AS kpi_statement,
                b.nama_bahagian AS entity_name,
                kb.bahagian_id AS entity_id,
                kb.pencapaian,
                kb.peratus_pencapaian,
                kb.status,
                kb.quarter
            FROM kpi_bahagian kb
            JOIN bahagian b ON kb.bahagian_id = b.id
            JOIN add_kpis ak ON kb.add_kpi_id = ak.id
            WHERE (? IS NULL OR kb.bahagian_id = ?)
            AND (? IS NULL OR kb.quarter = ?)
            AND (? IS NULL OR kb.quarter >= ?)
            AND (? IS NULL OR kb.quarter <= ?)
            
            UNION
            
            SELECT 
                'Institution' AS type,
                ak.pernyataan_kpi AS kpi_statement,
                i.name AS entity_name,
                ki.institution_id AS entity_id,
                ki.pencapaian,
                ki.peratus_pencapaian,
                ki.status,
                ki.quarter
            FROM kpi_institutions ki
            JOIN institutions i ON ki.institution_id = i.id
            JOIN add_kpis ak ON ki.add_kpi_id = ak.id
            WHERE (? IS NULL OR ki.institution_id = ?)
            AND (? IS NULL OR ki.quarter = ?)
            AND (? IS NULL OR ki.quarter >= ?)
            AND (? IS NULL OR ki.quarter <= ?)
            
            UNION
            
            SELECT 
                'State' AS type,
                ak.pernyataan_kpi AS kpi_statement,
                s.name AS entity_name,
                ks.state_id AS entity_id,
                ks.pencapaian,
                ks.peratus_pencapaian,
                ks.status,
                ks.quarter
            FROM kpi_states ks
            JOIN states s ON ks.state_id = s.id
            JOIN add_kpis ak ON ks.add_kpi_id = ak.id
            WHERE (? IS NULL OR ks.state_id = ?)
            AND (? IS NULL OR ks.quarter = ?)
            AND (? IS NULL OR ks.quarter >= ?)
            AND (? IS NULL OR ks.quarter <= ?)
        ";
    
        // Execute the query with parameters
        $reports = DB::select($query, [
            $bahagianId, $bahagianId, 
            $quarter, $quarter, $startDate, $startDate, $endDate, $endDate, 
            $institutionId, $institutionId, 
            $quarter, $quarter, $startDate, $startDate, $endDate, $endDate,
            $stateId, $stateId, 
            $quarter, $quarter, $startDate, $startDate, $endDate, $endDate
        ]);
    
        // Fetch data for dropdowns
        $states = State::all();
        $institutions = Institution::all();
        $bahagian = Bahagian::all();
    
        return compact('reports', 'states', 'institutions', 'bahagian', 'username');
    }
    

    
public function index(Request $request)
{
    $data = $this->prepareReportData($request);
    return view('reports.index', $data);
}



public function exportPDF(Request $request, PDF $pdf)
{
    $data = $this->prepareReportData($request);

    // Load the PDF view with the fetched data
    $pdf = $pdf->loadView('reports.pdf', $data);
    return $pdf->download('KPI_Report.pdf');
}


    public function exportCSV(Request $request)
{
    $reports = $this->prepareReportData($request); // Filter reports using your existing query

    $csvHeaders = [
        'KPI Statement', 'Entity Name', 
        'Pencapaian', 'Peratus Pencapaian', 'Status', 'Quarter'
    ];

    $csvData = [];
    foreach ($reports as $report) {
        $csvData[] = [
            $report->kpi_statement,
            $report->entity_name,
            $report->pencapaian,
            $report->peratus_pencapaian,
            $report->status,
            $report->quarter,
        ];
    }

    $fileName = 'KPI_Report.csv';
    $output = fopen('php://output', 'w');
    ob_start();

    fputcsv($output, $csvHeaders);
    foreach ($csvData as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    $content = ob_get_clean();

    return Response::make($content, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$fileName",
    ]);
}
    
}
