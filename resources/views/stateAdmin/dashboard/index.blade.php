@extends('layout')

@section('title', 'Dashboard')

@section('content')

<style>
/* Gaya Umum */
.container-fluid {
    padding: 15px;
}

.chart-container {
    position: relative;
    width: 100%;
    height: 300px; /* Set a fixed height */
}

/* Kad (Card) */
.card {
    border-radius: 5px; /* Sudut bulat yang halus untuk penampilan profesional */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s; /* Transisi untuk hover */
    background-color: #003300;
}

.card:hover {
    transform: translateY(-5px); /* Kesan sedikit mengangkat */
}

.card-header {
    background-color: #f8f9fa;
    font-weight: bold; /* Bold header */
    text-transform: uppercase; /* Header huruf besar */
    text-align: center; /* Teks tengah */
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    font-size: 1.5rem; /* Saiz tajuk lebih besar */
    font-weight: bold;
    color: white; 
    margin: 0; /* Hapus margin default */
    text-align: center; /* Teks tengah */
    position: relative; /* Posisi relatif untuk tooltip */
}

.card-text {
    font-size: 2rem;
    font-weight: bold;
    text-align: center; /* Teks tengah */
    color: white; 
}

/* Gaya Jadual */
.table {
    border-collapse: collapse; /* Gabungkan sempadan untuk konsistensi */
    width: 100%; /* Lebar penuh untuk tata letak yang lebih baik */
    box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    overflow: hidden;
}

.table thead th {
    background-color: #f8f9fa; /* Kelabu terang untuk header */
    color: #495057; /* Kelabu gelap untuk teks */
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 12px 16px;
    border-bottom: 2px solid #dee2e6; /* Sempadan lebih tebal untuk header */
}

.table tbody tr:hover {
    background-color: #f1f3f5; /* Kesan hover */
}

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border: 1px solid #dee2e6; /* Tambah sempadan untuk sel jadual */
}

.table tbody td:first-child {
    font-weight: bold;
    background-color: #f8f9fa; /* Sorotan untuk kolum pertama */
}

/* Status background colors */
.status-kuning {
    background-color: #ffc107; /* Bootstrap warning color */
    color: black;
}

.status-hijau {
    background-color: #28a745; /* Bootstrap success color */
    color: white;
}

.status-merah {
    background-color: #dc3545; /* Bootstrap danger color */
    color: white;
}

