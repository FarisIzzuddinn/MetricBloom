@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
   /* Gaya untuk jadual */
.table {
    margin-bottom: 0;
    border-radius: 12px;
    overflow: hidden;
}

.table th, .table td {
    padding: 15px;
    text-align: left;
}

.table th {
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 12px 16px;
}

.table tbody tr {
    border-bottom: 1px solid #dee2e6;
    transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s;
}

.table tbody tr:hover {
    background-color: #f1f3f5;
    transform: translateY(-2px);
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
}

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    transition: all 0.2s ease;
}

.table tbody td:first-child {
    font-weight: bold;
}

h4 {
    text-align: start;
    color: #343a40;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.875rem;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease-in-out;
}

.btn-success {
    background-color: #38c172;
    border-color: #38c172;
}

.btn-danger {
    background-color: #e3342f;
    border-color: #e3342f;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
}

.modal-content {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
    background-color: #f8f9fa;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
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

@media (max-width: 768px) {
    .table {
        width: 100%;
        overflow-x: auto;
    }
}

</style>

<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="font-size: 3rem;">Teras</h4>
                    <a href="{{ url('teras/create') }}" class="btn btn-danger float-end mb-3">Add Teras</a>
                </div>                
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TERAS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teras as $index => $teras)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $teras->teras }}</td>
                            <td>
                                <!-- Butang Edit dengan Modal -->
                                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal"
                                   onclick="setEditModal('{{ $teras->teras }}', '{{ url('teras/'.$teras->id.'/edit') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                                <!-- Butang Delete dengan Modal -->
                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteModal('{{ $teras->teras }}', '{{ url('teras/'.$teras->id.'/delete') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <h5 class="modal-title" id="editModalLabel">Edit Teras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('teras.update', $teras->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="teras" class="form-label">Teras Name</label>
                        <input type="text" name="teras" id="teras" value="{{ $teras->teras }}" class="form-control">
                    </div>
                    <div class="mb-3  ">
                        <button type="submit" class="btn btn-success align-items-center">Update</button>
                        <button type="button" class="btn btn-primary align-items-center" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setEditModal(name, url) {
        document.getElementById('edit-teras').value = name;
        document.getElementById('editForm').setAttribute('action', url);
    }
</script>

@endsection
