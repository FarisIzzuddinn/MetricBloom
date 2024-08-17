@extends('layout')
@section('title', 'JABATAN PENJARA MALAYSIA ')
@section('body')
<style>
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

    .status-high {
            color: green;
        }
        .status-medium {
            color: orange;
        }
        .status-low {
            color: red;
        }

        
    .kpi-statement {
        white-space: pre-wrap; /* Membolehkan pembalut perkataan */
        word-wrap: break-word; /* Membolehkan perkataan panjang untuk membalut */
        max-width: 500px; /* Tetapkan lebar maksimum yang sesuai */
    }
</style>
@include('sidebar')
<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <div class="custom-bg-white border border-grey border-2 p-3 rounded shadow">
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <h5 class="ms-2">ADMIN DASHBOARD</h5>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.kpi') }}" class="btn btn-primary small-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    <span class="ms-2">MODIFY KPI</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-sm">
                        <table class="table mt-3 p-3">
                            <thead>
                                <tr>
                                    <th class="text-secondary small-text">BIL</th>
                                    <th class="text-secondary small-text">TERAS</th>
                                    <th class="text-secondary small-text">SO</th>
                                    <th class="text-secondary small-text">NEGERI</th>
                                    <th class="text-secondary small-text">PEMILIK</th>
                                    <th class="text-secondary small-text">KPI</th>
                                    <th class="text-secondary small-text">PERNYATAAN KPI</th>
                                    <th class="text-secondary small-text">SASARAN</th>
                                    <th class="text-secondary small-text">PENCAPAIAN</th>
                                    <th class="text-secondary small-text">PERATUS PENCAPAIAN</th>
                                    <th class="text-secondary small-text">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addKpis as $index => $addkpi)
                                    <tr>
                                        <td class="small-text text-secondary">{{ $index + 1 }}</td>
                                        <td class="small-text">{{ $addkpi->teras->id }}</td>
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
                                                <span class="status-high">Tinggi</span>
                                            @elseif($addkpi->peratus_pencapaian >= 50)
                                                <span class="status-medium">Sederhana</span>
                                            @else
                                                <span class="status-low">Rendah</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <span class="me-2 text-small">Peratus Pencapaian Keseluruhan:</span>
                            @php
                                $statusClass = '';
                                if ($averageAchievement >= 80) {
                                    $statusClass = 'bg-success text-success';
                                } elseif ($averageAchievement >= 50) {
                                    $statusClass = 'bg-warning text-warning';
                                } else {
                                    $statusClass = 'bg-danger text-danger';
                                }
                            @endphp
                            <span class="badge-{{ $statusClass }} me-2">{{ number_format($averageAchievement, 2) }}%</span>
                        </div>
                    </div> 
                    <div class="container-sm border mb-5 mt-5">
                        <div class="row border">
                            <div class="col border" style="position: relative; height:40vh; width:80vw">
                                <canvas id="myChart4"></canvas>
                            </div>
                            <div class="col border" style="position: relative; height:40vh; width:80vw">
                                <canvas id="myChart5"></canvas>
                            </div>
                        </div>
                        <div class="row border">
                            <div class="col border">
                                <canvas id="myChart1"></canvas>
                            </div>
                            <div class="col border">
                                <canvas id="myChart2"></canvas>
                            </div>
                            <div class="col border">
                                <canvas id="myChart3"></canvas>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </main>
    </div>
</div>      

<script>
    const ctx1 = document.getElementById('myChart1');

    new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
        axis: 'y',
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        fill: false,
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
        ],
        borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
    }
    });

    const ctx2 = document.getElementById('myChart2');

    new Chart(ctx2, {
    type: 'line',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
        }]
    },
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });

    const ctx3 = document.getElementById('myChart3');

    new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            axis: 'y',
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
        }]
    },
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    });

    // const ctx4 = document.getElementById('myChart4');

    // document.addEventListener('DOMContentLoaded', function () {
    //         function updateChart() {
    //             
    //             axios.get(url)
    //                 .then(function (response) {
    //                     // Get data from response
    //                     const labels = response.data.labels;
    //                     const values = response.data.values;

    //                     // Update the chart with new data
    //                     myChart.data.labels = labels;
    //                     myChart.data.datasets[0].data = values;
    //                     myChart.update();
    //                 })
    //                 .catch(function (error) {
    //                     console.error('Error fetching chart data:', error);
    //                 });
    //         }
  // Get data from PHP
  const labels = @json($labels);
        const data = @json($data);

    // Create the initial chart
    const ctx4 = document.getElementById('myChart4').getContext('2d');
    const myChart = new Chart(ctx4, {
        type: 'bar', // or 'line', 'pie', etc.
        data: {
            labels: labels, // Initially empty
            datasets: [{
                label: 'Your Dataset',
                data: data, // Initially empty
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            // scales: {
            //     y: {
            //         beginAtZero: true
            //     }
            // }
        indexAxis: 'y',

        }
    });



      
        const ctx5 = document.getElementById('myChart5').getContext('2d');

        new Chart(ctx5, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: '# of Votes',
                    data: data,
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
                    }
                }
            }
        });
</script>
@endsection


