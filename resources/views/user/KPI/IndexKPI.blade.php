@extends('layout')
@section('title', 'Dashboard')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<style>
    /* Container for charts */
    .chart-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    /* Canvas settings */
    canvas {
        width: 100% !important;
        height: 300px !important; /* Adjust height as needed */
        object-fit: contain; /* Maintain aspect ratio */
    }

    /* Table styles */
    .table {
        border-collapse: collapse; /* Collapse borders for consistency */
        width: 100%; /* Full width for better layout */
        box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f8f9fa; /* Light grey for header */
        color: #495057; /* Dark grey for text */
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 16px;
        border-bottom: 2px solid #dee2e6; /* Thicker border for header */
    }

    .table tbody tr {
        border-bottom: 1px solid #dee2e6; /* Light grey border */
    }

    .table tbody tr:hover {
        background-color: #f1f3f5; /* Hover effect */
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border: 1px solid #dee2e6; /* Added border for table cells */
    }

    .table tbody td:first-child {
        font-weight: bold;
        background-color: #f8f9fa; /* Highlight for first column */
    }

    /* Card styles */
    .card {
        transition: transform 0.3s, box-shadow 0.3s; /* Smooth transition for hover effects */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Add shadow */
        
    }

    .card:hover {
        transform: translateY(-5px); /* Slight lift effect */
        background-color: rgba(255, 255, 255, 0.8); /* Lighten background on hover */
    }

    .card-header {
        font-weight: bold; /* Bold header */
        text-transform: uppercase; /* Uppercase header */
        text-align: center; /* Centered text */
    }

    .card-title {
        font-size: 1.5rem; /* Larger title font size */
        margin: 0; /* Remove default margin */
        text-align: center; /* Centered text */
    }

    /* Button styles */
    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .btn-success {
        background-color: #38c172; /* Custom green */
        border-color: #38c172;
    }

    .btn-success:hover {
        background-color: #32a852; /* Darker green on hover */
    }

    .btn-danger {
        background-color: #e3342f; /* Custom red */
        border-color: #e3342f;
    }

    .btn-danger:hover {
        background-color: #c62828; /* Darker red on hover */
    }

    /* Modal styles */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .modal-title {
        font-weight: bold;
        color: #495057;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
    }

    .btn-close {
        background: none;
        border: none;
    }
    /* Tooltip styles */
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
    input[readonly] {
        background-color: #f0f0f0; /* Light gray background */
        color: #6c757d; /* Darker gray text color */
        border: 1px solid #ced4da; /* Border color */
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

<div class="head-title">
    <div class="left">
        <h1>Dashboard </h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-primary" style=" color: white;" data-tooltip="This is the latest kpi number."> 
            <div class="card-body text-center">
                <h5 class="card-title">TOTAL KPI</h5>
                <h5 class="card-title">{{ $userTotalKpis }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-success" style=" color: white;" data-tooltip="This is the number of KPIs that have been achieved."> 
            <div class="card-body text-center">
                <h5 class="card-title">ACHIEVED</h5>
                <h5 class="card-title">{{ $userAchievedKpis }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-warning" style=" color: white;" data-tooltip="This is the number of pending KPIs to achieve."> 
            <div class="card-body text-center">
                <h5 class="card-title">PENDING</h5>
                <h5 class="card-title">{{ $userPendingKpis }}</h5>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mt-1">
        <div class="card kpi-card bg-info" style="color: white;" data-tooltip="This is the average cumulative kpi"> 
            <div class="card-body text-center">
                <h5 class="card-title">AVERAGE</h5>
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
                                <th >NO</th>
                                <th >TERAS</th>
                                <th >SECTOR OPERATION</th>
                                <th >KPI</th>
                                <th >KPI STATEMENT</th>
                                <th >TARGET</th>
                                <th >TARGET TYPE</th>
                                <th >ACHIEVEMENT</th>
                                <th >REASON</th>
                                <th >ACHIEVEMENT PERCENTAGE</th>
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
                                    <td class="small-text">{{ $addKpi->reason }}</td>
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
                        </div>
                    </div>
                    
                    <!-- Reason for not achieving KPI -->
                    <div class="row mb-3" id="reason-container">
                        <label for="reason" class="col-sm-5 col-form-label">Reason for Not Achieving KPI</label>
                        <div class="col-sm-7">
                            {{-- <textarea id="reason" name="reason" class="form-control" rows="3">{{ old('reason', $addKpi->reason) }}</textarea> --}}
                            <select id="reason" name="reason" class="form-control">
                                @if(old('reason', $addKpi->reason) != '')
                                    <option value="{{ old('reason', $addKpi->reason) }}">{{ old('reason', $addKpi->reason) }}</option>
                                @endif
                                <option value=""disabled selected>--- Select Reason ---</option>
                                <option value="money">Money</option>
                                <option value="manpower">Manpower</option>
                                <option value="material">Material</option>
                            </select>
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
    document.addEventListener('DOMContentLoaded', function() {
        const peratusPencapaianInput = document.getElementById('editPencapaian');
        const reasonContainer = document.getElementById('reason-container');

        // Listen for changes on the PENCAPAIAN input
        peratusPencapaianInput.addEventListener('input', function() {
            const peratusPencapaian = parseFloat(peratusPencapaianInput.value);
            
            if (peratusPencapaian < 100) {
                reasonContainer.style.display = 'block'; // Show the reason container
                reasonContainer.querySelector('textarea').setAttribute('required', 'required'); // Make the textarea required
            } else {
                reasonContainer.style.display = 'none'; // Hide the reason container
                reasonContainer.querySelector('textarea').removeAttribute('required'); // Remove the required attribute
            }
        });
    });


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
                label: chartTitle || 'HI',
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
        type: 'pie', // Change to 'pie' or 'doughnut' if appropriate
        data: {
            labels: labels, // Ensure this is correct for pie chart
            datasets: [{
                // label: chartTitle || 'Default Title',
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
                    // text: chartTitle || 'Default Pie Chart Title', 
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
        document.getElementById('editSO').value = addKpi.SO ? addKpi.SO : '';
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



