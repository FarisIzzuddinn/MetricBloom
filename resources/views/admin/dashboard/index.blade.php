@can('view dashboard')
@extends('layout')
@section('title', 'Admin Dashboard')
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

    /* Tooltip styles */
    .info-icon {
        position: relative;
        cursor: pointer;
        color: white;
    }

    .info-tooltip {
        display: none;
        position: absolute;
        bottom: 120%; /* Position above the icon with more space */
        left: 50%;
        transform: translateX(-65%);
        background-color: #333;
        color: #fff;
        padding: 6px 12px; /* Increased padding for more background coverage */
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        font-weight: bold;
    }

    .info-icon:hover .info-tooltip {
        display: block;
        min-width: max-content; /* Ensures the background fits around text content */
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

    .chart-container {
        height: 100%; /* Ensures chart fills the container vertically */
        width: 100%;  /* Ensures chart fills the container horizontally */
    }

    #completionRateChart {
        height: 100% !important; /* Forces canvas to take full height */
        width: 100% !important;  /* Forces canvas to take full width */
    }

</style>

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
        <div class="card h-100 bg-primary" style="color: white;"> 
            <div class="card-header text-center">
                Total KPIs
                <span class="info-icon">
                    <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                    <span class="info-tooltip">This is the latest kpi number</span>
                </span>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">{{ $totalKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card h-100 bg-success" style="color: white;"> 
            <div class="card-header text-center">
                Achieved
                <span class="info-icon">
                    <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                    <span class="info-tooltip">This is the number of KPIs that have been achieved</span>
                </span>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">{{ $achievedKpis }}</h5>
            </div>
        </div>
    </div> 
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card h-100" style="background-color: #ffc107; color: white;"> 
            <div class="card-header text-center">
                Pending
                <span class="info-icon">
                    <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                    <span class="info-tooltip">This is the number of KPIs that have not yet been achieved.</span>
                </span>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title">{{ $pendingKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card h-100" style="background-color: #95a5a6; color: white;"> 
            <div class="card-header text-center">
                Average Achievement
                <span class="info-icon">
                    <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                    <span class="info-tooltip">This is the average KPI achievement.</span>
                </span>
            </div>
            <div class="card-body text-center">
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

    {{-- <div class="col-lg-12 mt-3">
        <div class="card" style="height: 80vh;">
            <div class="card-header">KPI Rate Complete (%)</div>
            <div class="card-body chart-container" style="height: 40vh;">
                <canvas id="completionRateChart"></canvas>
            </div>
        </div>
    </div> --}}
</div>

<div class="row mt-3">
    <div class="col-lg-12">
        @if (session('message'))
            <div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
                                <th>STATE</th>
                                <th>KPI</th>
                                <th>KPI STATEMENT</th>
                                <th>TARGET</th>
                                <th>ACHIEVEMENT</th>
                                <th>ACGIEVEMENT(%)</th>
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
    // Data for main charts
    const labels = @json($labels);
    const data = @json($data);

    // Define colors for charts
    const backgroundColors = [
        'rgba(255, 99, 132, 1.6)',
        'rgba(54, 162, 235, 1.6)',
        'rgba(255, 206, 86, 1.6)',
        'rgba(75, 192, 192, 1.6)',
        'rgba(153, 102, 255, 1.6)',
        'rgba(255, 159, 64, 1.6)'
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];

    // Performance Bar Chart
    const ctx1 = document.getElementById('performanceChart').getContext('2d');
    const chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '', // Remove the label text to avoid it showing up in the legend
                data: data,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', 
            maintainAspectRatio: false,
            scales: {
                x: { beginAtZero: true }
            },
            plugins: {
                legend: {
                    display: false // Hide the legend entirely
                }
            }
        }
    });

    const noDataPlugin = {
        id: 'noDataPlugin',
        afterDraw: (chart) => {
            const { datasets } = chart.data;
            const hasData = datasets[0].data.some(val => val !== 0); // Checks if there's any data other than 0

            if (!hasData) {
                const ctx = chart.ctx;
                const width = chart.width;
                const height = chart.height;
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = '16px Arial';
                ctx.fillStyle = '#666';
                ctx.fillText('No Data Available', width / 2, height / 2);
                ctx.restore();
            }
        }   
    };

    // KPI Status Distribution Pie Chart
    const ctx2 = document.getElementById('statusDistributionChart').getContext('2d');
    const chart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: data.length > 0 ? labels : ['No Data Available'],
            datasets: [{
                label: '',
                data: data.length > 0 ? data : [1], // Placeholder if no data
                backgroundColor: data.length > 0 ? backgroundColors : ['#f0f0f0'],
                borderColor: data.length > 0 ? borderColors : ['#ccc'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return data.length > 0
                                ? `${tooltipItem.label}: ${tooltipItem.raw}%`
                                : 'No Data Available';
                        }
                    }
                },
                title: {
                    display: false,
                    font: { size: 18 }
                }
            }
        },
        plugins: [noDataPlugin] // Include the plugin
    });

    function fetchKpiData(state) {
        fetch(`/kpi-data/${state}`)
            .then(response => response.json())
            .then(data => {
                if (data.data.length > 0) {
                    chart2.data.labels = data.labels;
                    chart2.data.datasets[0].data = data.data;
                    chart2.data.datasets[0].backgroundColor = backgroundColors;
                    chart2.data.datasets[0].borderColor = borderColors;
                } else {
                    chart2.data.labels = ['No Data Available'];
                    chart2.data.datasets[0].data = [1];
                    chart2.data.datasets[0].backgroundColor = ['#f0f0f0'];
                    chart2.data.datasets[0].borderColor = ['#ccc'];
                }
                chart2.update();
            })
            .catch(error => {
                console.error('Error fetching KPI data:', error);
            });
    }


    // const stateLabels = {!! json_encode($stateData->pluck('state')->toArray()) !!};
    // const completionRates = {!! json_encode($stateData->pluck('completionRate')->toArray()) !!};

    // // Check that stateLabels and completionRates are not empty
    // if (stateLabels.length && completionRates.length) {
    //     const ctx3 = document.getElementById('completionRateChart').getContext('2d');
    //     const completionRateChart = new Chart(ctx3, {
    //         type: 'bar',
    //         data: {
    //             labels: stateLabels, // Should contain unique state names
    //             datasets: [{
    //                 label: 'KPI Completion Rate (%)',
    //                 data: completionRates, // Should match the labels array in length
    //                 backgroundColor: 'rgba(54, 162, 235, 0.6)',
    //                 borderColor: 'rgba(54, 162, 235, 1)',
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             responsive: true,
    //             indexAxis: 'y',
    //             responsive: true,
    //             maintainAspectRatio: false,
    //             scales: {
    //                 x: {
    //                     beginAtZero: true,
    //                     max: 100,
    //                     title: {
    //                         display: true,
    //                         text: 'Completion Rate (%)'
    //                     }
    //                 }
    //             }
    //         }
    //     });
    // } else {
    //     console.error("State data or completion rates are empty.");
    // }
</script>

@endsection

@endcan
