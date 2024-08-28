@extends('layout')
@section('title', 'Dashboard')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<style>
    .chart-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    canvas {
        width: 100% !important;
        height: 300px !important; /* Adjust height as needed */
        object-fit: contain; /* Maintain aspect ratio */
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

<div class="row">
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-primary text-white">
            <div class="card-header">Total KPIs</div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-success text-white">
            <div class="card-header">Achieved</div>
            <div class="card-body">
                <h5 class="card-title">{{ $achievedKpis }}</h5>
            </div>
        </div>
    </div> 
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-warning text-white">
            <div class="card-header">Pending</div>
            <div class="card-body">
                <h5 class="card-title">{{ $pendingKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-info text-white">
            <div class="card-header">Average Achievement</div>
            <div class="card-body">
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
                                <th >BIL</th>
                                <th >TERAS</th>
                                <th >SO</th>
                                <th >NEGERI</th>
                                <th >PEMILIK</th>
                                <th >KPI</th>
                                <th >PERNYATAAN KPI</th>
                                <th >SASARAN</th>
                                <th >PENCAPAIAN</th>
                                <th >PERATUS PENCAPAIAN</th>
                                <th >STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addKpis as $index => $addkpi)

                                <tr>
                                    <td class="small-text text-secondary">{{ $index + 1 }}</td>
                                    <td class="small-text">{{ $addkpi->teras ? $addkpi->teras->id : 'No Teras Found' }}</td>
                                    <td class="small-text kpi-statement">{{ $addkpi->so->id}}</td> 
                                    <td class="small-text">{{ $addkpi->negeri }}</td>
                                    <td class="small-text">{{ $addkpi->user->name }}</td>
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
                                </tr>
                            
                                    <tr>
                                        <td class="small-text text-secondary">{{ $index + 1 }}</td>
                                        {{-- <td class="small-text">{{ $addkpi->teras->id }}</td> --}}
                                        <td class="small-text kpi-statement">{{ $addkpi->so->id}}</td>
                                        <td class="small-text">{{ $addkpi->negeri }}</td>
                                        <td class="small-text">{{ $addkpi->user->name }}</td>
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
        type: 'doughnut', // Change to 'pie' or 'doughnut' if appropriate
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
</script>
@endsection



