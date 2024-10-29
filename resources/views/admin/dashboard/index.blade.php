@can('view dashboard')
@extends('layout')
@section('title', 'Dashboard')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<style>
    /* Container for charts */
    .chart-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    /* Canvas settings */
    canvas {
        width: 100% !important;
        height: 300px !important; /* Adjust height as needed */
        object-fit: contain; /* Maintain aspect ratio */
    }

    /* Table styles */
    .table {
        border-collapse: collapse; /* Collapse borders for consistency */
        width: 100%; /* Full width for better layout */
        box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fa; /* Light grey for header */
        color: #495057; /* Dark grey for text */
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 16px;
        border-bottom: 2px solid #dee2e6; /* Thicker border for header */
    }

    .table tbody tr {
        border-bottom: 1px solid #dee2e6; /* Light grey border */
    }

    .table tbody tr:hover {
        background-color: #f1f3f5; /* Hover effect */
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border: 1px solid #dee2e6; /* Added border for table cells */
    }

    .table tbody td:first-child {
        font-weight: bold;
        background-color: #f8f9fa; /* Highlight for first column */
    }

    /* Card styles */
    .card {
        transition: transform 0.3s, box-shadow 0.3s; /* Smooth transition for hover effects */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Add shadow */
        
    }

    .card:hover {
        transform: translateY(-5px); /* Slight lift effect */
        background-color: rgba(255, 255, 255, 0.8); /* Lighten background on hover */
    }

    .card-header {
        font-weight: bold; /* Bold header */
        text-transform: uppercase; /* Uppercase header */
        text-align: center; /* Centered text */
    }

    .card-title {
        font-size: 1.5rem; /* Larger title font size */
        margin: 0; /* Remove default margin */
        text-align: center; /* Centered text */
    }

    /* Button styles */
    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .btn-success {
        background-color: #38c172; /* Custom green */
        border-color: #38c172;
    }

    .btn-success:hover {
        background-color: #32a852; /* Darker green on hover */
    }

    .btn-danger {
        background-color: #e3342f; /* Custom red */
        border-color: #e3342f;
    }

    .btn-danger:hover {
        background-color: #c62828; /* Darker red on hover */
    }

    /* Modal styles */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .modal-title {
        font-weight: bold;
        color: #495057;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
    }

    .btn-close {
        background: none;
        border: none;
    }
    /* Tooltip styles */
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

</style>

@php
    $chartConfiguration = App\Models\ChartConfiguration::first();
@endphp

@if ($chartConfiguration)
    @php
        $chartTitle = $chartConfiguration->chart_title;
    @endphp
@else
    @php
        $chartTitle = 'Default Chart Title'; // Provide a fallback title or handle the absence of data appropriately
    @endphp
@endif

