@extends('layout')
@section('title', 'Jabatan Penjara Malaysia')
@section('body')
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

    @include('sidebar');

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

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="h3">Dashboard</div>
            {{-- <div>
                <input type="search" class="form-control" placeholder="Search (Ctrl+/)">
            </div> --}}
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe me-3" viewBox="0 0 16 16">
                    <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-low me-3" viewBox="0 0 16 16">
                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8m.5-9.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 11a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m5-5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m-11 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m9.743-4.036a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707m-7.779 7.779a.5.5 0 1 1-.707-.707.5.5 0 0 1 .707.707m7.072 0a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707M3.757 4.464a.5.5 0 1 1 .707-.707.5.5 0 0 1-.707.707"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell me-3" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                </svg>
                <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fsproutsocial.com%2Fglossary%2Fprofile-picture%2F&psig=AOvVaw0vQNCYK0zVyXqUfDST4R1_&ust=1724320893868000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCNDZp4TqhYgDFQAAAAAdAAAAABAE" class="rounded-circle" alt="User Profile">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Latest Statistics</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameChartModal" data-chart-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>Rename
                        </button>
                    </div>
                    <canvas id="chart1" class="chart-canvas"></canvas>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Latest Statistics</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#renameChartModal" data-chart-id="2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>Rename
                        </button>
                    </div>
                    <canvas id="chart2" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Rename Chart Modal -->
        <div class="modal fade" id="renameChartModal" tabindex="-1" aria-labelledby="renameChartModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="renameChartModalLabel">Rename Chart</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('updateChartTitle') }}" method="POST">
                            @csrf
                            <input type="text" class="form-control mb-2" name="chart_title" value="{{ old('chart_title', $chartConfiguration->chart_title ?? '') }}" required>
                            <button type="submit" class="btn btn-primary">Update Chart Title</button>
                        </form>
                    </div>
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
                            <th >SO</th>
                            <th >NEGERI</th>
                            <th >PEMILIK</th>
                            <th >KPI</th>
                            <th >PERNYATAAN KPI</th>
                            <th >SASARAN</th>
                            <th >PENCAPAIAN</th>
                            <th >PERATUS PENCAPAIAN</th>
                            <th >STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addKpis as $index => $addkpi)
                            <tr>
                                <td class="small-text text-secondary">{{ $index + 1 }}</td>
                                {{-- <td class="small-text">{{ $addkpi->teras->id }}</td> --}}
                                <td class="small-text kpi-statement">{{ $addkpi->so->id}}</td>
                                <td class="small-text">{{ $addkpi->negeri }}</td>
                                <td class="small-text">{{ $addkpi->user->name }}</td>
                                <td class="small-text">{{ $addkpi->kpi }}</td>
                                <td class="small-text kpi-statement">{{ $addkpi->pernyataan_kpi }}</td>
                                <td class="small-text">{{ $addkpi->sasaran }}</td>
                                <td class="small-text">{{ $addkpi->pencapaian }}%</td>
                                <td class="small-text">{{ number_format($addkpi->peratus_pencapaian, 2) }}%</td>
                                <td class="small-text">
                                    @if($addkpi->peratus_pencapaian >= 75)
                                        <span class="badge text-bg-success">Tinggi</span>
                                    @elseif($addkpi->peratus_pencapaian >= 50)
                                        <span class="badge text-bg-warning">Sederhana</span>
                                    @else
                                        <span class="badge text-bg-danger">Rendah</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    // title: { 
                    //     display: true,
                    //     text: chartTitle || 'Default Pie Chart Title', // Display the dynamic or default title
                    //     font: {
                    //         size: 18, // Size of the title
                    //     }
                    // }
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
    </script>
@endsection
