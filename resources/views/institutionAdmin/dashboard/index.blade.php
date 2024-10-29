@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
        <div class="head-title">
            <div class="left">
                <h1 class="font-bold">Dashboard</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('stateAdmin.dashboard') }}" class="font-bold">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    
        <!-- KPI Cards with Tooltip -->
        <div class="row g-4 mb-4 justify-content-center ">
            @foreach([
                ['title' => "TOTAL KPI", 'value' => $totalKPIs, 'bgColor' => 'bg-primary', 'tooltip' => "This is the latest KPI number."],
                ['title' => "ACHIEVED", 'value' => $achievedKPIs, 'bgColor' => 'bg-success', 'tooltip' => "This is the number of KPIs that have been achieved."],
                ['title' => "PENDING", 'value' => $pendingKPIs, 'bgColor' => 'bg-warning', 'tooltip' => "This is the number of pending KPIs to achieve."],
                ['title' => "AVERAGE", 'value' => $averageAchievement . '%', 'bgColor' => 'bg-info', 'tooltip' => "This is the average KPI achievement."],
            ] as $kpi)
            <div class="col-lg-3 col-md-6">
                <div class="card text-center shadow-sm h-100 kpi-card {{ $kpi['bgColor'] }}" 
                    data-tooltip="{{ $kpi['tooltip'] }}">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex flex-column align-items-center mb-3">
                            <h6 class="mb-0 font-bold">{{ $kpi['title'] }}</h6>
                            <h4 class="mb-0 mt-2 font-bold">{{ $kpi['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- KPI Distribution Pie Chart -->
    <div class="row mb-4 gx-4 ">
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
        completed: {{ $achievedKPIs }},
        pending: {{ $pendingKPIs }},
    };

    const ctx = document.getElementById('kpiStatusPieChart').getContext('2d');
    const kpiStatusPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                data: [kpiData.completed, kpiData.pending],
                backgroundColor: ['#198754', '#ffc107'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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

    .font-bold {
        font-weight: bold;
        color: white;
        font-size: 1.5rem;
    }
</style>
@endsection
