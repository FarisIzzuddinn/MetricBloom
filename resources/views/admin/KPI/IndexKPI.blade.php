@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ asset("css/table.css") }}">

<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="row align-items-center mb-3 mt-3" >
                <div class="col-auto">
                    <h5 class="ms-2" style="font-size: 3rem;">KPI TABLE</h5>
                </div>
                <div class="col d-flex justify-content-end">
                    <div class="btn-group">
                        @include('admin.KPI.add')
                    </div>
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
        document.getElementById('editKpiForm').action = `/admin/addKpi/update/${addKpi.id}`;
        document.getElementById('editTeras').value = addKpi.teras.id;
        document.getElementById('editSO').value = addKpi.so.id;
        addKpi.states.forEach(state => {
            document.getElementById(`edit_state_${state.id}`).checked = true;
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




