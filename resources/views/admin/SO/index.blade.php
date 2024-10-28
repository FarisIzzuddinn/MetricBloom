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

<div class="head-title">
    <div class="left">
        <h1>Sector Operation Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Sector Operation Management</a>
            </li>
        </ul>
    </div>
    <a href="{{ url('so/create') }}" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addSoModal">Add SO</a>
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

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>SO</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($so as $index => $so)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $so->SO }}</td>
                            <td>
                                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{$so->id}}" onclick="setEditModal('{{ $so->SO }}', '{{ url('so/'.$so->id.'/edit') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$so->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </td>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{$so->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$so->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{$so->id}}">Edit SO</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('so/'.$so->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3 ">
                                                    <label for="so" class="form-label">SO</label>
                                                    <input type="text" class="form-control" id="so{{$so->id}}" name="SO" value="{{ $so->SO }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                                    </svg>
                                                </button>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Add SO Modal -->
                            <div class="modal fade" id="addSoModal" tabindex="-1" aria-labelledby="addSoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addSoModalLabel">Add SO</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('so') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="new_so" class="form-label">SO</label>
                                                    <input type="text" class="form-control" id="new_so" name="SO" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-center">
                                                <button type="button" class="btn btn-primary me-2" data-bs-dismiss="modal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                                    </svg>
                                                </button>
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            

                             <!-- Delete Confirmation Modal -->
                             <div class="modal fade" id="deleteModal{{$so->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$so->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex flex-column align-items-center text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                            <h5 class="modal-title" id="deleteModalLabel{{$so->id}}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p>Are you sure you want to delete</p>
                                            <strong style="font-weight: bold; text-transform: uppercase;">{{ $so->SO }}</strong>?
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                            </svg>
                                            </button>
                                            <a href="{{ url('so/'.$so->id.'/delete') }}" class="btn btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                            </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function setEditModal(value, url) {
        const inputField = document.querySelector(`#so${url.split('/').pop()}`);
        inputField.value = value;
    }
</script>
