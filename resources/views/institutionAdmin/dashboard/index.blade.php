@extends('layout')
@section('content')
<style>
        .container-fluid {
        padding: 20px;
    }

    .page-header {
        background-color: #007bff;
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .page-header h1, .page-header h5 {
        margin: 0;
        padding: 0;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        font-weight: bold;
        font-size: 1.1rem;
        background-color: #f8f9fa;
        border-bottom: none;
    }

    .card-body {
        padding: 20px;
    }

    .summary-card {
        border: none;
        background-color: #f8f9fa;
        border-radius: 8px;
        text-align: center;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .summary-card h2 {
        margin: 0;
        font-size: 2.5rem;
    }

    .form-control {
        border-radius: 8px;
    }

    .table {
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>

<div class="container-fluid">
    @if ($institution)
        <div class="page-header">
            <h1>{{ $institution->name }} Dashboard</h1>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Total KPI</h6>
                    <h2 class="text-primary">{{ $kpis->count() }}</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Achieved KPI</h6>
                    <h2 class="text-success">{{ $kpis->where('peratus_pencapaian', 100)->count() }}</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Pending KPI</h6>
                    <h2 class="text-warning">{{ $kpis->whereBetween('peratus_pencapaian', [1, 99])->count() }}</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Not Achieved KPI</h6>
                    <h2 class="text-danger">{{ $kpis->where('peratus_pencapaian', 0)->count() }}</h2>
                </div>
            </div>
        </div>

        <!-- KPI Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">KPIs Assigned to {{ $institution->name }}</h5>
            </div>
            <div class="card-body">
                @if ($kpis->isEmpty())
                    <p>No KPIs assigned to this institution.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>KPI Name</th>
                                <th>Target</th>
                                <th>Achievement (%)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kpis as $index => $kpi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kpi->pernyataan_kpi }}</td>
                                    <td>{{ $kpi->sasaran }}</td>
                                    <td>{{ $kpi->peratus_pencapaian }}</td>
                                    <td>
                                        <span class="badge {{ $kpi->peratus_pencapaian >= $kpi->sasaran ? 'bg-success' : 'bg-danger' }}">
                                            {{ $kpi->peratus_pencapaian >= $kpi->sasaran ? 'Achieved' : 'Not Achieved' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            <p>No institution assigned to this user. Please contact the administrator.</p>
        </div>
    @endif
</div>
@endsection
