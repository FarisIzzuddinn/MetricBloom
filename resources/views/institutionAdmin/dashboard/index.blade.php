@extends('layoutNoName')

@section('title', 'Dashboard')

@section('content')

<style>
    /* Dashboard Container Styling */
    .container-fluid {
        padding: 15px;
    }

    /* Card Styling */
    .card {
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff; /* Full white background for all cards */
    }

    .card-header {
        background-color: #f8f9fa; /* Light grey for subtle differentiation */
        font-weight: 600;
        border-bottom: 1px solid #dee2e6;
    }

    .progress {
        height: 20px;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.1em;
        }
        .breadcrumb {
            font-size: 0.9em;
        }
    }

    @media (max-width: 576px) {
        .card-title {
            font-size: 1em;
        }
        .breadcrumb {
            font-size: 0.85em;
        }
        .container-fluid {
            padding: 0 10px;
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
<div class="row mb-4 g-3 d-flex align-items-stretch">
    <!-- Overview of KPIs -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title text-primary">Total KPI</h5>
                <p class="card-text display-4 mt-auto">{{ $totalKPIs }}</p>
            </div>
        </div>
    </div>

    <!-- Performance Summary -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title text-primary">Overall Performance</h5>
                <p class="card-text display-4 mt-auto">{{ $overallPerformance }}%</p>
            </div>
        </div>
    </div>

    <!-- User Activity Summary -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex flex-column text-center">
                <h5 class="card-title text-primary">Active Users</h5>
                <p class="card-text display-4 mt-auto">{{ $activeUsers }}</p>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-4">Detailed KPI Overview for State</h4>
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>BIL</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>PERATUS PENCAPAIAN</th>
                            <th>REASON</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpis->unique('pernyataan_kpi') as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->pernyataan_kpi }}</td>
                            <td>{{ $kpi->sasaran }}</td>
                            <td>{{ $kpi->peratus_pencapaian }}</td>
                            <td>
                                {{-- @if($kpi->users->isNotEmpty())
                                    @php
                                        // Group users by their sector for this KPI
                                        $usersGroupedBySector = $kpi->users->groupBy(function($user) {
                                            return $user->sector ? $user->sector->name : 'Institution Admin';
                                        });
                                    @endphp
                
                                    @foreach ($usersGroupedBySector as $sectorName => $users)
                                        <strong>{{ $sectorName }}:</strong>
                                        @foreach ($users as $user)
                                            {{ $user->name }}@if(!$loop->last), @endif
                                        @endforeach
                                        <br>
                                    @endforeach
                                @else
                                    No users assigned
                                @endif --}}
                                {{ $kpi->reason }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>


    {{-- <div class="row mb-4 gx-4">
        <!-- Bar Chart for Institution-wise KPI Progress -->
        <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sector-Wise KPI Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                        <canvas id="sectorKpiBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart for KPI Achievements vs Pending -->
        <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h5 class="mb-0">KPI Distribution by Status</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                        <canvas id="kpiStatusPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Bar Chart: Sector-Wise KPI Breakdown (Dummy Data)
        var barCtx = document.getElementById('sectorKpiBarChart').getContext('2d');
        var sectorKpiBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Sector A', 'Sector B', 'Sector C', 'Sector D', 'Sector E'],
                datasets: [
                    {
                        label: 'KPIs Achieved',
                        data: [35, 45, 30, 50, 40],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    },
                    {
                        label: 'KPIs In Progress',
                        data: [15, 10, 20, 10, 15],
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    },
                    {
                        label: 'KPIs Not Started',
                        data: [5, 3, 10, 5, 5],
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Sector-Wise KPI Breakdown'
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        beginAtZero: true,
                    }
                }
            }
        });

        // Pie Chart: KPI Distribution by Status (Dummy Data)
        var pieCtx = document.getElementById('kpiStatusPieChart').getContext('2d');
        var kpiStatusPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['KPIs Achieved', 'KPIs In Progress', 'KPIs Not Started'],
                datasets: [{
                    label: 'KPI Status Distribution',
                    data: [200, 100, 50],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',  // KPIs Achieved
                        'rgba(255, 206, 86, 0.7)',   // KPIs In Progress
                        'rgba(255, 99, 132, 0.7)'    // KPIs Not Started
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'KPI Distribution by Status Across All Sectors'
                    }
                }
            }
        });
    });
</script> --}}

@endsection
