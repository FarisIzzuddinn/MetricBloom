@extends('layout')
@section('content')

<style>
    .chart-container {
        position: relative;
        width: 100%;
        height: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 20px;
        background-color: #f8f9fa; /* Light background for subtle contrast */
    }

    .chart-container h5 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333; /* Darker text for better readability */
    }

    canvas {
        width: 100% !important;
        height: 300px !important;
    }
</style>

<div class="container-fluid">
    {{-- statistic card  --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-1">
                <div class="card-body">
                    <h5>Total KPI</h5>
                    <h2>{{ $totalKpi }}</h2> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-1">
                <div class="card-body">
                    <h5>Total States</h5>
                    <h2>{{ $totalState }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-1">
                <div class="card-body">
                    <h5>Total Institutions</h5>
                    <h2>{{ $totalInstitution }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-1">
                <div class="card-body">
                    <h5>Total User</h5>
                    <h2>{{ $totalUser }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card kpi-card mb-1" data-status='achieved'>
                <div class="card-body">
                    <h5>Achieved KPI</h5>
                    <h2>{{ $achievedKpi }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card kpi-card mb-1" data-status='pending'>
                <div class="card-body">
                    <h5>Pending KPI</h5>
                    <h2>{{ $pendingKpi }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card  kpi-card mb-1" data-status='not Achieved'>
                <div class="card-body">
                    <h5>Not Achieved KPI</h5>
                    <h2>{{ $notAchievedKpi }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">KPI Details</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>KPI Name</th>
                        <th>Target</th>
                        <th>Achievement</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kpis as $kpi)
                        <tr>
                            <td>{{ $kpi->pernyataan_kpi ?? 'N/A' }}</td>
                            <td>{{ $kpi->sasaran ?? 'N/A' }}</td>
                            <td>{{ $kpi->pencapaian ?? 'N/A' }}</td>
                            <td>{{ $kpi->status ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    

    {{-- bahagian  --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="chart-container shadow-sm rounded p-3 bg-light">
                <h5 class="text-center text-dark mb-3">KPI Bahagian Performance</h5>
                <canvas id="bahagianPerformanceChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container shadow-sm rounded p-3 bg-light">
                <h5 class="text-center text-dark mb-3">Bahagian KPI Status Distribution</h5>
                <canvas id="bahagianStatusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- state  --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="chart-container shadow-sm rounded p-3 bg-light">
                <h5 class="text-center text-dark mb-3">State KPI Performance</h5>
                <canvas id="statePerformanceChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container shadow-sm rounded p-3 bg-light">
                <h5 class="text-center text-dark mb-3">Monthly KPI Trends</h5>
                <canvas id="stateTrendsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- institution  --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="chart-container shadow-sm rounded p-3 bg-light">
                <h5 class="text-center text-dark mb-3">Institution KPI Performance</h5>
                <canvas id="institutionPerformanceChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container shadow-sm rounded p-3 bg-light">
                <h5 class="text-center text-dark mb-3">Institution KPI Status Distribution</h5>
                <canvas id="institutionStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables or other jQuery-dependent scripts -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bahagian Performance Chart
    const processedLabels = {!! json_encode($bahagianWithNames->pluck('name')) !!}.map(label =>
        label.replace(/Bahagian\s?/i, '') // Remove "Bahagian" (case-insensitive)
    );

    const data = {!! json_encode($bahagianWithNames->pluck('avg_performance')) !!};

    new Chart(document.getElementById('bahagianPerformanceChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: processedLabels,
            datasets: [{
                label: 'Average Performance (%)',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 1)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Bahagian Status Chart
    const bahagianStatusCtx = document.getElementById('bahagianStatusChart').getContext('2d');
    new Chart(bahagianStatusCtx, {
        type: 'pie',
        data: {
            labels: ['Achieved', 'Pending', 'Not Achieved'],
            datasets: [{
                data: [
                    {!! $bahagianStatus->where('status', 'achieved')->sum('count') !!},
                    {!! $bahagianStatus->where('status', 'pending')->sum('count') !!},
                    {!! $bahagianStatus->where('status', 'not achieved')->sum('count') !!}
                ],
                backgroundColor: ['#4caf50', '#ff9800', '#f44336']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // State Performance Chart
    const statePerformanceCtx = document.getElementById('statePerformanceChart').getContext('2d');
    new Chart(statePerformanceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($statePerformance->pluck('name')) !!},
            datasets: [{
                label: 'Average Performance (%)',
                data: {!! json_encode($statePerformance->pluck('kpis.0.avg_performance')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // State Trends Chart
    const stateTrendsCtx = document.getElementById('stateTrendsChart').getContext('2d');
    new Chart(stateTrendsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($stateTrends->pluck('month')) !!},
            datasets: [{
                label: 'Monthly Performance (%)',
                data: {!! json_encode($stateTrends->pluck('avg_performance')) !!},
                borderColor: '#42a5f5',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

     // Institution Performance Chart
     const institutionPerformanceCtx = document.getElementById('institutionPerformanceChart').getContext('2d');
    new Chart(institutionPerformanceCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($institutionPerformance->pluck('name')) !!},
            datasets: [{
                label: 'Average Performance (%)',
                data: {!! json_encode($institutionPerformance->pluck('kpis.0.avg_performance')) !!},
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Institution Status Chart
    const institutionStatusCtx = document.getElementById('institutionStatusChart').getContext('2d');
    new Chart(institutionStatusCtx, {
        type: 'pie',
        data: {
            labels: ['Achieved', 'Pending', 'Not Achieved'],
            datasets: [{
                data: [
                    {!! $institutionStatus->where('status', 'achieved')->sum('count') !!},
                    {!! $institutionStatus->where('status', 'pending')->sum('count') !!},
                    {!! $institutionStatus->where('status', 'not achieved')->sum('count') !!}
                ],
                backgroundColor: ['#4caf50', '#ff9800', '#f44336']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const kpiCards = document.querySelectorAll('.kpi-card'); // Select all cards with class 'kpi-card'

        if (!kpiCards.length) {
            console.error('No KPI cards found in the DOM.');
            return;
        }

        kpiCards.forEach(card => {
            card.addEventListener('click', function () {
                const status = this.getAttribute('data-status'); // Get the 'data-status' attribute
                console.log(`Card clicked with status: ${status}`);

                // Perform an action when a card is clicked (e.g., reload the page with a status query parameter)
                window.location.href = `?status=${status}`;
            });
        });
    });


</script>


@endsection











{{-- @extends('layout')
@section('content')
@section('title', 'Dashboard')

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

    .page-header h1 {
        font-size: 2rem;
        margin-bottom: 0;
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 0;
    }

    .breadcrumb-item a {
        color: #cce5ff;
        text-decoration: none;
    }

    .breadcrumb-item-active a {
        color: #fff;
        font-weight: bold;
    }

    /* KPI Card Styling */
    .kpi-card {
        transition: transform 0.3s, box-shadow 0.3s;
        background-color: #ffffff;
        border: none;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .kpi-card h6 {
        font-size: 1rem;
        font-weight: bold;
        color: #6c757d;
    }

    .kpi-card h4 {
        font-size: 2.2rem;
        color: #007bff;
    }

    .kpi-card .icon {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 10px;
    }

    /* Chart Panel */
    .chart-panel {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 1rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-danger:hover {
        background-color: #a71d2a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Dashboard Bahagian Dasar Kepenjaraan</h1>
    </div>

    <!-- KPI Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="kpi-card text-center">
                <div class="icon"><i class="bi bi-bar-chart"></i></div>
                <h6>Total KPIs</h6>
                <h4>{{ $totalKPI }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kpi-card text-center">
                <div class="icon"><i class="bi bi-check-circle"></i></div>
                <h6>Achieved KPIs</h6>
                <h4>120</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="kpi-card text-center">
                <div class="icon"><i class="bi bi-graph-up"></i></div>
                <h6>Achievement Rate</h6>
                <h4>80%</h4>
            </div>
        </div>
    </div>

    <!-- KPI Rumusan Chart -->
    <!-- Card Container -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Chart Section -->
                <div class="col-8">
                    <div id="kpiRumusanChart" style="width: 100%; height: 400px;"></div>
                </div>
                <!-- Summary Section -->
                <div class="col-4 d-flex align-items-center">
                    <div class="row w-100">
                        <!-- Card for Achieved -->
                        <div class="col-12 mb-3">
                            <div class="card text-center">
                                <div class="card-body" style="background-color: #28a745; color: #fff;">
                                    <h5>TERCAPAI</h5>
                                    <h2>{{ $totalAchieved }}</h2>
                                </div>
                            </div>
                        </div>
                        <!-- Card for Not Achieved -->
                        <div class="col-12">
                            <div class="card text-center">
                                <div class="card-body" style="background-color: #dc3545; color: #fff;">
                                    <h5>BELUM CAPAI</h5>
                                    <h2>{{ $totalNotAchieved }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
 

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-4">
            <label for="chartTypeFilter" class="form-label">Select Chart Type:</label>
            <select id="chartTypeFilter" class="form-select">
                <option value="column">Column</option>
                <option value="bar">Bar</option>
                <option value="line">Line</option>
                <option value="pie">Pie</option>
            </select>
        </div>
        <div class="col-md-8 mt-4 text-end">
            <button id="exportPDF" class="btn btn-danger me-2">Export as PDF</button>
            <button id="exportImage" class="btn btn-primary">Export as Image</button>
        </div>
    </div>

    <!-- Chart Container -->
    <div class="chart-panel mt-4">
        <div id="kpiTotalBahagian" style="height: 600px; width: 100%;"></div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('kpiRumusanChart', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                },
                backgroundColor: '#f5f5f5'
            },
            title: {
                text: 'Rumusan KPI Sukuan'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}, {point.percentage:.1f}%'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'KPI',
                data: [
                    {
                        name: 'Capai Sasaran',
                        y: {{ $achievedPercentage }},
                        color: '#28a745' // Green
                    },
                    {
                        name: 'Bawah Sasaran',
                        y: {{ $notAchievedPercentage }},
                        color: '#dc3545' // Red
                    }
                ]
            }]
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const kpiData = @json($kpiBahagianData);

        if (!kpiData || kpiData.length === 0) {
            console.error('No data available to display.');
            return;
        }

        const categories = kpiData.map(item => item.name);
        const totalKpiData = kpiData.map(item => parseInt(item.total_kpi) || 0);

        let currentChart;

        function initializeChart(type = 'column') {
            if (currentChart) currentChart.destroy();

            currentChart = Highcharts.chart('kpiTotalBahagian', {
                chart: {
                    type: type,
                    backgroundColor: null, // Removes background color
                    borderColor: '#000', // Adds black border
                    borderWidth: 2, // Sets border width
                    spacing: [10, 10, 15, 10], // Adds spacing inside the border
                },
                title: { 
                    text: 'Total KPI by Bahagian',
                    style: {
                        fontSize: '30px', // Set the desired font size
                        fontWeight: 'bold', // Optional: Make the title bold
                        color: '#333333' // Optional: Set title text color
                    }
                 },
                xAxis: { categories: categories, title: { text: 'Bahagian' } },
                yAxis: type !== 'pie' ? [
                    {
                        title: { text: 'Total ' },
                        allowDecimals: false,
                    },
                ] : null,
                series: type === 'pie' ? [
                    {
                        name: 'Total KPI',
                        data: categories.map((name, index) => ({
                            name: name,
                            y: totalKpiData[index],
                        })),
                        colorByPoint: true,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y}', // Display name and value
                            style: {
                                color: '#000', // Set text color for pie chart labels
                                fontWeight: 'bold', // Make text bold
                                fontSize: '14px' // Optional: Adjust font size
                            }
                        },
                    },
                ] : [
                    {
                        name: 'Total KPI',
                        data: totalKpiData,
                        color: '#007bff',
                        dataLabels: {
                            enabled: true, // Enable labels for column/bar/line
                            format: '{y}', // Show only the value
                            style: {
                                color: 'black', // Change the text color to red
                                fontWeight: 'bold', // Optional: Make text bold
                                fontSize: '16px' // Optional: Adjust font size
                            }
                        },
                    },
                ],
                tooltip: {
                    shared: type !== 'pie',
                    pointFormat: type === 'pie'
                        ? '{point.name}: <b>{point.y}</b>'
                        : '{series.name}: <b>{point.y}</b>',
                },
                credits: { enabled: false },
                exporting: { enabled: true },
            });
        }

        initializeChart();

        document.getElementById('chartTypeFilter').addEventListener('change', function (e) {
            initializeChart(e.target.value);
        });

        document.getElementById('exportPDF').addEventListener('click', function () {
            currentChart?.exportChartLocal({ type: 'application/pdf' });
        });

        document.getElementById('exportImage').addEventListener('click', function () {
            currentChart?.exportChartLocal({ type: 'image/png' });
        });
    });

    
</script>
@endsection --}}
