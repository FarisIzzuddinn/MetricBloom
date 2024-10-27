@extends('layout')
@section('content')
@section('title', 'Dashboard')


<style>
.info-icon {
    position: relative;
    cursor: pointer;
    color: white;
}

.kpi-card {
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

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

.table-hover-effect tbody tr {
    transition: transform 0.3s, box-shadow 0.3s;
}

.table-hover-effect tbody tr:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    background-color: rgba(245, 245, 245, 0.8);
}

.bg-success {
    background-color: #28a745;
}

.bg-primary {
    background-color: #007bff;
}

.bg-warning {
    background-color: #ffc107;
}

.bg-danger {
    background-color: #dc3545;
}

.font-bold {
    font-weight: bold;
    color: white;
    font-size: 1.5rem;
}
</style>

<div class="">
    <div class="head-title">
        <div class="left">
            <h1 class="font-bold">Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="/Dashboard/SuperAdmin" class="font-bold">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row g-4 mb-4 justify-content-center">
        @foreach([
            ['title' => "TOTAL KPI", 'value' => $totalKpi, 'bgColor' => 'bg-primary', 'tooltip' => "This is the latest kpi number."],
            ['title' => "ACHIEVED", 'value' => $kpisAchieved, 'bgColor' => 'bg-success', 'tooltip' => "This is the number of KPIs that have been achieved."],
            ['title' => "PENDING", 'value' => $kpisOnTrack, 'bgColor' => 'bg-warning', 'tooltip' => "This is the number of pending KPIs to achieve."],
            ['title' => "UNDERPERFORMING KPI", 'value' => $kpisUnderperforming, 'bgColor' => 'bg-danger', 'tooltip' => "This is the number of underperforming KPIs."],
        ] as $kpi)
        <div class="col-lg-3 col-md-6">
            <div class="card text-center shadow-sm h-100 kpi-card {{ $kpi['bgColor'] }}" 
                data-tooltip="{{ $kpi['tooltip'] }}">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex flex-column align-items-center mb-3">
                        <h6 class="mb-0 font-bold">{{ $kpi['title'] }}</h6>
                        <h4 class="mb-0 mt-2 font-bold">{{ $kpi['value'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-bar-chart-fill me-2"></i>Total KPI for the State
                </div>
                <div class="card-body">
                    <canvas id="stateKpiChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-person-plus-fill me-2"></i>Recently Registered Users
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0 table-hover-effect">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Registered On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUser as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="card shadow-sm d-flex" style="height: 500px;">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pie-chart-fill me-2"></i>Total institution for each state
                </div>
                <div class="card-body">
                    <canvas id="institutionsPieChart" style="height: 400px;"></canvas> <!-- Adjust height as needed -->
                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="card shadow-sm h-100 d-flex">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-bar-chart-fill me-2"></i>Top Performing Institutions
                </div>
                <div class="card-body">
                    <canvas id="topInstitutionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    var ctxStateKpi = document.getElementById('stateKpiChart').getContext('2d');
    var stateKpiChart = new Chart(ctxStateKpi, {
        type: 'bar',
        data: {
            labels: @json($kpisPerState->pluck('name')),
            datasets: [{
                label: 'Total KPI per State',
                data: @json($kpisPerState->pluck('kpis_count')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, 
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                datalabels: {
                    color: '#000', 
                    anchor: 'center', 
                    align: 'center', 
                    formatter: function(value) {
                        return value; 
                    },
                    font: {
                        size: 20,
                        weight: 'bold' 
                    }
                }
            }
        },
        plugins: [ChartDataLabels] 
    });

    // Institutions KPI Pie Chart
    const allStateNames = @json($institutionPerState->pluck('name'));
    const allInstitutionCounts = @json($institutionPerState->pluck('institutions_count'));

    // Filter out states with a count of 0
    const filteredData = allStateNames.map((name, index) => {
        return { name: name, count: allInstitutionCounts[index] };
    }).filter(item => item.count > 0);

    // Separate filtered data into labels and data arrays
    const labels = filteredData.map(item => item.name);
    const data = filteredData.map(item => item.count);

    var ctxInstitutionPie = document.getElementById('institutionsPieChart').getContext('2d');
    var institutionsPieChart = new Chart(ctxInstitutionPie, {
        type: 'bar',
        data: {
            labels: labels, // Set the labels for the y-axis (state names)
            datasets: [{
                label: 'Institution Count', // Set a label for the dataset
                data: data, // Filtered institution counts
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false, // Allows the chart to fit the container
            plugins: {
                datalabels: {
                    color: '#000',
                    anchor: 'center',
                    align: 'center',
                    formatter: function(value, context) {
                        return value;
                    },
                    font: {
                        size: 20,
                        weight: 'bold'
                    }
                }
            }
        },
        plugins: [ChartDataLabels] // Enable the DataLabels plugin for this chart
    });
    
    // Top Performing Institutions Chart
    var ctxTopInstitutions = document.getElementById('topInstitutionsChart').getContext('2d');
    var topInstitutionsChart = new Chart(ctxTopInstitutions, {
        type: 'bar',
        data: {
            labels: @json($topInstitutions->pluck('institution_name')),
            datasets: [{
                label: 'Total KPI by Institution',
                data: @json($topInstitutions->pluck('total_kpis')),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
