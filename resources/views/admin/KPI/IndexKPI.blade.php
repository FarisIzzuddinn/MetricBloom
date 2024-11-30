@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">


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

        @if(session('status'))
            <div id="alert-message" class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
                {{ session('status') }}
            </div>

            <script>
                setTimeout(function() {
                    let alert = document.getElementById('alert-message');
                    if(alert){
                        alert.classList.add('fade-out'); // Start fade-out effect
                        setTimeout(() => alert.remove(), 500); // Remove after fade-out completes
                    }
                }, 5000);
            </script>
        @endif

        <!-- Check if there are any KPI records -->
        @if($addKpis->isEmpty())
            <div class="alert alert-warning mt-3" role="alert">
                No KPI data available.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered mt-0 p-0">
                    <thead>
                        <tr>
                            <th class="small-text">BIL</th>
                            <th class="small-text">TERAS</th>
                            <th class="small-text">SECTOR</th>
                            <th class="small-text">STATE</th>
                            <th class="small-text">INSTITUTIONS</th>
                            <th class="small-text">DISTINCT</th>
                            <th class="small-text">KPI</th>
                            <th class="small-text">PDF</th>
                            <th class="small-text">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addKpis as $addKpi)
                            <tr>
                                <td class="text-secondary small-text">{{ $loop->iteration }}</td>
                                <td class="small-text">{{ $addKpi->teras ? $addKpi->teras->id : 'No Teras Found' }}</td>
                                <td class="small-text">{{ $addKpi->sector ? $addKpi->sector->id : 'No Sector found' }}</td>
                                <td class="small-text">
                                    @if ($addKpi->states->isNotEmpty())
                                        <ul>
                                            @foreach ($addKpi->states as $state)
                                                <li>{{ $state->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em>No States Assigned</em>
                                    @endif
                                </td>
                                <td class="small-text">
                                    @if ($addKpi->institutions->isNotEmpty())
                                        <ul>
                                            @foreach ($addKpi->institutions as $institution)
                                                <li>{{ $institution->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em>No Institutions Assigned</em>
                                    @endif
                                </td>
                                <td class="small-text">
                                    @if ($addKpi->bahagians->isNotEmpty())
                                        <ul>
                                            @foreach ($addKpi->bahagians as $bahagian)
                                                <li>{{ $bahagian->nama_bahagian }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <em>No Bahagians Assigned</em>
                                    @endif
                                </td>
                                {{-- <td class="small-text">{{ $addKpi->kpi }}</td> --}}
                                <td class="small-text kpi-statement">{{ $addKpi->pernyataan_kpi }}</td>
                                {{-- <td class="small-text">{{ $addKpi->sasaran }}</td>
                                <td class="small-text">{{ $addKpi->jenis_sasaran }}</td> --}}
                                <td>
                                    @if($addKpi->pdf_file_path)
                                        <a href="{{ url('/storage/' . $addKpi->pdf_file_path) }}" target="_blank">Download PDF</a>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="openEditPopup({{ json_encode($addKpi) }})" class="btn btn-warning small-button mt-1">
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
        @endif
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
                                <select id="editSO" name="sectors_id" class="form-select" required>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>   
                                    @endforeach
                                </select>
                            </div>
                        </div>
{{-- 
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
                        </div> --}}

                        <div class="form-group mt-4">
                            <label for="editOwner">Select Owners:</label>
                            <div class="border p-3">
                                <h5>States</h5>
                                @foreach ($states as $state)
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="owners[]" 
                                            value="state-{{ $state->id }}" 
                                            id="state-{{ $state->id }}">
                                        <label class="form-check-label" for="state-{{ $state->id }}">
                                            {{ $state->name }}
                                        </label>
                                    </div>
                                @endforeach
    
                                <h5 class="mt-3">Institutions</h5>
                                @foreach ($institutions as $institution)
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="owners[]" 
                                            value="institution-{{ $institution->id }}" 
                                            id="institution-{{ $institution->id }}">
                                        <label class="form-check-label" for="institution-{{ $institution->id }}">
                                            {{ $institution->name }}
                                        </label>
                                    </div>
                                @endforeach
    
                                <h5 class="mt-3">Bahagian</h5>
                                @foreach ($bahagians as $bahagian)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="owners[]"
                                            value="bahagian-{{ $bahagian->id }}"
                                            id="bahagian-{{ $bahagian->id }}">
                                        <label class="form-check-label" for="bahagian-{{ $bahagian->id }}">
                                            {{ $bahagian->nama_bahagian }}
                                        </label>
                                    </div>
                                @endforeach
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
        document.getElementById('editKpiForm').action = `/admin/addKpi/update/${addKpi.id}`;
        document.getElementById('editTeras').value = addKpi.teras.id;
        document.getElementById('editSO').value = addKpi.sector.id;
        document.querySelectorAll('input[name="owners[]"]').forEach(input => input.checked = false);

        // Check relevant owners
        if (addKpi.states) {
            addKpi.states.forEach(state => {
                document.getElementById(`state-${state.id}`).checked = true;
            });
        }
        if (addKpi.institutions) {
            addKpi.institutions.forEach(institution => {
                document.getElementById(`institution-${institution.id}`).checked = true;
            });
        }
        if (addKpi.bahagians) {
            addKpi.bahagians.forEach(bahagian => {
                document.getElementById(`bahagian-${bahagian.id}`).checked = true;
            });
        }

        // document.getElementById('editPemilik').value = addKpi.user.id;
        document.getElementById('editPernyataanKpi').value = addKpi.pernyataan_kpi;
        document.getElementById('editSasaran').value = addKpi.sasaran;
        document.getElementById('editJenisSasaran').value = addKpi.jenis_sasaran;
        var editKpiModal = new bootstrap.Modal(document.getElementById('editKpi'));
        editKpiModal.show();
    }

    function setDeleteModal(kpiId) {
        // Set the form action URL with the correct KPI ID
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/kpi/${kpiId}`; // Adjust the route as needed

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>

@endsection
