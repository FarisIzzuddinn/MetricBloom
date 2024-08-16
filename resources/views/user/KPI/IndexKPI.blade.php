@extends('layout')
@section('title', 'JABATAN PENJARA MALAYSIA')
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

    .form-control[readonly] {
        background-color: #e9ecef; /* Light gray background color */
        color: #495057; /* Text color */
    }

    .form-control[readonly]:hover {
        background-color: #e9ecef; /* Same background color to disable hover effect */
        cursor: default; /* Default cursor */
        border-color: #ced4da; /* Same border color to disable hover effect */
        box-shadow: none; /* Remove box shadow on hover */
    }

    .kpi-statement {
        white-space: pre-wrap; /* Membolehkan pembalut perkataan */
        word-wrap: break-word; /* Membolehkan perkataan panjang untuk membalut */
        max-width: 300px; /* Tetapkan lebar maksimum yang sesuai */
    }
</style>

@include('sidebar')
<div class="container d-flex flex-column">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <div class="custom-bg-white border border-grey border-2 p-3 rounded shadow">
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <h5 class="ms-2">KPI TABLE</h5>
                        </div>
                        {{-- <div class="col d-flex justify-content-end">
                            <div class="btn-group">
                                @include('admin.KPI.add')
                            </div>
                        </div> --}}
                    </div>
                    <div class="table-responsive table-responsive-sm">
                        <table class="table mt-3 p-3">
                            <thead>
                                <tr>
                                    <th class="text-secondary small-text">BIL</th>
                                    <th class="text-secondary small-text">TERAS</th>
                                    <th class="text-secondary small-text">SO</th>                                             
                                    <th class="text-secondary small-text">KPI</th>
                                    <th class="text-secondary small-text">PERNYATAAN KPI</th>
                                    <th class="text-secondary small-text">SASARAN</th>
                                    <th class="text-secondary small-text">JENIS SASARAN</th>
                                    <th class="text-secondary small-text">PENCAPAIAN</th>
                                    <th class="text-secondary small-text">PERATUS PENCAPAIAN</th>
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
            </div>
        </main>
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



<script>
    function openEditPopup(addKpi) {
        const modal = new bootstrap.Modal(document.getElementById('editKpi'));
        document.getElementById('editTeras').value = addKpi.teras;
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


    // Update peratus_pencapaian when pencapaian changes
    document.getElementById('editPencapaian').addEventListener('input', function () {
        const pencapaian = this.value;
        const sasaran = document.getElementById('editSasaran').value;
        const peratusPencapaian = calculatePeratusPencapaian(pencapaian, sasaran);
        document.getElementById('editPeratusPencapaian').value = peratusPencapaian.toFixed(2);
    });


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

    // Create the initial chart
    const ctx4 = document.getElementById('myChart4').getContext('2d');
    const myChart = new Chart(ctx4, {
        type: 'bar', // or 'line', 'pie', etc.
        data: {
            labels: [], // Initially empty
            datasets: [{
                label: 'Your Dataset',
                data: [], // Initially empty
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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

            // Fetch and update the chart with data
            // updateChart();

            // Optional: Set up a way to refresh the chart periodically or based on user actions
            // setInterval(updateChart, 5000); // Refresh every 5 seconds
//         });


    const ctx5 = document.getElementById('myChart5');

    new Chart(ctx5, {
    type: 'pie',
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
</script>


@endsection