/* Breadcrumb styling */
.breadcrumb {
    background: transparent;
    padding: 0;
    font-size: 1rem;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

/* KPI Statement Styling */
.kpi-statement {
    white-space: pre-wrap; /* Allows line wrapping */
    word-wrap: break-word; /* Allows long words to wrap */
    max-width: 300px; /* Set appropriate maximum width */
}

/* Tooltip Styling */
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
    transform: translateX(-50%);
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

/* Media Queries for Responsive Design */
@media (max-width: 768px) {
    .card-title {
        font-size: 1.1em;
    }

    .card-text {
        font-size: 1.8em;
    }

    .head-title h1 {
        font-size: 1.5em;
    }

    .breadcrumb {
        font-size: 0.9em;
    }
}

@media (max-width: 576px) {
    .card-title {
        font-size: 1em;
    }

    .card-text {
        font-size: 1.6em;
    }

    .head-title h1 {
        font-size: 1.3em;
    }

    .container-fluid {
        padding: 0 10px;
    }

    .breadcrumb {
        font-size: 0.85em;
    }
}

    .bg-yellow {
    background-color: #ffc107 !important; /* Kuning */
    color: black; /* Teks hitam untuk kontras */
}

.bg-green {
    background-color: green !important; /* Hijau */
    color: white; /* Teks putih untuk kontras */
}

.bg-grey {
    background-color: #95a5a6 !important; /* Merah */
    color: white; /* Teks putih untuk kontras */
}

.bg-biru {
    background-color:  #007bff !important; /* Biru */
    color: white; /* Teks putih untuk kontras */
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
    <div class="row mb-4 g-3 d-flex align-items-stretch"> <!-- Added g-3 for better spacing between columns -->
        <div class="col-sm-6 col-md-3">
            <div class="card h-100 bg-green"> 
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">TOTAL KPIS
                        <span class="info-icon">
                            <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                            <span class="info-tooltip">This is the latest kpi number.</span>
                        </span>
                    </h5>
                    <p class="card-text display-4 mt-auto">{{ $totalKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card h-100 bg-biru"> 
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">ACHIEVED KPI
                        <span class="info-icon">
                            <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                            <span class="info-tooltip">This is the number of KPIs that have been achieved</span>
                        </span>
                    </h5>
                    <p class="card-text display-4 mt-auto">{{ $achievedKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card h-100 bg-yellow"> <!-- Warna merah -->
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">PENDING KPI
                        <span class="info-icon">
                            <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                            <span class="info-tooltip">This is the number of KPIs that have not yet been achieved.</span>
                        </span>
                    </h5>
                    <p class="card-text display-4 mt-auto">{{ $pendingKpis }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card h-100 bg-grey"> <!-- Warna biru -->
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">AVERAGE
                        <span class="info-icon">
                            <i class="bx bx-info-circle"></i> <!-- Ikon info -->
                            <span class="info-tooltip">This is the average KPI achievement.</span>
                        </span>
                    </h5>
                    <p class="card-text display-4 mt-auto">{{ $averageAchievement }}%</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- KPI List with Details -->
    <h4 class="mb-4">Detailed KPI Overview for State</h4>
    <div class="card mb-3"  style="background-color: white;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>BIL</th>
                            <th>KPI DESCRIPTION</th>
                            <th>TARGET</th>
                            <th>REASON</th>
                            <th>INSTITUTION ASSIGN</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kpis->unique('pernyataan_kpi') as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->pernyataan_kpi }}</td>
                            <td>{{ $kpi->sasaran }}</td>
                            <td>{{ $kpi->reason }}</td>
                            <td>
                                @if ($kpi->institutions->isNotEmpty())
                                    {{ $kpi->institutions->unique('name')->pluck('name')->implode(', ') }}
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

    <!-- Charts Section -->
<div class="row mb-4 gx-4">
    <!-- Bar Chart for Institution-wise KPI Progress -->
    <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
    <div class="card w-100" style="background-color: white;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Institusi KPI Progress</span>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                    <canvas id="dummyBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart for KPI Achievements vs Pending -->
    <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
    <div class="card w-100" style="background-color: white;">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <span class="text-sm mb-2 mb-md-0">KPI Achievement Overview</span>
                <div>
                    <select id="kpiFilter" class="form-select form-select-sm" style="min-width: 150px;">
                        @foreach ($kpiCategories as $category)
                            <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                    <canvas id="dummyPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.addEventListener('load', function() {
        //data from controller
        var institutionNames = @json($institutionNames);
        var kpiAchievements = @json($kpiAchievements);
        var kpiData = @json($kpiData); 

        //bar chart
        var ctxDummyBar = document.getElementById('dummyBarChart').getContext('2d');
        var dummyBarChart = new Chart(ctxDummyBar, {
            type: 'bar',
            data: {
                labels: institutionNames,
                datasets: [{
                    label: 'KPI Achievement (%)',
                    data: kpiAchievements,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 5,
                    hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: '#f8f9fa',
                        titleColor: '#333',
                        bodyColor: '#333',
                        borderColor: '#ccc',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, 
                    }
                }
            }
        });

        var ctxPie = document.getElementById('dummyPieChart').getContext('2d');
        var defaultCategory = Object.keys(kpiData)[0]; // Pick the first available category

        var dummyPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: institutionNames, // Assuming the same institution names are used for each category
                datasets: [{
                    label: 'KPI Achievement (%)',
                    data: kpiData[defaultCategory] || [], 
                    backgroundColor: ['rgba(54, 162, 235, 0.7)', 'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Update the Pie chart when the filter is changed
        document.getElementById('kpiFilter').addEventListener('change', function() {
            var selectedCategory = this.value;
            dummyPieChart.data.datasets[0].data = kpiData[selectedCategory] || [];
            dummyPieChart.update();
        });
    });
</script>
@endsection


    

