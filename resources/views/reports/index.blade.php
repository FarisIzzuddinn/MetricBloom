@extends('layout')

@section('content')
<div class="container">
    <!-- Filter Form -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Generate KPI Report</h2>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="mb-4">
                <div class="row g-3">
                    <!-- State Filter -->
                    <div class="col-md-3">
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

                    <!-- Institution Filter -->
                    <div class="col-md-3">
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

                    <!-- Department Filter -->
                    <div class="col-md-3">
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

                    <!-- Quarter Filter -->
                    <div class="col-md-3">
                        <label for="quarter" class="form-label fw-bold">Quarter</label>
                        <select name="quarter" id="quarter" class="form-select">
                            <option value="">All Quarters</option>
                            <option value="1" {{ request('quarter') == 1 ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                            <option value="2" {{ request('quarter') == 2 ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                            <option value="3" {{ request('quarter') == 3 ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                            <option value="4" {{ request('quarter') == 4 ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-success">Filter</button>
                        <a href="{{ route('reports.pdf', request()->query()) }}" class="btn btn-primary">Export as PDF</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Visual Breakdown for States -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-info text-white">
            <h2 class="mb-0 text-center">Pecahan Pencapaian Mengikut Negeri</h2>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $statesGroupedData = collect($reports)
                        ->where('type', 'State')
                        ->groupBy('entity_name')
                        ->map(function ($group) {
                            return [
                                'achieved' => $group->where('status', 'achieved')->count(),
                                'not_achieved' => $group->where('status', 'not achieved')->count(),
                                'pending' => $group->where('status', 'pending')->count(),
                            ];
                        });
                @endphp

                @foreach ($statesGroupedData as $stateName => $data)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white text-center">
                            <strong>{{ $stateName }}</strong>
                        </div>
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <div class="badge bg-success mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['achieved'] }}
                                </div>
                                <div class="badge bg-warning mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['pending'] }}
                                </div>
                                <div class="badge bg-danger mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['not_achieved'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Repeat for Institutions -->
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

                @foreach ($institutionsGroupedData as $institutionName => $data)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white text-center">
                            <strong>{{ $institutionName }}</strong>
                        </div>
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <div class="badge bg-success mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['achieved'] }}
                                </div>
                                <div class="badge bg-warning mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['pending'] }}
                                </div>
                                <div class="badge bg-danger mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['not_achieved'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Repeat for Bahagian -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-info text-white">
            <h2 class="mb-0 text-center">Pecahan Pencapaian Mengikut Bahagian</h2>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $bahagianGroupedData = collect($reports)
                        ->where('type', 'Bahagian')
                        ->groupBy('entity_name')
                        ->map(function ($group) {
                            return [
                                'achieved' => $group->where('status', 'achieved')->count(),
                                'not_achieved' => $group->where('status', 'not achieved')->count(),
                                'pending' => $group->where('status', 'pending')->count(),
                            ];
                        });
                @endphp

                @foreach ($bahagianGroupedData as $bahagianName => $data)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white text-center">
                            <strong>{{ $bahagianName }}</strong>
                        </div>
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center">
                                <div class="badge bg-success mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['achieved'] }}
                                </div>
                                <div class="badge bg-warning mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['pending'] }}
                                </div>
                                <div class="badge bg-danger mx-2" style="width: 50px; height: 50px; font-size: 20px; line-height: 50px;">
                                    {{ $data['not_achieved'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
