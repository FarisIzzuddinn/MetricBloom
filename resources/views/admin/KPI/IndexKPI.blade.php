@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<style>
    /* Gaya untuk jadual */
    .table {
        margin-bottom: 0; /* Remove margin at the bottom of the table */
        border-radius: 12px; /* Rounded corners for the table */
        overflow: hidden; /* Ensure rounded corners work */
    }

    .table th, .table td {
        padding: 15px; /* Padding for better spacing */
        text-align: left; /* Align text to the left */
    }

    .table th {

        text-transform: uppercase; /* Ubah suai huruf besar */
        letter-spacing: 0.1em; /* Jarak huruf */
        padding: 12px 16px; /* Padding untuk header */
    }

    .table tbody tr {
        border-bottom: 1px solid #dee2e6; /* Light grey border */
        transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s; /* Smooth transition for hover */
    }

    .table tbody tr:hover {
        background-color: #f1f3f5; /* Light gray background on hover */
        transform: translateY(-2px); /* Kesan angkat */
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan lebih ketara pada hover */
    }

    .table tbody td {
        padding: 12px 16px; /* Padding untuk sel */
        vertical-align: middle; /* Pusatkan vertikal */
        transition: all 0.2s ease; /* Transisi untuk kesan hover */
    }

    .table tbody td:first-child {
        font-weight: bold; /* Tebalkan teks pada kolum pertama */
    }

    h4 {
        text-align: start;
        color: #343a40; /* Darker color for heading */
        margin-bottom: 20px; /* Space below the heading */
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Text shadow */
    }

    /* Butang Gaya Konsisten */
    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.875rem;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Bayangan butang */
        transition: all 0.2s ease-in-out; /* Animation for button */
    }

    .btn:hover {
        transform: translateY(-2px); /* Kesan angkat pada hover */
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Bayangan lebih ketara pada hover */
    }

    /* Modal Reka Bentuk Konsisten */
    .modal-content {
        border-radius: 12px; /* Rounded corners for modal */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan modal */
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa); /* Gradient background */
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6; /* Bottom border */
        background-color: #f8f9fa; /* Light grey background */
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan di bawah header modal */
    }

    .modal-title {
        font-weight: bold; /* Bold title */
        color: #495057; /* Dark grey color */
    }

    .modal-footer {
        border-top: 1px solid #dee2e6; /* Top border */
    }

    .btn-close {
        background: none; /* No background */
        border: none; /* No border */
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .table {
            width: 100%; /* Table takes full width on smaller screens */
            overflow-x: auto; /* Allow horizontal scrolling */
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="head-title">
            <div class="left">
                <h1>KPI Management</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">KPI Management</a>
                    </li>
                </ul>
            </div>
            @include('admin.KPI.add')
        </div>
           
        <div class="table-responsive table-responsive-sm">
            <table class="table mt-3 p-3">
                <thead>
                    <tr class="table-secondary">
                        <th class="small-text">BIL</th>
                        <th class="small-text">TERAS</th>
                        <th class="small-text">SECTOR OPERATION</th>                          
                        <th class="small-text">STATE</th>                                                                                           
                        <th class="small-text">KPI</th>
                        <th class="small-text">KPI STATEMENT</th>
                        <th class="small-text">TARGET</th>
                        <th class="small-text">TARGET TYPE</th>
                        <th class="small-text">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($addKpis as $addKpi)
                        <tr>
                            <td class="text-secondary small-text">{{ $loop->iteration }}</td>
                            <td class="small-text">{{ $addKpi->teras ? $addKpi->teras->id : 'No Teras Found' }}</td>
                            <td class="small-text">{{ $addKpi->so ? $addKpi->so->id : 'No SO found' }}</td> 
                            <td class="small-text">
                                @if ($addKpi->states->isNotEmpty())
                                    @foreach ($addKpi->states as $state)
                                        {{ $state->name }} @if (!$loop->last), @endif
                                    @endforeach
                                @else
                                    No State Found
                                @endif
                            </td>
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
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButtonEdit" data-bs-toggle="dropdown" aria-expanded="false">
                                        Select States
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end w-100" aria-labelledby="dropdownMenuButtonEdit">
                                        @foreach($states as $state)
                                            <li>
                                                <div class="form-check px-3">
                                                    <input 
                                                        class="form-check-input" 
                                                        type="checkbox" 
                                                        name="states[]" 
                                                        id="edit_state_{{ $state->id }}" 
                                                        value="{{ $state->id }}">
                                                    <label class="form-check-label" for="edit_state_{{ $state->id }}">
                                                        {{ $state->name }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
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
                            <button type="submit" class="btn btn-primary">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditPopup(addKpi) {
        document.getElementById('editKpiForm').action = /admin/addKpi/update/${addKpi.id};
        document.getElementById('editTeras').value = addKpi.teras.id;
        document.getElementById('editSO').value = addKpi.so.id;
        addKpi.states.forEach(state => {
            document.getElementById(edit_state_${state.id}).checked = true;
        });
        // document.getElementById('editPemilik').value = addKpi.user.id;
        document.getElementById('editPernyataanKpi').value = addKpi.pernyataan_kpi;
        document.getElementById('editSasaran').value = addKpi.sasaran;
        document.getElementById('editJenisSasaran').value = addKpi.jenis_sasaran;
        var editKpiModal = new bootstrap.Modal(document.getElementById('editKpi'));
        editKpiModal.show();
    }
</script>

@endsection