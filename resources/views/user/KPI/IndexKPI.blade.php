

            @extends('layout')

<style>
    body {
        background-color: #f8f9fa;
        overflow-x: hidden;
    }
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .content {
        margin-left: 300px; /* Match this value with the width of the sidebar */
        margin-right: 20px; /* Adjust this value as needed for right-side spacing */
        padding: 100px;
        padding-top: 5px;
    }
    .table-container {
        margin-top: 10px; /* Space between chart and table */
        overflow: hidden; /* Ensures that the border radius applies correctly */
    }
    .table {
        margin-bottom: 0; /* Remove margin at the bottom of the table */
    }
    .table th:first-child {
        border-top-left-radius: 12px;
    }
    .table th:last-child {
        border-top-right-radius: 12px;
    }
    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }
    .btn-rename-chart {
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .small-text {
        font-size: 0.75rem; /* Mengurangkan saiz font */
        white-space: nowrap; /* Mengelakkan pembungkusan teks */
        text-overflow: ellipsis; /* Menambah ellipsis jika teks melebihi lebar sel */
        overflow: hidden; /* Mengelakkan teks melimpah keluar dari sel */
    }
    .small-button {
        font-size: 0.75rem; /* Saiz font kecil */
        white-space: nowrap; /* Elakkan pembungkusan teks */
        padding: 0.25rem 0.5rem; /* Padding yang lebih kecil */
        text-overflow: ellipsis; /* Tambah ellipsis jika teks melebihi lebar butang */
        overflow: hidden; /* Elakkan teks melimpah keluar dari butang */
    }
    .kpi-statement {
        white-space: pre-wrap; /* Membolehkan pembalut perkataan */
        word-wrap: break-word; /* Membolehkan perkataan panjang untuk membalut */
        max-width: 500px; /* Tetapkan lebar maksimum yang sesuai */
    }
    .btn-rename-chart:hover {
        background-color: #0069d9;
        transform: translateY(-1px);
    }
    .btn-rename-chart:focus {
        box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.5);
    }
</style>

@section('content')


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

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Latest Statistics</h5>
                        </div>
                        <canvas id="chart1" class="chart-canvas"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Latest Statistics</h5>
                        </div>
                        <canvas id="chart2" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>

    
            
            <!-- Table Section -->
            <div class="table-container">
                <div class="table-responsive table-responsive-sm">
                    <table class="table p-3 mb-5">
                        <thead>
                            <tr class="table-secondary text-secondary small-text">
                                <th >BIL</th>
                                {{-- <th >TERAS</th> --}}
                                {{-- <th >SO</th> --}}
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
                                {{-- <td class="small-text">{{ $addKpi->teras->teras }}</td> --}}
                                {{-- <td class="small-text">{{ $addKpi->SO->SO }}</td> --}}
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
                </d
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional: Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      // Chart 1
        const labels = @json($labels);
        const data = @json($data);
        const chartTitle = @json($chartTitle);

        const ctx1 = document.getElementById('chart1').getContext('2d');
        const chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: chartTitle || 'Default Title', // Provide a fallback title
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
            }
        });

        // Chart 2
        // Ensure labels and data are properly set and not empty
        const pieLabels = @json($labels); // Ensure this is populated with correct labels for the pie chart
        const pieData = @json($data); // Ensure this is populated with correct data for the pie chart

        // Function to generate random color
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Generate arrays for background and border colors
        const backgroundColors = pieData.map(() => getRandomColor());
        const borderColors = pieData.map(() => getRandomColor());

        const ctx2 = document.getElementById('chart2').getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: chartTitle || 'Default Title',
                    data: pieData.length > 0 ? pieData : [1], // Ensure there's data to render
                    backgroundColor: pieData.length > 0 ? backgroundColors : ['#f0f0f0'], 
                    borderColor: pieData.length > 0 ? borderColors : ['#ccc'], 
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

        // If no data is available, display "No Data Available" text
        if (pieData.length === 0 || pieData.every(item => item === 0)) {
            const ctx = ctx2;
            ctx.font = "16px Arial";
            ctx.textAlign = "center";
            ctx.fillStyle = "#666"; // Grey color for the text
            ctx.fillText("No Data Available", ctx.canvas.width / 2, ctx.canvas.height / 2);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const renameChartForm = document.getElementById('renameChartForm');

            renameChartForm.addEventListener('submit', function (event) {
                const chartIdInput = renameChartForm.querySelector('#chart_id');
                const chartId = chartIdInput.value;

                if (!Number.isInteger(Number(chartId))) {
                    alert('Chart ID must be an integer.');
                    event.preventDefault();
                }
            });
        });

        function openEditPopup(addKpi) {
                    const modal = new bootstrap.Modal(document.getElementById('editKpi'));
                    // document.getElementById('editTeras').value = addKpi.teras.id;
                    // document.getElementById('editSO').value = addKpi.SO;
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
            
            
                // Update peratus_pencapaian when pencapaian changes
                document.getElementById('editPencapaian').addEventListener('input', function () {
                    const pencapaian = this.value;
                    const sasaran = document.getElementById('editSasaran').value;
                    const peratusPencapaian = calculatePeratusPencapaian(pencapaian, sasaran);
                    document.getElementById('editPeratusPencapaian').value = peratusPencapaian.toFixed(2);
                });
    </script>
@endsection
