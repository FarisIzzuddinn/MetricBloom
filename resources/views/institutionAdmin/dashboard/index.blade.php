@extends('layout')
@section('content')
<style>


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
</style>

<div class="container-fluid">
    @if ($institution)
        <div class="page-header">
            <h1>{{ $institution->name }} Dashboard</h1>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Total KPI</h6>
                    <h2 class="text-primary">{{ $totalKpis }}</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Achieved KPI</h6>
                    <h2 class="text-success">{{ $achievedCount  }}</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Pending KPI</h6>
                    <h2 class="text-warning">{{ $pendingCount }}</h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="summary-card">
                    <h6 class="text-uppercase text-muted">Not Achieved KPI</h6>
                    <h2 class="text-danger">{{ $notAchievedCount }}</h2>
                </div>
            </div>
        </div>
        

        <div id="institution-kpi-chart" style="width: 100%; height: 500px;"></div>
        <div class="mt-3" id="detailsSection"></div>

        <!-- KPI Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">KPIs Assigned to {{ $institution->name }}</h5>
            </div>
            <div class="card-body">
                @if ($kpis->isEmpty())
                    <p>No KPIs assigned to this institution.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>KPI Name</th>
                                <th>Target</th>
                                <th>Achievement (%)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kpis as $index => $kpi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kpi->kpi->pernyataan_kpi }}</td>
                                    <td>{{ $kpi->kpi->sasaran }}</td>
                                    <td>{{ $kpi->peratus_pencapaian }}</td>
                                    <td>
                                        <span class="badge 
                                        {{ $kpi->status === 'achieved' ? 'bg-success' : ($kpi->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($kpi->status) }}
                                    </span>
                                    
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            <p>No institution assigned to this user. Please contact the administrator.</p>
        </div>
    @endif


</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const institution = @json($chartData); // Pass the full chartData object

        if (!institution) {
            console.error('No institution data available.');
            return;
        }

        const achieved = institution.achieved || 0;
        const pending = institution.pending || 0;
        const notAchieved = institution.notAchieved || 0;
        const kpiDetails = institution.kpiInstitutions || [];

        // Initialize the Highcharts pie chart
        Highcharts.chart('institution-kpi-chart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Institution-wise KPI Achievements'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f} %',
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold'
                        },
                        distance: 20
                    },
                    point: {
                        events: {
                            click: function () {
                                displayKpiDetailsWithAnimation(kpiDetails);
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'KPI Achievements',
                colorByPoint: true,
                data: [{
                    name: 'Achieved',
                    y: achieved,
                    color: '#4caf50' // Green color for achieved
                }, {
                    name: 'Pending',
                    y: pending,
                    color: '#ffcc02' // Yellow color for pending
                }, {
                    name: 'Not Achieved',
                    y: notAchieved,
                    color: '#f44336' // Red color for not achieved
                }]
            }],
            credits: { enabled: false }
        });

        // Function to display KPI details with animation
        function displayKpiDetailsWithAnimation(details) {
            let detailsSection = document.getElementById('detailsSection');
            if (!detailsSection) {
                detailsSection = document.createElement('div');
                detailsSection.id = 'detailsSection';
                document.body.appendChild(detailsSection);
            }

            if (!details || details.length === 0) {
                detailsSection.innerHTML = `<div class="alert alert-warning">No KPI details available for this institution.</div>`;
                return;
            }

            const kpiRows = details.map(kpi => `
                <tr>
                    <td>${kpi.name}</td>
                    <td class="text-center">${parseFloat(kpi.target).toFixed(2)}</td>
                    <td class="text-center">${parseFloat(kpi.achievement).toFixed(2)}%</td>
                    <td class="text-center">
                        <span class="badge ${
                            kpi.status === 'achieved'
                                ? 'bg-success'
                                : kpi.status === 'pending'
                                ? 'bg-warning text-dark'
                                : 'bg-danger'
                        }">${kpi.status}</span>
                    </td>
                </tr>
            `).join('');

            const tableHtml = `
                <div class="card shadow-sm rounded mt-4 animated-fade-in">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">KPI Details</h5>
                        <button id="hideTableButton" class="btn btn-sm btn-light">Hide Table</button>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-hover table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>KPI Name</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Achievement</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${kpiRows}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            detailsSection.innerHTML = tableHtml;

            // Attach the event listener to hide the table
            document.getElementById('hideTableButton').addEventListener('click', hideKpiDetails);
        }

        // Function to hide the KPI details table
        function hideKpiDetails() {
            const detailsSection = document.getElementById('detailsSection');
            if (detailsSection) {
                detailsSection.innerHTML = ''; // Clear the section
            }
        }
    });
</script>
@endsection

