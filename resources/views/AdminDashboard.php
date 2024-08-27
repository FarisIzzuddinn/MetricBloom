{{-- @extends('layout') --}}
{{-- 
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




<div class="container">
    

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
                            
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional: Chart.js for charts -->
    <script>
   
    </script>
@endsection --}}



@extends('layout')
@section('title', 'Dashboard')
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

<style>
    .table {
        margin-bottom: 0;
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
    }

    h4{
        text-align: start;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <h4>ADMIN DASHBOARD</h4>
            </div>

            <div class="row">
                <div class="col-lg-12">
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

           
            </div>
        </div>
    </div>
</div>

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

        
</script>
@endsection



