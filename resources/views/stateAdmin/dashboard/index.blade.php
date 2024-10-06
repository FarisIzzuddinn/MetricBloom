@extends('layoutNoName')

@section('content')

<style>
    /* Custom styles */
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .progress {
        height: 20px;
        border-radius: 10px;
    }

    .progress-bar {
        font-weight: bold;
    }

    .kpi-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kpi-header-icon {
        width: 24px;
        height: 24px;
        margin-bottom:10px;
    }

    .card-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tooltip-custom {
        cursor: pointer;
    }
    
</style>

<div class="container">
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

 
    <!-- KPI Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total KPIs</h5>
                    <p class="card-text display-4">{{ $totalKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Achieved KPIs (>= 75%)</h5>
                    <p class="card-text display-4">{{ $achievedKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending KPIs (< 75%)</h5>
                    <p class="card-text display-4">{{ $pendingKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Average Achievement</h5>
                    <p class="card-text display-4">{{ $averageAchievement }}%</p>
                </div>
            </div>
        </div>
    </div>

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
                        @foreach($kpis as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->pernyataan_kpi }}</td>
                            <td>{{ $kpi->sasaran }}</td>
                            <td>
                                @if ($kpi->institutions->isNotEmpty())
                                    @foreach ($kpi->institutions as $institution)
                                        {{ $institution->name }}<br> <!-- Display each institution name -->
                                    @endforeach
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
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
@endsection
