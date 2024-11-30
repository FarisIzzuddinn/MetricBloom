@extends('layout')

@section('content')

<style>
    #chart-container {
        width: 100%; /* Takes the full width of its parent */
        height: 500px; /* Adjust height as needed */
        margin: 0 auto; /* Center horizontally */
    }

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

    #container {
        margin-top: 40px;
    }
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Dashboard</h1>
            <h5>
                State: {{ $state ? $state->name : 'No State assigned' }}
            </h5>
        </div>
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
                <h2 class="text-success">{{ $kpis->where('peratus_pencapaian', '==', 100)->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6 class="text-uppercase text-muted">Pending KPI</h6>
                <h2 class="text-warning">{{ $kpis->whereBetween('peratus_pencapaian', [1,99])->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6 class="text-uppercase text-muted">Not Achieved KPI</h6>
                <h2 class="text-danger">{{ $kpis->where('peratus_pencapaian', '=', 0)->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    KPIs Assigned to Your Bahagian
                </div>
                <div class="card-body">
                    @if($kpis->isEmpty())
                        <p class="text-muted">No KPIs are assigned to the selected sector.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>KPI Name</th>
                                    <th>Target</th>
                                    <th>Achievement (%)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kpis as $kpi)
                                    <tr>
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
        </div>
    </div> 

    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Institutions in {{ $state->name }}</h5>
                </div>
                <div class="card-body">
                    @if ($institutions->isEmpty())
                        <p>No institutions found for this state.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($institutions as $institution)
                                <li class="list-group-item">{{ $institution->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>   
</div>
@endsection

{{-- @extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
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
    <div class="row g-4 mb-4 justify-content-center">
        @foreach([
            ['title' => "TOTAL KPI", 'value' => $totalKpis, 'bgColor' => 'bg-primary', 'tooltip' => "This is the latest KPI number."],
            ['title' => "ACHIEVED", 'value' => $achievedKpis, 'bgColor' => 'bg-success', 'tooltip' => "This is the number of KPIs that have been achieved."],
            ['title' => "PENDING", 'value' => $pendingKpis, 'bgColor' => 'bg-warning', 'tooltip' => "This is the number of pending KPIs to achieve."],
            ['title' => "AVERAGE", 'value' => round(array_sum($kpiAchievements) / count($kpiAchievements), 2) . '%', 'bgColor' => 'bg-info', 'tooltip' => "This is the average KPI achievement."],
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
    <!-- Charts Section -->
    <div class="row mb-4 gx-4">
        <!-- Bar Chart for Institution-wise KPI Progress -->
        <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
        <div class="card w-100" style="background-color: white;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Institusi KPI Progress</span>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                        <canvas id="dummyBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Pie Chart for KPI Achievements vs Pending -->
        <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
        <div class="card w-100" style="background-color: white;">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <span class="text-sm mb-2 mb-md-0">KPI Achievement Overview</span>
                    <div>
                        <select id="kpiFilter" class="form-select form-select-sm" style="min-width: 150px;">
                            @foreach ($kpiCategories as $category)
                                <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                        <canvas id="dummyPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- KPI List with Details -->
    <h4 class="mb-4">Detailed KPI Overview for State</h4>
    <div class="card mb-3"  style="background-color: white;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>NO</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>REASON</th>
                            <th>INSTITUTION ASSIGN</th>
                            <th>PROGRESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpis->unique('pernyataan_kpi') as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->pernyataan_kpi }}</td>
                            <td>{{ $kpi->sasaran }}</td>
                            <td>{{ $kpi->reason }}</td>
                            <td>
                                @if ($kpi->institutions->isNotEmpty())
                                    {{ $kpi->institutions->unique('name')->pluck('name')->implode(', ') }}
                                @else
                                    No Institution Assigned
                                @endif
                            </td>
                            <td>
                                <div class="progress tooltip-custom" data-toggle="tooltip" title="{{ $kpi->peratus_pencapaian }}% achieved">
                                    <div class="progress-bar 
                                        @if($kpi->status == 'completed') bg-success
                                        @elseif($kpi->status == 'in_progress') bg-warning
                                        @elseif($kpi->status == 'overdue') bg-danger
                                        @endif" 
                                        role="progressbar" 
                                        style="width: {{ $kpi->peratus_pencapaian }}%;" 
                                        aria-valuenow="{{ $kpi->peratus_pencapaian }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                        {{ $kpi->peratus_pencapaian }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('load', function() {
        //data from controller
        var institutionNames = @json($institutionNames);
        var kpiAchievements = @json($kpiAchievements);
        var kpiData = @json($kpiData); 

        //bar chart
        var ctxDummyBar = document.getElementById('dummyBarChart').getContext('2d');
        var dummyBarChart = new Chart(ctxDummyBar, {
            type: 'bar',
            data: {
                labels: institutionNames,
                datasets: [{
                    label: 'KPI Achievement (%)',
                    data: kpiAchievements,
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 5,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: '#f8f9fa',
                        titleColor: '#333',
                        bodyColor: '#333',
                        borderColor: '#ccc',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, 
                    }
                }
            }
        });

        var ctxPie = document.getElementById('dummyPieChart').getContext('2d');
        var defaultCategory = Object.keys(kpiData)[0]; // Pick the first available category

        var dummyPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: "", // Assuming the same institution names are used for each category
                datasets: [{
                    label: 'KPI Achievement (%)',
                    data: kpiData[defaultCategory] || [], 
                    backgroundColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                display: false,
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Update the Pie chart when the filter is changed
        document.getElementById('kpiFilter').addEventListener('change', function() {
            var selectedCategory = this.value;
            dummyPieChart.data.datasets[0].data = kpiData[selectedCategory] || [];
            dummyPieChart.update();
        });
    });
</script>
@endsection


    
 --}}

 
