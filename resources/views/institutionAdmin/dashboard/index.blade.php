@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="">
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('stateAdmin.dashboard') }}">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- KPI Overview Cards with equal height -->
    <div class="row mb-4 g-3 d-flex align-items-stretch">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 text-center bg-success text-white kpi-card" data-tooltip="This is the latest KPI number">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-white">Total KPI</h5>
                    <p class="card-text display-4 mt-auto">{{ $totalKPIs }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card h-100 text-center bg-primary text-white kpi-card" data-tooltip="Overall Performance so far">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-white">Overall Performance</h5>
                    <p class="card-text display-4 mt-auto">{{ $overallPerformance }}%</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card h-100 text-center bg-warning text-white kpi-card" data-tooltip="Active User">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-white">Active Users</h5>
                    {{-- <p class="card-text display-4 mt-auto">{{ $activeUsers }}</p> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card h-100 text-center bg-danger text-white kpi-card" data-tooltip="Other information">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-white">Any</h5>
                    {{-- <p class="card-text display-4 mt-auto">{{ $anyData }}</p> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Distribution Pie Chart -->
    <div class="row mb-4 gx-4">
        <div class="col-12 col-md-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header">
                    <h5 class="mb-0">KPI Distribution by Status</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px; width: 100%;">
                        <canvas id="kpiStatusPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed KPI Table -->
    <h4 class="mb-4">Detailed KPI Overview for State</h4>
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>BIL</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>PERCENTAGE ACHIEVED</th>
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
    const kpiData = {
        completed: {{ $pendingKPIs }},
        pending: {{ $achievedKPIs }},
    };

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

<style>
    /* Dashboard Container Styling */
    .container-fluid {
        padding: 20px;
        background-color: #f5f6fa;
    }

    /* Card Styling */
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: scale(1.02);
    }

    /* Card Header Styling */
    .card-header {
        background-color: #f1f3f6;
        font-weight: 600;
        font-size: 1.1em;
        color: #333;
        border-bottom: 1px solid #dcdcdc;
    }

    /* Card Title */
    .card-title {
        color: white;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #343a40;
        color: white;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f3f6;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-title {
            font-size: 1em;
        }
    }
    
    /* Gaya Tooltip */
    .kpi-card {
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
    }

    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .kpi-card[data-tooltip]:before,
    .kpi-card[data-tooltip]:after {
        display: none;
        position: absolute;
        white-space: nowrap;
        background: rgba(0, 0, 0, 0.75);
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
        z-index: 10;
        opacity: 0; 
        transition: opacity 0.3s ease; 
    }

    .kpi-card:hover[data-tooltip]:before,
    .kpi-card:hover[data-tooltip]:after {
        display: block;
        content: attr(data-tooltip);
        top: -38px;
        left: 50%;
        transform: translateX(-50%);
        opacity: 1;
    }

    /* Gaya Warna Background KPI */
    .bg-success { background-color: #28a745; }
    .bg-primary { background-color: #007bff; }
    .bg-warning { background-color: #ffc107; }
    .bg-danger { background-color: #dc3545; }

    .font-bold {
        font-weight: bold;
        color: white;
        font-size: 1.5rem;
    }
</style>
@endsection
