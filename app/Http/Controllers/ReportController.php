<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Institution;
use App\Models\Bahagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Prepare Report Data based on filters
     */
    private function prepareReportData(Request $request)
    {
        $username = Auth::user();

        // Collect filter values
        $stateId = $request->input('state_id');
        $institutionId = $request->input('institution_id');
        $bahagianId = $request->input('bahagian_id');
        $quarter = $request->input('quarter');

        // SQL Query with filters
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
        ";

        // Execute the query with parameters
        $reports = DB::select($query, [
            $bahagianId, $bahagianId, $quarter, $quarter,
            $institutionId, $institutionId, $quarter, $quarter,
            $stateId, $stateId, $quarter, $quarter
        ]);

        // Summary Data
        $summary = [
            'achieved' => collect($reports)->where('status', 'achieved')->count(),
            'not_achieved' => collect($reports)->where('status', 'not achieved')->count(),
            'pending' => collect($reports)->where('status', 'pending')->count(),
        ];

        // Dropdown data
        $states = State::all();
        $institutions = Institution::all();
        $bahagian = Bahagian::all();

        return compact('reports', 'states', 'institutions', 'bahagian', 'username', 'summary');
    }

    /**
     * Display the KPI Report
     */
    public function index(Request $request)
    {
        $data = $this->prepareReportData($request);
        $data['visualData'] = $this->prepareVisualData(); // Add visual breakdown data
        return view('reports.index', $data);
    }

    /**
     * Export KPI Report as PDF
     */
    public function exportPDF(Request $request, PDF $pdf)
    {
        // Fetch filtered data
        $data = $this->prepareReportData($request);
    
        // Group data for visual breakdown
        $data['statesGroupedData'] = collect($data['reports'])
            ->where('type', 'State')
            ->groupBy('entity_name')
            ->map(function ($group) {
                return [
                    'achieved' => $group->where('status', 'achieved')->count(),
                    'not_achieved' => $group->where('status', 'not achieved')->count(),
                    'pending' => $group->where('status', 'pending')->count(),
                ];
            });
    
        $data['institutionsGroupedData'] = collect($data['reports'])
            ->where('type', 'Institution')
            ->groupBy('entity_name')
            ->map(function ($group) {
                return [
                    'achieved' => $group->where('status', 'achieved')->count(),
                    'not_achieved' => $group->where('status', 'not achieved')->count(),
                    'pending' => $group->where('status', 'pending')->count(),
                ];
            });
    
        $data['bahagianGroupedData'] = collect($data['reports'])
            ->where('type', 'Bahagian')
            ->groupBy('entity_name')
            ->map(function ($group) {
                return [
                    'achieved' => $group->where('status', 'achieved')->count(),
                    'not_achieved' => $group->where('status', 'not achieved')->count(),
                    'pending' => $group->where('status', 'pending')->count(),
                ];
            });
    
        // Generate PDF
        $pdf = $pdf->loadView('reports.pdf', $data);
        return $pdf->download('KPI_Report_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export KPI Report as CSV
     */
    public function exportCSV(Request $request)
    {
        $data = $this->prepareReportData($request);
        $reports = $data['reports'];

        $csvHeaders = [
            'KPI Statement', 'Entity Name', 'Pencapaian', 'Peratus Pencapaian', 'Status', 'Quarter'
        ];

        $csvData = [];
        foreach ($reports as $report) {
            $csvData[] = [
                $report->kpi_statement,
                $report->entity_name,
                $report->pencapaian,
                $report->peratus_pencapaian,
                ucfirst($report->status),
                $report->quarter,
            ];
        }

        $fileName = 'KPI_Report_' . now()->format('Y-m-d') . '.csv';

        // Create CSV
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

    private function prepareVisualData()
    {
        return DB::table('kpi_bahagian as kb')
            ->join('bahagian as b', 'kb.bahagian_id', '=', 'b.id')
            ->select(
                'b.nama_bahagian as title',
                DB::raw('SUM(CASE WHEN kb.status = "achieved" THEN 1 ELSE 0 END) as achieved'),
                DB::raw('SUM(CASE WHEN kb.status = "not achieved" THEN 1 ELSE 0 END) as not_achieved'),
                DB::raw('SUM(CASE WHEN kb.status = "pending" THEN 1 ELSE 0 END) as pending')
            )
            ->groupBy('b.nama_bahagian')
            ->get();
    }
}
