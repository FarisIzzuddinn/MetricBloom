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

     {{-- statistic card  --}}
     <div class="row">
        <div class="col-md-3">
            <div class="card mb-1 bg-primary rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard-check mb-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                        </svg> Total KPI
                    </h5>
                    <h2 class="display-4">{{ $totalKpis }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#kpiDetailsModal">View Details</a> --}}
                </div>
            </div>
        </div>
        
    
        <div class="col-md-3">
            <div class="card mb-1 bg-success rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                        </svg>Achieved
                    </h5>
                    <h2 class="display-4">{{ $achievedKpis }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#achievedKpiModal">View Details</a> --}}
                </div>
            </div>
        </div>
        
    
        <div class="col-md-3">
            <div class="card mb-1 bg-warning rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hourglass-split mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                        </svg>Pending
                    </h5>
                    <h2 class="display-4">{{ $pendingKpis }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
                </div>
            </div>
        </div>
    
        <div class="col-md-3">
            <div class="card mb-1 bg-danger rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
                <div class="card-body text-white">
                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle mb-1 me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg> Not Achieved
                    </h5>
                    <h2 class="display-4">{{ $notAchievedKpis }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
                </div>
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

    <div class="mt-4" id="content-container"></div>

    <div class="row">
        <div class="col-md-6 mb-3">
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
                                                <span class="badge {{ 
                                                    $bahagian->peratus_pencapaian == 100 ? 'bg-success' : 
                                                    ($bahagian->peratus_pencapaian > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $bahagian->peratus_pencapaian == 100 ? 'Achieved' : 
                                                        ($bahagian->peratus_pencapaian > 0 ? 'Pending' : 'Not Achieved') }}
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

    console.log("Chart Data:", chartData); // Debug: Inspect the chart data
   
    chartData.forEach((bahagian, index) => {
        console.log(bahagian.kpiBahagians); 
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
                    point: {
                        events: {
                            click: function () {
                                const clickedKpiStatus = this.name;
                                const clickedKpiData = this.y;

                                console.log("Clicked KPI Status:", clickedKpiStatus);
                                console.log("Clicked KPI Data:", clickedKpiData);
                                console.log("bahagian.kpis:", bahagian.kpis);

                                if (Array.isArray(bahagian.kpis) && bahagian.kpis.length > 0) {
                                    // Filter KPIs based on the clicked status
                                    const filteredKpis = bahagian.kpis.filter(kpi => {
                                        return kpi.status.trim().toLowerCase() === clickedKpiStatus.trim().toLowerCase();
                                    });

                                    console.log("Filtered KPIs:", filteredKpis);

                                    if (filteredKpis.length > 0) {
                                        // Generate table HTML for the filtered KPIs
                                        const rowsHtml = filteredKpis
                                            .map(kpi => {
                                                const targetFormatted = isNaN(kpi.sasaran) ? '-' : parseFloat(kpi.sasaran).toFixed(2);
                                                const achievementFormatted = isNaN(kpi.pencapaian) ? '-' : parseFloat(kpi.pencapaian).toFixed(2);

                                                return `
                                                    <tr>
                                                        <td>${kpi.pernyataan_kpi}</td>
                                                        <td class="text-center">${targetFormatted}</td>
                                                        <td class="text-center">${achievementFormatted}</td>
                                                        <td class="text-center">
                                                            <span class="badge ${kpi.status === 'achieved' ? 'bg-success' : kpi.status === 'pending' ? 'bg-warning text-dark' : 'bg-danger'}">${kpi.status}</span>
                                                        </td>
                                                    </tr>`;
                                            })
                                            .join('');

                                        const tableHtml = `
                                            <div class="card shadow-sm rounded">
                                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0">KPI Details for: ${bahagian.name}</h5>
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
                                                            ${rowsHtml}
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        `;

                                        // Insert the table into the content container
                                        const contentContainer = document.getElementById('content-container');
                                        contentContainer.innerHTML = tableHtml;

                                        // Add hide button functionality
                                        document.getElementById('hideTableButton').addEventListener('click', function () {
                                            contentContainer.innerHTML = '';2
                                        });
                                    } else {
                                        // No data message
                                        document.getElementById('content-container').innerHTML = `
                                            <div class="alert alert-warning" role="alert">
                                                No KPIs match the selected status.
                                            </div>
                                        `;
                                    }
                                } else {
                                    console.log("No KPIs data found for this Bahagian.");
                                }
                            },
                        },
                    },
                },
            },
            series: [{
                name: 'KPIs',
                data: [
                    { name: 'Achieved', y: bahagian.achieved, color: '#28a745' }, // Green
                    { name: 'Pending', y: bahagian.pending, color: '#ffc107' },   // Yellow
                    { name: 'Not Achieved', y: bahagian.notAchieved, color: '#dc3545' }, // Red
                ],
            }],
        });
    });
});


</script>
@endsection
