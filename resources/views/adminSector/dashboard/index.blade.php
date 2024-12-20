@extends('layout')

@section('content')

<style>
    .container-fluid {
        padding: 20px;
    }

    /* Page Header */
    .page-header {
        background-color: #007bff;
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .page-header h1 {
        font-size: 2rem;
        font-weight: bold;
    }

    .page-header h5 {
        margin-top: 10px;
        font-size: 1rem;
        font-weight: 400;
    }

    /* Summary Cards */
    .summary-card {
        background-color: #ffffff;
        border: 1px solid #e3e3e3;
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .summary-card h6 {
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: bold;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .summary-card h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0;
    }

    /* Table Styles */
    .table {
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Chart Section */
    #charts-container {
        margin-top: 30px;
    }

    .chart-card {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .chart-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        .summary-card h2 {
            font-size: 2rem;
        }
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
                <h6>Total KPI</h6>
                <h2 class="text-primary">{{ $addKpis->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6>Achieved KPI</h6>
                <h2 class="text-success">{{ $addKpis->where('peratus_pencapaian', 100)->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6>Pending KPI</h6>
                <h2 class="text-warning">{{ $addKpis->whereBetween('peratus_pencapaian', [1,99])->count() }}</h2>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="summary-card">
                <h6>Not Achieved KPI</h6>
                <h2 class="text-danger">{{ $addKpis->where('peratus_pencapaian', 0)->count() }}</h2>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div id="charts-container" class="row">
        @foreach ($chartData as $index => $chart)
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $chart['name'] }}</h5>
                    <div id="chart-container-{{ $index }}"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <form method="GET" action="{{ route('adminSector.index') }}">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = @json($chartData);

        chartData.forEach((bahagian, index) => {
            Highcharts.chart(`chart-container-${index}`, {
                chart: {
                    type: 'pie',
                    backgroundColor: '#f9f9f9',
                },
                title: {
                    text: null,
                },
                plotOptions: {
                    pie: {
                        innerSize: '50%',
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y}',
                        },
                    },
                },
                series: [
                    {
                        name: 'KPI Status',
                        colorByPoint: true,
                        data: [
                            { name: 'Achieved', y: bahagian.achieved, color: 'green' },
                            { name: 'Not Achieved', y: bahagian.notAchieved, color: 'red' },
                            { name: 'Pending', y: bahagian.pending, color: 'blue' },
                        ],
                    },
                ],
            });
        });
    });
</script>

@endsection
