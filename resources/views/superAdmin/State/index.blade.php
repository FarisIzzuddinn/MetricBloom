@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    /* Konsistenkan Reka Bentuk Jadual */
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
    }

    .table thead th {
        background-color: #f8f9fa; /* Light grey for header */
        color: #495057; /* Dark grey for text */
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 16px;
    }

    .table tbody tr {
        border-bottom: 1px solid #dee2e6; /* Light grey border */
        transition: transform 0.2s, box-shadow 0.2s; /* Animation for hover */
    }

    .table tbody tr:hover {
        background-color: #f1f3f5; /* Hover effect */
        transform: translateY(-2px); /* Lift effect */
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    .table tbody td:first-child {
        font-weight: bold;
    }

    /* Butang Gaya Konsisten */
    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.875rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out; /* Animation for button */
    }

    .btn:hover {
        transform: translateY(-2px); /* Lift effect */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
        background-color: #e3342f; /* Custom red */
        border-color: #e3342f;
    }

    /* Modal Reka Bentuk Konsisten */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

    /* Tajuk Konsisten */
    h4 {
        color: #343a40; /* Darker text color */
        margin-bottom: 16px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Text shadow */
    }
</style>


<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="font-size: 3rem;">Manage State</h4>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStateModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Add New State
                    </a>
                </div>                
            </div>

            {{-- Add State Modal --}}
            <div class="modal fade" id="addStateModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStateModalLabel">Add New State</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('states.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">State Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add State</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive">
                    <thead>
                        <tr class="table-secondary">
                            <th>Bil</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($states as $index => $state)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $state->name }}</td>
                            <td>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editStateModal{{ $state->id }}">Edit</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-permission-id="{{ $state->id }}"
                                    data-permission-name="{{ $state->name }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
    
                        {{-- Edit State Modal --}}
                        <div class="modal fade" id="editStateModal{{ $state->id }}" tabindex="-1" aria-labelledby="editStateModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStateModalLabel">Edit State</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('states.update', $state->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name" class="form-label">State Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $state->name }}" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

           <!-- Delete Permission Modal -->
           <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                </svg>
                <h5 class="modal-title mb-0" id="deleteModalLabel">Confirm Deletion</h5>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete the state:</p>
                <span id="permission-name" style="font-weight: bold;"></span>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete Modal Configuration
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var permissionId = button.getAttribute('data-permission-id');
            var permissionName = button.getAttribute('data-permission-name');
            var form = document.getElementById('deleteForm');
            var nameSpan = document.getElementById('permission-name'); // Corrected span ID

            form.action = '/states/' + permissionId; // Set the form action dynamically
            nameSpan.textContent = permissionName; // Set the permission name in the modal
        });
    });
</script>

@endsection
