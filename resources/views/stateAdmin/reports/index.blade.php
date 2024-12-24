@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary">State Performance Report</h1>
        <p class="text-secondary fs-5">Overview of {{ $state->name }} institutions' performance for selected KPIs.</p>
    </div>

    <!-- Filters Section -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0 text-center">Generate KPI Report</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.state', ['state' => $state->id]) }}" class="mb-4">
                <div class="row g-3">
                    <!-- Quarter Filter -->
                    <div class="col-md-4">
                        <label for="quarter" class="form-label fw-bold">Quarter</label>
                        <select name="quarter" id="quarter" class="form-select shadow-sm" onchange="this.form.submit()">
                            <option value="">All Quarters</option>
                            <option value="1" {{ request('quarter') == '1' ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                            <option value="2" {{ request('quarter') == '2' ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                            <option value="3" {{ request('quarter') == '3' ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                            <option value="4" {{ request('quarter') == '4' ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                        </select>
                    </div>
                </div>
            </form>

            <form method="GET" action="{{ route('reports.export.state', ['state' => $state->id]) }}">
                <button type="submit" class="btn btn-danger">Export as PDF</button>
            </form>
            
        </div>
    </div>

    <!-- Report Section with Institutions Grouped Data -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-info text-white">
            <h2 class="mb-0 text-center">Pecahan Pencapaian Mengikut Institusi</h2>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $institutionsGroupedData = collect($reports)
                        ->where('type', 'Institution')
                        ->groupBy('entity_name')
                        ->map(function ($group) {
                            return [
                                'achieved' => $group->where('status', 'achieved')->count(),
                                'not_achieved' => $group->where('status', 'not achieved')->count(),
                                'pending' => $group->where('status', 'pending')->count(),
                            ];
                        });
                @endphp

                <!-- Reports Section -->
                <div class="row">
                    @forelse ($reports as $report)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100 border-0">
                            <!-- Institution Name -->
                            <div class="card-header bg-secondary text-white text-center fw-bold py-3">
                                {{ $report['institution_name'] }}
                            </div>
                            <!-- KPI Performance -->
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="badge bg-success mx-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ $report['achieved'] }}
                                    </div>                                    
                                    <div class="badge bg-warning mx-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ $report['pending'] }}
                                    </div>
                                    <div class="badge bg-danger mx-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 20px;">
                                        {{ $report['not_achieved'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p class="text-muted fs-5">No data available for the selected filters.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
