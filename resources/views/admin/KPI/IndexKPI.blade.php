@extends('layout')
@section('title', 'KPI')
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

    .kpi-statement {
        white-space: pre-wrap; /* Membolehkan pembalut perkataan */
        word-wrap: break-word; /* Membolehkan perkataan panjang untuk membalut */
        max-width: 150px; /* Tetapkan lebar maksimum yang sesuai */
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
                            <h5 class="ms-2">KPI TABLE</h5>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <div class="btn-group">
                                @include('admin.KPI.add')
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
                                    <th class="text-secondary small-text">JENIS SASARAN</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addKpis as $addKpi)
                                    <tr>
                                        <td class="text-secondary small-text">{{ $loop->iteration }}</td>
                                        <td class="small-text">{{ $addKpi->teras->id }}</td>
                                        <td class="small-text">{{ $addKpi->so->id }}</td>
                                        <td class="small-text">{{ $addKpi->negeri }}</td>
                                        <td class="small-text">{{ $addKpi->user->name }}</td>
                                        <td class="small-text">{{ $addKpi->kpi }}</td>
                                        <td class="small-text kpi-statement">{{ $addKpi->pernyataan_kpi }}</td>
                                        <td class="small-text">{{ $addKpi->sasaran }}</td>
                                        <td class="small-text">{{ $addKpi->jenis_sasaran }}</td>
                                        <td>
                                            <button onclick="openEditPopup({{ json_encode($addKpi) }})" class="btn btn-warning small-button">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg>
                                            </button>
                                            @include('admin.KPI.delete')
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <label for="teras" class="col-sm-5 col-form-label">Teras</label>
                        <div class="col-sm-7">
                            <select id="editTeras" name="teras_id" class="form-select" required>
                                @foreach ($teras as $teras)
                                    <option value="{{ $teras->id }}">{{ $teras->teras }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="SO" class="col-sm-5 col-form-label">SO</label>
                        <div class="col-sm-7">
                            <select id="editSO" name="so_id" class="form-select" required>
                                @foreach ($so as $so)
                                    <option value="{{ $so->id }}">{{ $so->SO }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editNegeri" class="col-sm-5 col-form-label">NEGERI</label>
                        <div class="col-sm-7">
                            <select id="editNegeri" name="negeri" class="form-select" required>
                                <option value="" disabled selected>Select Negeri</option>
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Pulau Pinang">Pulau Pinang</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                                <option value="Wilayah Persekutuan Kuala Lumpur">Wilayah Persekutuan Kuala Lumpur</option>
                                <option value="Wilayah Persekutuan Labuan">Wilayah Persekutuan Labuan</option>
                                <option value="Wilayah Persekutuan Putrajaya">Wilayah Persekutuan Putrajaya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editPemilik" class="col-sm-5 col-form-label">PEMILIK</label>
                        <div class="col-sm-7">
                            <select id="editPemilik" name="user_id" class="form-select" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editPernyataanKpi" class="col-sm-5 col-form-label">PERNYATAAN KPI</label>
                        <div class="col-sm-7">
                            <input type="text" id="editPernyataanKpi" name="pernyataan_kpi" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editSasaran" class="col-sm-5 col-form-label">SASARAN</label>
                        <div class="col-sm-7">
                            <input type="number" inputmode="numeric" id="editSasaran" name="sasaran" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="editJenisSasaran" class="col-sm-5 col-form-label">JENIS SASARAN</label>
                        <div class="col-sm-7">
                            <select id="editJenisSasaran" name="jenis_sasaran" class="form-select" required>
                                <option value="" disabled selected>Select Jenis Sasaran</option>
                                <option value="peratus">%</option>
                                <option value="bilangan">Bilangan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditPopup(addKpi) {
        document.getElementById('editKpiForm').action = `/admin/addKpi/update/${addKpi.id}`;
        document.getElementById('editTeras').value = addKpi.teras.teras;
        document.getElementById('editSO').value = addKpi.so.SO;
        document.getElementById('editNegeri').value = addKpi.negeri;
        document.getElementById('editPemilik').value = addKpi.user.name;
        document.getElementById('editPernyataanKpi').value = addKpi.pernyataan_kpi;
        document.getElementById('editSasaran').value = addKpi.sasaran;
        document.getElementById('editJenisSasaran').value = addKpi.jenis_sasaran;
        var editKpiModal = new bootstrap.Modal(document.getElementById('editKpi'));
        editKpiModal.show();
    }
</script>
@endsection


