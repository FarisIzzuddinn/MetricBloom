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
                Bahagian: {{ auth()->user()->userEntity->bahagian->nama_bahagian ?? 'No Bahagian assigned' }}
            </h5>
        </div>
    </div>

{{-- statistic card  --}}
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card mb-1 bg-primary rounded-3 shadow-sm hover-shadow" data-aos="fade-up">
            <div class="card-body text-white">
                <h5><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clipboard-check mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                    </svg> Total KPI
                </h5>
                <h2 class="display-4">{{ $addKpis->count() }}</h2>
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
                <h2 class="display-4">{{ $addKpis->where('peratus_pencapaian', '==', 100)->count() }}</h2>
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
                <h2 class="display-4">{{ $addKpis->whereBetween('peratus_pencapaian', [50, 99])->count() }}</h2>
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
                    <h2 class="display-4">{{ $addKpis->whereBetween('peratus_pencapaian', [0,49])->count() }}</h2>
                    {{-- <a href="#" class="btn btn-light btn-sm mt-3">View Details</a> --}}
                </div>
            </div>
        </div>
    </div>
    

    <div class="row mt-4">
        @foreach($chartData as $index => $data)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header">{{ $data['name'] }}</div>
                    <div class="card-body">
                        <!-- Chart container with unique ID -->
                        <div id="chart-container-{{ $index }}" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div id="content-container" class="mt-4"></div>
    
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartData = @json($chartData); // assuming you have $chartData passed from your backend

    // Dynamically create the charts
    chartData.forEach((data, index) => {
        // Initialize the Highcharts chart for each data entry
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

                                if (Array.isArray(data.kpis) && data.kpis.length > 0) {
                                    // Filter KPIs based on the clicked status
                                    const filteredKpis = data.kpis.filter(kpi => {
                                        return kpi.status.trim().toLowerCase() === clickedKpiStatus.trim().toLowerCase();
                                    });

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
                                                    <h5 class="mb-0">KPI Details for: ${data.name}</h5>
                                                    <button id="hideTableButton-${index}" class="btn btn-sm btn-light">Hide Table</button>
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
                                        document.getElementById(`hideTableButton-${index}`).addEventListener('click', function () {
                                            contentContainer.innerHTML = ''; // Clear the content
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
                                    console.log("No KPIs data found for this data entry.");
                                }
                            },
                        },
                    },
                },
            },
            series: [{
                name: 'KPIs',
                data: [
                    { name: 'Achieved', y: data.achieved, color: '#28a745' },
                    { name: 'Pending', y: data.pending, color: '#ffc107' },
                    { name: 'Not Achieved', y: data.notAchieved, color: '#dc3545' },
                ],
            }],
        });
    });
});



</script>



@endsection
