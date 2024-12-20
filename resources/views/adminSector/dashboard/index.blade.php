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
                Sector: {{ auth()->user()->userEntity->sector->name ?? 'No Sector assigned' }}
            </h5>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6 class="text-uppercase text-muted">Total KPI</h6>
                <h2 class="text-primary">{{ $addKpis->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6 class="text-uppercase text-muted">Achieved KPI</h6>
                <h2 class="text-success">{{ $addKpis->where('peratus_pencapaian', '==', 100)->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6 class="text-uppercase text-muted">Pending KPI</h6>
                <h2 class="text-warning">{{ $addKpis->whereBetween('peratus_pencapaian', [1,99])->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6 class="text-uppercase text-muted">Not Achieved KPI</h6>
                <h2 class="text-danger">{{ $addKpis->where('peratus_pencapaian', '=', 0)->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div id="chart-container" style="height: 400px;"></div>
        </div>
    </div>

    <!-- Sector Filter -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <form method="GET" action="{{ route('admin.index') }}">
                <label for="bahagian_id" class="form-label">Select Bahagian:</label>
                <select name="bahagian_id" id="bahagian_id" class="form-control" onchange="this.form.submit()">
                    @foreach($bahagians as $bahagian)
                        <option value="{{ $bahagian->id }}" {{ $bahagian->id == $selectedBahagianId ? 'selected' : '' }}>
                            {{ $bahagian->nama_bahagian }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
   
    <!-- KPI Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    KPIs Assigned to Your Sector
                </div>
                <div class="card-body">
                    @if($addKpis->isEmpty())
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
                                @foreach($addKpis as $kpi)
                                @foreach($kpi->kpiBahagian as $bahagian)
                                    <tr>
                                        <td>{{ $kpi->pernyataan_kpi }}</td>
                                        <td>{{ $kpi->sasaran }}</td>
                                        <td>{{ $bahagian->peratus_pencapaian }}</td>
                                        <td>
                                            <span class="badge {{ $bahagian->peratus_pencapaian >= $kpi->sasaran ? 'bg-success' : 'bg-danger' }}">
                                                {{ $bahagian->peratus_pencapaian >= $kpi->sasaran ? 'Achieved' : 'Not Achieved' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
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
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData);
        const totalAchieved = {{ $totalAchieved }};
        const totalNotAchieved = {{ $totalNotAchieved }};

        Highcharts.chart('chart-container', {
            chart: {
                type: 'pie',
                height: null, // Adjust automatically to the container
                backgroundColor: '#f9f9f9',
            },
            title: {
                text: 'Sektor Keselamatan dan Koreksional',
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold',
                },
            },
            subtitle: {
                text: `<div style="display: flex; justify-content: center; align-items: center;">
                    <div style="background-color: green; color: white; border-radius: 5px; padding: 10px; margin-right: 5px;">
                        <b>${totalAchieved}</b> Achieved
                    </div>
                    <div style="background-color: red; color: white; border-radius: 5px; padding: 10px;">
                        <b>${totalNotAchieved}</b> Not Achieved
                    </div>
                </div>`,
                useHTML: true,
                align: 'center',
            },
            plotOptions: {
                pie: {
                    innerSize: '60%', // Donut effect
                    startAngle: -90,
                    endAngle: 90, // Semi-donut
                    center: ['50%', '75%'],
                    dataLabels: {
                        enabled: true,
                        distance: -30,
                        style: {
                            color: '#000',
                            fontSize: '12px',
                            fontWeight: 'bold',
                            textOutline: 'none',
                        },
                        formatter: function () {
                            // Display the Bahagian name and KPI breakdown inside the slice
                            return `<div style="text-align: center;">
                                <b>${this.point.name}</b><br>
                                <span style="color:green;">${this.point.achieved}</span> /
                                <span style="color:red;">${this.point.notAchieved}</span>
                            </div>`;
                        },
                        useHTML: true,
                    },
                },
            },
            series: [
                {
                    name: 'KPI Breakdown',
                    data: chartData.map(item => ({
                        name: item.name,
                        y: item.achieved + item.notAchieved,
                        achieved: item.achieved,
                        notAchieved: item.notAchieved,
                        color: item.color,
                    })),
                },
            ],
            responsive: {
                rules: [
                    {
                        condition: {
                            maxWidth: 768, // Mobile responsiveness
                        },
                        chartOptions: {
                            title: {
                                style: {
                                    fontSize: '16px',
                                },
                            },
                            subtitle: {
                                style: {
                                    fontSize: '14px',
                                },
                            },
                        },
                    },
                ],
            },
        });
    });
</script>



@endsection
