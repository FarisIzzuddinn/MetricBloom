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

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-1 bg-primary rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard-check mb-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                        </svg> Total KPI
                    </h5>
                    <h2 class="display-4">{{ $totalKpiState }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#kpiDetailsModal">View Details</a> --}}
                </div>
            </div>
        </div>
        
    
        <div class="col-md-3">
            <div class="card mb-1 bg-success rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                        </svg>Achieved
                    </h5>
                    <h2 class="display-4">{{ $achievedCount }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#achievedKpiModal">View Details</a> --}}
                </div>
            </div>
        </div>
        
    
        <div class="col-md-3">
            <div class="card mb-1 bg-warning rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hourglass-split mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg>Pending
                    </h5>
                    <h2 class="display-4">{{ $pendingCount }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
                </div>
            </div>
        </div>
    
        <div class="col-md-3">
            <div class="card mb-1 bg-danger rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg> Not Achieved
                    </h5>
                    <h2 class="display-4">{{ $notAchievedCount }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
                </div>
            </div>
        </div>
    </div>

    <div id="institution-kpi-chart" style="width: 100%; height: 500px;"></div>
    <div id="detailsSection" style="margin-top: 20px;"></div>
    
    <div class="row mt-4 mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    KPI Assigned to State {{ $state->name }}
                </div>
                <div class="card-body">
                    @if($kpis->isEmpty())
                        <p class="text-muted">No KPIs are assigned to the this state.</p>
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
                                        <td>{{ $kpi->kpi->pernyataan_kpi }}</td>
                                        <td>{{ $kpi->kpi->sasaran }}</td>
                                        <td>{{ $kpi->peratus_pencapaian }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ 
                                                strtolower(trim($kpi->status)) === 'achieved' ? 'success' : 
                                                (strtolower(trim($kpi->status)) === 'pending' ? 'warning text-dark' : 'danger') }}">
                                                {{ ucfirst($kpi->status ?? 'Not Defined') }}
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
    
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const institutions = @json($chartData->pluck('name'));
    const achievements = @json($chartData->pluck('achievement'));
    const kpiDetails = @json($chartData->pluck('kpis'));

    Highcharts.chart('institution-kpi-chart', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Institution-wise KPI Achievements'
        },
        xAxis: {
            categories: institutions,
            title: {
                text: 'Institutions'
            }
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Achievement (%)'
            }
        },
        tooltip: {
            valueSuffix: '%',
            pointFormat: '<b>{point.y:.1f}% KPI Achieved</b>'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true,
                    format: '{y}%'
                },
                point: {
                    events: {
                        click: function () {
                            const institutionIndex = this.index; // Get the index of the clicked bar
                            const institutionName = institutions[institutionIndex];
                            const details = kpiDetails[institutionIndex];

                            displayKpiDetails(institutionName, details);
                        }
                    }
                }
            }
        },
        series: [{
            name: 'Achievement',
            data: achievements,
            colorByPoint: true
        }],
        credits: { enabled: false }
    });

    // Function to display KPI details
    function displayKpiDetails(institutionName, details) {
        let detailsSection = document.getElementById('detailsSection');
        if (!detailsSection) {
            detailsSection = document.createElement('div');
            detailsSection.id = 'detailsSection';
            document.body.appendChild(detailsSection);
        }

        if (!details || details.length === 0) {
            detailsSection.innerHTML = `<div class="alert alert-warning">No KPI details available for ${institutionName}.</div>`;
            return;
        }

        const kpiRows = details
            .map(kpi => `
                <tr>
                    <td>${kpi.name}</td>
                    <td class="text-center">${parseFloat(kpi.target).toFixed(2)}</td>
                    <td class="text-center">${parseFloat(kpi.achievement).toFixed(2)}%</td>
                    <td class="text-center">
                        <span class="badge ${
                            kpi.status === 'achieved'
                                ? 'bg-success'
                                : kpi.status === 'pending'
                                ? 'bg-warning text-dark'
                                : 'bg-danger'
                        }">${kpi.status}</span>
                    </td>
                </tr>
            `)
            .join('');

        const tableHtml = `
            <div class="card shadow-sm rounded mt-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">KPI Details for ${institutionName}</h5>
                    <button id="hideTableButton" class="btn btn-sm btn-light">Hide Table</button>
                </div>
                <div class="card-body p-4">
                    <table class="table table-hover table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>KPI Name</th>
                                <th class="text-center">Target</th>
                                <th class="text-center">Achievement</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${kpiRows}
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        detailsSection.innerHTML = tableHtml;

        // Add event listener to hide the table
        document.getElementById('hideTableButton').addEventListener('click', function () {
            detailsSection.innerHTML = '';
        });
    }
});

</script>
    
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

 
