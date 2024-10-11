@extends('layout')

@section('title', 'Dashboard')

@section('content')


<style>
/* Gaya Umum */
.container-fluid {
    padding: 15px;
}

/* Kad (Card) */
.card {
    border-radius: 5px; /* Sudut bulat yang halus untuk penampilan profesional */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s; /* Transisi untuk hover */
    background-color: #003300;
}

.card:hover {
    transform: translateY(-5px); /* Kesan sedikit mengangkat */
}

.card-header {
    background-color: #f8f9fa;
    font-weight: bold; /* Bold header */
    text-transform: uppercase; /* Header huruf besar */
    text-align: center; /* Teks tengah */
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    font-size: 1.5rem; /* Saiz tajuk lebih besar */
    font-weight: bold;
    color: white; 
    margin: 0; /* Hapus margin default */
    text-align: center; /* Teks tengah */
    
}

.card-text {
    font-size: 2rem;
    font-weight: bold;
    text-align: center; /* Teks tengah */
    color: white; 

}

/* Gaya Jadual */
.table {
    border-collapse: collapse; /* Gabungkan sempadan untuk konsistensi */
    width: 100%; /* Lebar penuh untuk tata letak yang lebih baik */
    box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    overflow: hidden;
}

.table thead th {
    background-color: #f8f9fa; /* Kelabu terang untuk header */
    color: #495057; /* Kelabu gelap untuk teks */
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 12px 16px;
    border-bottom: 2px solid #dee2e6; /* Sempadan lebih tebal untuk header */
}

.table tbody tr:hover {
    background-color: #f1f3f5; /* Kesan hover */
}

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border: 1px solid #dee2e6; /* Tambah sempadan untuk sel jadual */
}

.table tbody td:first-child {
    font-weight: bold;
    background-color: #f8f9fa; /* Sorotan untuk kolum pertama */
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

        .card-text {
            font-size: 1.8em;
        }

        .head-title h1 {
            font-size: 1.5em;
        }

        .breadcrumb {
            font-size: 0.9em;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1em;
        }

        .card-text {
            font-size: 1.6em;
        }

        .head-title h1 {
            font-size: 1.3em;
        }

        .container-fluid {
            padding: 0 10px;
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

    <!-- KPI Overview Cards with equal height -->
    <div class="row mb-4 g-3 d-flex align-items-stretch"> <!-- Added g-3 for better spacing between columns -->
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column" >

                    <h5 class="card-title">Total KPIs</h5>

                    <h5 class="card-title">Total KPI Assign</h5>

                    <p class="card-text display-4 mt-auto">{{ $totalKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Achieved KPI</h5>
                    <p class="card-text display-4 mt-auto">{{ $achievedKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Pending KPI</h5>
                    <p class="card-text display-4 mt-auto">{{ $pendingKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Average Achievement</h5>
                    <p class="card-text display-4 mt-auto">{{ $averageAchievement }}%</p>
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
                            <th>BIL</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>REASON</th>
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
                        color: 'rgba(200, 200, 200, 0.2)'
                    },
                    title: {

    window.addEventListener('load', function() {
        // Data passed from the backend
        var institutionNames = @json($institutionNames); // Institution names
        var kpiAchievements = @json($kpiAchievements);  // Average KPI achievements

        // Bar Chart for Institution-wise KPI Progress
        var ctxDummyBar = document.getElementById('dummyBarChart').getContext('2d');
        var dummyBarChart = new Chart(ctxDummyBar, {
            type: 'bar',
            data: {
                labels: institutionNames,
                datasets: [{
                    label: 'Average KPI Achievement (%)',
                    data: kpiAchievements,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
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
                x: {
                    grid: {
                        display: false

                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,  // Ensure the Y-axis goes from 0% to 100%
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)'
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
                            display: false
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


    // KPI Data for Pie Chart
    var financialPerformance = @json($financialPerformance);
    var operationalEfficiency = @json($operationalEfficiency);
    var customerSatisfaction = @json($customerSatisfaction);

        // KPI Data for Pie Chart
        var financialPerformance = @json($financialPerformance);
        var operationalEfficiency = @json($operationalEfficiency);
        var customerSatisfaction = @json($customerSatisfaction);


        // Initial data setup for KPI Categories
        var kpiData = {
            financialPerformance: financialPerformance,
            operationalEfficiency: operationalEfficiency,
            customerSatisfaction: customerSatisfaction
        };


    var kpiFilterDropdown = document.getElementById('kpiFilter');
    var ctx = document.getElementById('dummyPieChart').getContext('2d');

    function updateChart(selectedKPI) {
        dummyPieChart.data.datasets[0].data = kpiData[selectedKPI];
        dummyPieChart.update();
    }

    // Initialize the pie chart
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
                        color: 'rgba(200, 200, 200, 0.2)'
                    },
                    title: {

        // Get filter dropdown and chart context
        var kpiFilterDropdown = document.getElementById('kpiFilter');
        var ctx = document.getElementById('dummyPieChart').getContext('2d');

        // Initialize the Bar Chart for filtered KPI data
        var dummyPieChart = new Chart(ctx, {
            type: 'bar',  // If you want a pie chart, change this to 'pie'
            data: {
                labels: institutionNames,
                datasets: [{
                    label: 'KPI Achievement (%)',
                    data: kpiData[kpiFilterDropdown.value],
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
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

                x: {
                    grid: {
                        display: false

                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 200, 200, 0.2)'
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
                            display: false
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


    // Event listener to update the pie chart
    kpiFilterDropdown.addEventListener('change', function() {
        updateChart(this.value);

        // Event listener to update the chart when the filter changes
        kpiFilterDropdown.addEventListener('change', function() {
            var selectedKPI = this.value;
            dummyPieChart.data.datasets[0].data = kpiData[selectedKPI];
            dummyPieChart.update();
        });

    });
</script>

@endsection


    

