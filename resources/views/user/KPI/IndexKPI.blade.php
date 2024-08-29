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
                <h5 class="card-title">{{ $userTotalKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-success text-white">
            <div class="card-header">Achieved</div>
            <div class="card-body">
                <h5 class="card-title">{{ $userAchievedKpis }}</h5>
            </div>
        </div>
    </div> 
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-warning text-white">
            <div class="card-header">Pending</div>
            <div class="card-body">
                <h5 class="card-title">{{ $userPendingKpis }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card bg-info text-white">
            <div class="card-header">Average Achievement</div>
            <div class="card-body">
                <h5 class="card-title">{{ $userAverageAchievement }}%</h5>
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
                <!-- Table Section -->
            <div class="table-container">
                <div class="table-responsive table-responsive-sm">
                    <table class="table p-3 mb-5">
                        <thead>
                            <tr class="table-secondary text-secondary small-text">
                                <th >BIL</th>
                                <th >TERAS</th>
                                <th >SO</th>
                                <th >KPI</th>
                                <th >PERNYATAAN KPI</th>
                                <th >SASARAN</th>
                                <th >JENIS SASARAN</th>
                                <th >PENCAPAIAN</th>
                                <th >PERATUS PENCAPAIAN</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addKpis as $addKpi)
                                <tr>
                                    <td class="text-secondary small-text">{{ $loop->iteration }}</td>
                                    <td class="small-text">{{ $addKpi->teras->teras }}</td>
                                    <td class="small-text">{{ $addKpi->SO->SO }}</td>
                                    <td class="small-text">{{ $addKpi->kpi }}</td>
                                    <td class="small-text kpi-statement">{{ $addKpi->pernyataan_kpi }}</td>
                                    <td class="small-text">{{ $addKpi->sasaran }}</td>
                                    <td class="small-text">{{ $addKpi->jenis_sasaran }}</td>
                                    <td class="small-text">{{ $addKpi->pencapaian }}</td>
                                    <td class="small-text">{{ $addKpi->peratus_pencapaian }}</td>
                                    <td>
                                        <button onclick="openEditPopup({{ json_encode($addKpi) }})" class="btn btn-warning small-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </button>
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

<div class="modal fade" id="editKpi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">EDIT KPI</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editKpiForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Form fields for editing KPI -->
                    <div class="row mb-3">
                        <label for="editTeras" class="col-sm-5 col-form-label">TERAS</label>
                        <div class="col-sm-7">
                            <input type="text" id="editTeras" name="teras" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editSO" class="col-sm-5 col-form-label">SO</label>
                        <div class="col-sm-7">
                            <input type="text" id="editSO" name="SO" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editkpi" class="col-sm-5 col-form-label">KPI</label>
                        <div class="col-sm-7">
                            <input type="text" id="editkpi" name="kpi" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editPernyataanKpi" class="col-sm-5 col-form-label">PERNYATAAN KPI</label>
                        <div class="col-sm-7">
                            <input type="text" id="editPernyataanKpi" name="pernyataan_kpi" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editSasaran" class="col-sm-5 col-form-label">SASARAN</label>
                        <div class="col-sm-7">
                            <input type="text" id="editSasaran" name="sasaran" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editJenisSasaran" class="col-sm-5 col-form-label">JENIS SASARAN</label>
                        <div class="col-sm-7">
                            <input type="text" id="editJenisSasaran" name="jenis_sasaran" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editPencapaian" class="col-sm-5 col-form-label">PENCAPAIAN</label>
                        <div class="col-sm-7">
                            <input type="text" id="editPencapaian" name="pencapaian" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editPeratusPencapaian" class="col-sm-5 col-form-label">PERATUS PENCAPAIAN</label>
                        <div class="col-sm-7">
                            <input type="text" id="editPeratusPencapaian" name="peratus_pencapaian" class="form-control" readonly>
                            {{-- <input type="hidden" id="editPeratusPencapaian" name="peratus_pencapaian"> --}}
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
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

    function openEditPopup(addKpi) {
        const modal = new bootstrap.Modal(document.getElementById('editKpi'));
        document.getElementById('editTeras').value = addKpi.teras.id;
        document.getElementById('editSO').value = addKpi.SO;
        document.getElementById('editkpi').value = addKpi.kpi;
        document.getElementById('editPernyataanKpi').value = addKpi.pernyataan_kpi;
        document.getElementById('editSasaran').value = addKpi.sasaran;
        document.getElementById('editJenisSasaran').value = addKpi.jenis_sasaran;
        document.getElementById('editPencapaian').value = addKpi.pencapaian;

        // Calculate peratus_pencapaian based on initial values
        const peratusPencapaian = calculatePeratusPencapaian(addKpi.pencapaian, addKpi.sasaran);
        document.getElementById('editPeratusPencapaian').value = peratusPencapaian.toFixed(2);

        document.getElementById('editKpiForm').action = `/user/addKpi/update/${addKpi.id}`;
        modal.show();
    }

    
    function calculatePeratusPencapaian(pencapaian, sasaran) {
        const pencapaianNum = parseFloat(pencapaian);
        const sasaranNum = parseFloat(sasaran);

        if (isNaN(pencapaianNum) || isNaN(sasaranNum) || sasaranNum === 0) {
            return 0;
        }

        const peratusPencapaian = (pencapaianNum / sasaranNum) * 100;
        return Math.min(peratusPencapaian, 100);
    }

    document.getElementById('editPencapaian').addEventListener('input', function () {
        const pencapaian = this.value;
        const sasaran = document.getElementById('editSasaran').value;
        const peratusPencapaian = calculatePeratusPencapaian(pencapaian, sasaran);
        document.getElementById('editPeratusPencapaian').value = peratusPencapaian.toFixed(2);
    });


</script>
@endsection