<div class="head-title">
    <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-primary" style=" color: white;" data-tooltip="This is the latest kpi number."> 
            <div class="card-body text-center">
                <h5 class="card-title">TOTAL KPI</h5>
                <h5 class="card-title">{{ $totalKpis }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-success" style=" color: white;" data-tooltip="This is the number of KPIs that have been achieved."> 
            <div class="card-body text-center">
                <h5 class="card-title">ACHIEVED</h5>
                <h5 class="card-title">{{ $achievedKpis }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-warning" style=" color: white;" data-tooltip="This is the number of pending KPIs to achieve."> 
            <div class="card-body text-center">
                <h5 class="card-title">PENDING</h5>
                <h5 class="card-title">{{ $pendingKpis }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-info" style="color: white;" data-tooltip="This is the average cumulative kpi"> 
            <div class="card-body text-center">
                <h5 class="card-title">AVERAGE</h5>
                <h5 class="card-title">{{ $averageAchievement }}%</h5>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-8 col-md-12 mt-3">
        <div class="card">
            <div class="card-header">KPI Performance Over Time</div>
            <div class="card-body chart-container">
               
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 mt-3">
        <div class="card">
            <div class="card-header">KPI Status Distribution</div>
            <div class="card-body chart-container">
                <canvas id="statusDistributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Recent Activities</div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">KPI "Revenue Growth" was updated by John Doe.</li>
                    <li class="list-group-item">New KPI "Customer Satisfaction" was created.</li>
                    <li class="list-group-item">Alert: "Market Share" KPI is lagging behind.</li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}

<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">KPI OVERVIEW</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table-secondary text-secondary small-text">
                                
                                <th>BIL</th>
                                <th>TERAS</th>
                                <th>SO</th>
                                <th>NEGERI</th>
                                <th>KPI</th>
                                <th>PERNYATAAN KPI</th>
                                <th>SASARAN</th>
                                <th>PENCAPAIAN</th>
                                <th>PERATUS PENCAPAIAN</th>
                                <th>STATUS</th>
                                <th>REASON</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addKpis as $index => $addkpi)
                                <tr>
                                    <td class="small-text text-secondary">{{ $index + 1 }}</td>
                                    <td class="small-text">{{ $addkpi->teras ? $addkpi->teras->id : 'Teras has been deleted' }}</td>
                                    <td class="small-text kpi-statement">{{ $addkpi->so ? $addkpi->so->id : 'SO has been deleted' }}</td> 
                                    <td class="small-text">
                                        @if ($addkpi->states->isNotEmpty())
                                            @foreach ($addkpi->states as $state)
                                                {{ $state->name }} @if (!$loop->last), @endif
                                            @endforeach
                                        @else
                                            No State Found
                                        @endif
                                    </td>
                                    <td class="small-text">{{ $addkpi->kpi }}</td>
                                    <td class="small-text kpi-statement">{{ $addkpi->pernyataan_kpi }}</td>
                                    <td class="small-text">{{ $addkpi->sasaran }}</td>
                                    <td class="small-text">{{ $addkpi->pencapaian }}%</td>
                                    <td class="small-text">{{ number_format($addkpi->peratus_pencapaian, 2) }}%</td>
                                    <td class="small-text">
                                        @if($addkpi->peratus_pencapaian >= 75)
                                            <span class="badge text-bg-success">Tinggi</span>
                                        @elseif($addkpi->peratus_pencapaian >= 50)
                                            <span class="badge text-bg-warning">Sederhana</span>
                                        @else
                                            <span class="badge text-bg-danger">Rendah</span>
                                        @endif
                                    </td>
                                    <td class="small-text">{{ $addkpi->reason }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const data = @json($data);
    const chartTitle = @json($chartTitle);

    const backgroundColors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];

    // Performance Chart
    const ctx1 = document.getElementById('performanceChart').getContext('2d');
    const chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: chartTitle || 'Default Title',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: false,
        }
    });

    // KPI Status Distribution Chart
    const ctx2 = document.getElementById('statusDistributionChart').getContext('2d');
    const chart2 = new Chart(ctx2, {
        type: 'pie', // Change to 'pie' or 'doughnut' if appropriate
        data: {
            labels: labels, // Ensure this is correct for pie chart
            datasets: [{
                label: chartTitle || 'Default Title',
                data: data.length > 0 ? data : [1], // Ensure there's data to render
                backgroundColor: data.length > 0 ? backgroundColors : ['#f0f0f0'], 
                borderColor: data.length > 0 ? borderColors : ['#ccc'], 
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                        }
                    }
                },
                title: { 
                    display: true,
                    text: chartTitle || 'Default Pie Chart Title', // Display the dynamic or default title
                    font: {
                        size: 18, // Size of the title
                    }
                }
            }
        }
    });

    if (data.length === 0 || data.every(item => item === 0)) {
        const ctx = ctx2;
        ctx.font = "16px Arial";
        ctx.textAlign = "center";
        ctx.fillStyle = "#666"; // Grey color for the text
        ctx.fillText("No Data Available", ctx.canvas.width / 2, ctx.canvas.height / 2);
    }

    function fetchKpiData(state) {
        fetch(`/kpi-data/${state}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.labels;
                const values = data.data;

                // Update Performance Chart
                chart1.data.labels = labels;
                chart1.data.datasets[0].data = values;
                chart1.update();

                // Update KPI Status Distribution Chart
                chart2.data.labels = labels;
                chart2.data.datasets[0].data = values;
                chart2.update();
            })
            .catch(error => {
                console.error('Error fetching KPI data:', error);
            });
    }

    document.getElementById('stateSelector').addEventListener('change', function() {
        fetchKpiData(this.value);
    });


</script>
@endsection

@endcan

