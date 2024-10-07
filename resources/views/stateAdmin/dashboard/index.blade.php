@extends('layoutNoName')

@section('title', 'Dashboard')

@section('content')

<style>
    /* Formal styling for the dashboard */
    .container-fluid {
        padding: 15px;
    }

    .card {
        border-radius: 5px; /* Subtle rounded corners for a professional look */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.2s;
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 1px solid #dee2e6;
    }

    .card-title {
        font-size: 1.2rem;
        color: #004085; /* Dark blue color for card titles */
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 2rem;
        font-weight: bold;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #dee2e6;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;  /* Subtle highlight for better readability */
    }

    /* Status background colors */
    .status-kuning {
        background-color: #ffc107; /* Bootstrap warning color */
        color: black;
    }

    .status-hijau {
        background-color: #28a745; /* Bootstrap success color */
        color: white;
    }

    .status-merah {
        background-color: #dc3545; /* Bootstrap danger color */
        color: white;
    }

    /* Breadcrumb styling */
    .breadcrumb {
        background: transparent;
        padding: 0;
        font-size: 1rem;
    }

    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    /* KPI Statement Styling */
    .kpi-statement {
        white-space: pre-wrap; /* Allows line wrapping */
        word-wrap: break-word; /* Allows long words to wrap */
        max-width: 300px; /* Set appropriate maximum width */
    }

    /* Chart Styling */
    #dummyBarChart, #dummyPieChart {
        width: 100% !important;
        height: 300px !important; /* Maintain fixed height for consistent design */
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.1em;
        }

        .card-text.display-4 {
            font-size: 2em;
        }

        .head-title h1 {
            font-size: 1.5em;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1em;
        }

        .card-text.display-4 {
            font-size: 1.8em;
        }

        .head-title h1 {
            font-size: 1.3em;
        }

        .container-fluid {
            padding: 0 15px;
        }

        .breadcrumb {
            font-size: 0.85em;
        }
    }

</style>

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

<<<<<<< HEAD
    <!-- KPI Overview Cards with equal height -->
    <div class="row mb-4 d-flex align-items-stretch"> <!-- Added d-flex and align-items-stretch -->
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card h-100"> <!-- h-100 ensures card takes full height -->
                <div class="card-body d-flex flex-column"> <!-- Flexbox for card content -->
=======
    <!-- KPI Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
>>>>>>> 77b3b4a8cdc8f1d0812e9f5f21db3590b4e25a53
                    <h5 class="card-title">Total KPIs</h5>
                    <p class="card-text display-4 mt-auto">{{ $totalKpis }}</p> <!-- mt-auto pushes content down -->
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Achieved KPI</h5>
                    <p class="card-text display-4 mt-auto">{{ $achievedKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Pending KPI</h5>
                    <p class="card-text display-4 mt-auto">{{ $pendingKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Average Achievement</h5>
                    <p class="card-text display-4 mt-auto">{{ $averageAchievement }}%</p>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======

    <!-- KPI List with Details -->
    <h4 class="mb-4">Detailed KPI Overview for State</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>BIL</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>INSTITUTION ASSIGN</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpis->unique('pernyataan_kpi') as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->pernyataan_kpi }}</td>
                            <td>{{ $kpi->sasaran }}</td>
                            <td>
                                @if ($kpi->institutions->isNotEmpty())
                                    {{ $kpi->institutions->unique('name')->pluck('name')->implode(', ') }} <!-- Use unique to avoid duplicates -->
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
>>>>>>> 77b3b4a8cdc8f1d0812e9f5f21db3590b4e25a53
</div>

    <!-- Charts Section -->
    <div class="row mb-4 gx-4">
        <!-- Bar Chart for Institution-wise KPI Progress -->
        <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>KPI Achievement Rates Across Institutions</span>
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
            <div class="card w-100">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <span class="text-sm mb-2 mb-md-0">KPI Achievement by Institution</span>
                    <div>
                        <select id="kpiFilter" class="form-select form-select-sm" style="min-width: 150px;">
                            <option value="financialPerformance">Financial Performance</option>
                            <option value="operationalEfficiency">Operational Efficiency</option>
                            <option value="customerSatisfaction">Customer Satisfaction</option>
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
    
    


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
window.addEventListener('load', function() {
    console.log('Window is loaded, initializing charts.');

        // Data passed from the backend
    var institutionNames = @json($institutionNames);
    var kpiAchievements = @json($kpiAchievements);

    // Bar Chart for Institution-wise KPI Progress
    var ctxDummyBar = document.getElementById('dummyBarChart').getContext('2d');
    console.log('Initializing Dummy Bar Chart');
    var dummyBarChart = new Chart(ctxDummyBar, {
        type: 'bar',
        data: {
            labels: institutionNames,
            datasets: [{
                label: 'KPI Achievement (%)',
                data: kpiAchievements,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                borderRadius: 5, // Rounded corners for bars
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
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    enabled: true,
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
                    grid: {
                        color: 'rgba(200, 200, 200, 0.2)' // Light grid lines
                    },
                    title: {
                        display: true,
                        text: 'Achievement (%)',
                        font: {
                            size: 14
                        }
                    }
                },
                x: {
                    grid: {
                        display: false // No grid lines on the x-axis for a cleaner look
                    },
                    title: {
                        display: true,
                        text: 'Institutions',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    var institutionNames = @json($institutionNames);
    var financialPerformance = @json($financialPerformance);
    var operationalEfficiency = @json($operationalEfficiency);
    var customerSatisfaction = @json($customerSatisfaction);

    // Initial data setup
    var kpiData = {
        financialPerformance: financialPerformance,
        operationalEfficiency: operationalEfficiency,
        customerSatisfaction: customerSatisfaction
    };

    // Get the dropdown and canvas context
    var kpiFilterDropdown = document.getElementById('kpiFilter');
    var ctx = document.getElementById('dummyPieChart').getContext('2d');

    // Function to update the chart with the selected KPI
    function updateChart(selectedKPI) {
        dummyPieChart.data.datasets[0].data = kpiData[selectedKPI];
        dummyPieChart.update();
    }

    // Initialize the bar chart
    var dummyPieChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: institutionNames,
            datasets: [{
                label: 'KPI Achievement (%)',
                data: kpiData[kpiFilterDropdown.value],
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                borderRadius: 5, // Rounded corners for bars
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
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    enabled: true,
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
                    grid: {
                        color: 'rgba(200, 200, 200, 0.2)' // Light grid lines
                    },
                    title: {
                        display: true,
                        text: 'Achievement (%)',
                        font: {
                            size: 14
                        }
                    }
                },
                x: {
                    grid: {
                        display: false // No grid lines on the x-axis for a cleaner look
                    },
                    title: {
                        display: true,
                        text: 'Institutions',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });

    // Add event listener to dropdown to update chart when KPI selection changes
    kpiFilterDropdown.addEventListener('change', function() {
        var selectedKPI = this.value;
        updateChart(selectedKPI);
    });
});
</script>
@endsection
