@extends('layout')

@section('title', 'Dashboard')

@section('content')

<style>
    /* Dashboard Container Styling */
    .container-fluid {
        padding: 15px;
    }

    /* Card Styling */
    .card {
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff; /* Full white background for all cards */
    }

    .card-header {
        background-color: #f8f9fa; /* Light grey for subtle differentiation */
        font-weight: 600;
        border-bottom: 1px solid #dee2e6;
    }

    .progress {
        height: 20px;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.1em;
        }
        .breadcrumb {
            font-size: 0.9em;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1em;
        }
        .breadcrumb {
            font-size: 0.85em;
        }
        .container-fluid {
            padding: 0 10px;
        }
    }
</style>

<div class="container-fluid">
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{route('stateAdmin.dashboard')}}"></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- KPI Overview Cards with equal height -->
<div class="row mb-4 g-3 d-flex align-items-stretch">
    <!-- Overview of KPIs -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title text-primary">Total KPI</h5>
                <p class="card-text display-4 mt-auto">{{ $totalKPIs }}</p>
            </div>
        </div>
    </div>

    <!-- Performance Summary -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title text-primary">Overall Performance</h5>
                <p class="card-text display-4 mt-auto">{{ $overallPerformance }}%</p>
            </div>
        </div>
    </div>

    <!-- User Activity Summary -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title text-primary">Active Users</h5>
                {{-- <p class="card-text display-4 mt-auto">{{ $activeUsers }}</p> --}}
            </div>
        </div>
    </div>
</div>

<div class="row mb-4 gx-4">
    <!-- Pie Chart for KPI Achievements vs Pending -->
    <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <h5 class="mb-0">KPI Distribution by Status</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                    <canvas id="kpiStatusPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-4">Detailed KPI Overview for State</h4>
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>BIL</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>PERATUS PENCAPAIAN</th>
                            <th>REASON</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpis->unique('pernyataan_kpi') as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->pernyataan_kpi }}</td>
                            <td>{{ $kpi->sasaran }}</td>
                            <td>{{ $kpi->peratus_pencapaian }}</td>
                            <td>{{ $kpi->reason }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data passed from backend (you can modify as per your actual data)
    const kpiData = {
        completed: {{ $pendingKPIs }},
        pending: {{ $achievedKPIs }},
    };

    // Pie Chart for KPI Status
    const ctx = document.getElementById('kpiStatusPieChart').getContext('2d');
    const kpiStatusPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                data: [kpiData.completed, kpiData.pending],
                backgroundColor: ['#4caf50', '#f44336'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });
</script>

@endsection
