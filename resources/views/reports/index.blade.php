@extends('layout')

@section('content')
<div class="container">
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Generate KPI Report</h2>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('reports.index') }}" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="state_id" class="form-label fw-bold">State/Region</label>
                        <select name="state_id" id="state_id" class="form-select">
                            <option value="">All Regions</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="institution_id" class="form-label fw-bold">Institution</label>
                        <select name="institution_id" id="institution_id" class="form-select">
                            <option value="">All Institutions</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" {{ request('institution_id') == $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="bahagian_id" class="form-label fw-bold">Department (Bahagian)</label>
                        <select name="bahagian_id" id="bahagian_id" class="form-select">
                            <option value="">All Departments</option>
                            @foreach($bahagian as $b)
                                <option value="{{ $b->id }}" {{ request('bahagian_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_bahagian }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="quarter" class="form-label fw-bold">Quarter</label>
                    <select name="quarter" id="quarter" class="form-select">
                        <option value="">All Quarters</option>
                        <option value="1" {{ request('quarter') == 1 ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                        <option value="2" {{ request('quarter') == 2 ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                        <option value="3" {{ request('quarter') == 3 ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                        <option value="4" {{ request('quarter') == 4 ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                    </select>
                </div>
                

                <div class="row mt-4">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('reports.pdf', request()->query()) }}" class="btn btn-primary">Export as PDF</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h2 class="mb-0">Report Table</h2>
        </div>
        <div class="card-body">
            <!-- Report Table -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>KPI Statement</th>
                        <th>Owner</th>
                        <th>Pencapaian</th>
                        <th>Peratus Pencapaian</th>
                        <th>Status</th>
                        <th>Quarter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr>
                            <td>{{ $report->kpi_statement }}</td>
                            <td>{{ $report->entity_name }}</td>
                            <td>{{ $report->pencapaian }}</td>
                            <td>{{ $report->peratus_pencapaian }}%</td>
                            <td>
                                <span class="badge {{ $report->status === 'achieved' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td>{{ $report->quarter }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
