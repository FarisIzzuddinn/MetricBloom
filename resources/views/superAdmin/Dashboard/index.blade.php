@extends('layout')

@section('content')

<style>

.info-icon {
    position: relative;
    cursor: pointer;
    color: #007bff;
}

.info-tooltip {
    display: none;
    position: absolute;
    bottom: 120%; /* Position above the icon with more space */
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 6px 12px; /* Increased padding for more background coverage */
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    text-align: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

.info-icon:hover .info-tooltip {
    display: block;
    min-width: max-content; /* Ensures the background fits around text content */
}

</style>

<div class="container-fluid">
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="/Dashboard/SuperAdmin">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- KPI Overview Section -->
    <div class="row g-4 mb-4">
        @foreach([
            ['title' => "Total KPI", 'value' => $totalKpi, 'tooltip' => 'This shows the total number of KPIs assigned.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-briefcase" viewBox="0 0 16 16"><path d="M6.5 0a.5.5 0 0 0-.5.5V2h4V.5a.5.5 0 0 0-.5-.5h-3zM4 1a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V1z"/><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2H0V4zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7H0z"/></svg>', 'bgColor' => 'bg-success'],
            ['title' => "Achieved KPI", 'value' => $kpisAchieved, 'tooltip' => 'Number of KPIs that have been fully achieved.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm3.354-8.854-4 4a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7 9.293l3.646-3.647a.5.5 0 0 1 .708.708z"/></svg>', 'bgColor' => 'bg-primary'],
            ['title' => "On-track KPI", 'value' => $kpisOnTrack, 'tooltip' => 'KPIs that are progressing as scheduled.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M0 0h1v15.5a.5.5 0 0 0 .5.5H16v1H1.5A1.5 1.5 0 0 1 0 15.5V0z"/><path fill-rule="evenodd" d="M10.293 10.707 7.5 7.914l-4 4L1 9.414l.707-.707 1.793 1.793 4-4 3.793 3.793 2.147-2.146H10.5v-1h4v4h-1v-2.793l-3.707 3.707z"/></svg>', 'bgColor' => 'bg-warning'],
            ['title' => "Underperform KPI", 'value' => $kpisUnderperforming, 'tooltip' => 'KPIs that are not meeting expected progress.', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16"><path d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 3.864c.11.062.18.177.18.302v7.736a.39.39 0 0 1-.39.39H1.39a.39.39 0 0 1-.39-.39V6.182c0-.125.07-.24.18-.302L7.938 2.016zM8 4.522 1.16 8.285v6.443h13.678V8.285L8 4.522zM7 9v2h2V9H7zm0 3v2h2v-2H7z"/></svg>', 'bgColor' => 'bg-danger'],
        ] as $kpi)
        <div class="col-lg-3 col-md-6">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-lg {{ $kpi['bgColor'] }} text-white rounded-circle p-3 me-3">
                            {!! $kpi['icon'] !!}
                        </div>
                        <div>
                            <h6 class="mb-0 d-flex align-items-center">
                                {{ $kpi['title'] }}
                                <!-- Info icon with unique tooltip -->
                                <div class="info-icon ms-2 position-relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                    <div class="info-tooltip position-absolute">
                                        {{ $kpi['tooltip'] }}
                                    </div>
                                </div>
                            </h6>
                            <h4 class="mb-0 mt-2">{{ $kpi['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    

    <!-- Chart Section -->
    <div class="row g-4">
        <!-- Left: State KPI Chart -->
        <div class="col-lg-8">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-bar-chart-fill me-2"></i>Total KPI for the State
                </div>
                <div class="card-body">
                    <canvas id="stateKpiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Recently Registered Users -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person-plus-fill me-2"></i>Recently Registered Users
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Registered On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUser as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Charts Section -->
    <div class="row g-4 mt-2">
        <!-- Institution KPI Distribution Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pie-chart-fill me-2"></i>Total institution for each state
                </div>
                <div class="card-body">
                    <canvas id="institutionsPieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performing Institutions Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-bar-chart-fill me-2"></i>Top Performing Institutions
                </div>
                <div class="card-body">
                    <canvas id="topInstitutionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


<script>
    // State KPI Chart
    var ctxStateKpi = document.getElementById('stateKpiChart').getContext('2d');
    var stateKpiChart = new Chart(ctxStateKpi, {
        type: 'bar',
        data: {
            labels: @json($kpisPerState->pluck('name')),
            datasets: [{
                label: 'Total KPI per State',
                data: @json($kpisPerState->pluck('kpis_count')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false, // Ensures the height is maintained
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                datalabels: {
                    color: '#000', 
                    anchor: 'center', 
                    align: 'center', 
                    formatter: function(value) {
                        return value; 
                    },
                    font: {
                        size: 20,
                        weight: 'bold' // Make label text bold
                    }
                }
            }
        },
        plugins: [ChartDataLabels] // Register the plugin
    });



    // Institutions KPI Pie Chart
    var ctxInstitutionPie = document.getElementById('institutionsPieChart').getContext('2d');
    var institutionsPieChart = new Chart(ctxInstitutionPie, {
        type: 'pie',
        data: {
            labels: @json($institutionPerState->pluck('name')), // State names from the database
            datasets: [{
                data: @json($institutionPerState->pluck('institutions_count')), // Institution counts per state from the database
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    color: '#000',  
                    anchor: 'center',  
                    align: 'center',
                    formatter: function(value, context) {
                        return value; 
                    },
                    font:{
                        size: 20,
                        weight:'bold'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]  // Enable the DataLabels plugin for this chart
    });
    
    // Top Performing Institutions Chart
    var ctxTopInstitutions = document.getElementById('topInstitutionsChart').getContext('2d');
    var topInstitutionsChart = new Chart(ctxTopInstitutions, {
        type: 'bar',
        data: {
            labels: @json($topInstitutions->pluck('name')),
            datasets: [{
                label: 'Average KPI Achievement (%)',
                data: @json($topInstitutions->pluck('avg_achievement')),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
