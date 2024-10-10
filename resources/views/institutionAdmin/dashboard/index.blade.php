@extends('layout')

@section('title', 'Dashboard')

@section('content')


<div class="container-fluid">
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('stateAdmin.dashboard')}}">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
    

    <div class="row">
        <!-- Overview of KPIs -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-left-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">Overview of KPIs</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>Total KPIs Assigned: <strong>{{ $totalKPIs }}</strong></li>
                        <li>Total KPIs Achieved: <strong>{{ $achievedKPIs }}</strong></li>
                        <li>Total KPIs Under Review: <strong>{{ $underReviewKPIs }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Performance Summary -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-left-info">
                <div class="card-header bg-info text-white">
                    <h5 class="m-0">Performance Summary</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Overall Performance: <strong>{{ $overallPerformance }}%</strong></h5>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $overallPerformance }}%" aria-valuenow="{{ $overallPerformance }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Activity Summary -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-left-success">
                <div class="card-header bg-success text-white">
                    <h5 class="m-0">User Activity Summary</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Total Users: <strong>{{ $activeUsers + $inactiveUsers }}</strong></h5>
                    <h5 class="card-title">Active Users: <strong>{{ $activeUsers }}</strong></h5>
                    <h5 class="card-title">Inactive Users: <strong>{{ $inactiveUsers }}</strong></h5>
                </div>
            </div>
        </div>

        <!-- Total KPIs for Institution -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow-sm border-left-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="m-0">Total KPIs for Institution</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Total KPIs: <strong>{{ $totalKPIs }}</strong></h5>
                    <h6 class="card-subtitle mb-2 text-muted">KPIs Achieved: <strong>{{ $achievedKPIs }}</strong></h6>
                    <h6 class="card-subtitle mb-2 text-muted">KPIs Under Review: <strong>{{ $underReviewKPIs }}</strong></h6>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Assignment Overview Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">KPI Assignment Overview</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>KPI</th>
                        <th>Institutions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kpis as $kpi)
                    <tr>
                        <td>{{ $kpi->pernyataan_kpi }}</td>
                        <td>
                            @if ($kpi->institutions->isNotEmpty())
                                @foreach ($kpi->institutions as $institution)
                                    {{ $institution->name }}<br> <!-- Display each institution name -->
                                @endforeach
                            @else
                                No Institution Assigned
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
