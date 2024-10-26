@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    /* Konsistenkan Reka Bentuk Jadual */
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2); /* Kesan bayangan lebih ketara */
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
        transform: translateY(-2px); /* Kesan angkat */
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan lebih ketara pada hover */
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        transition: all 0.2s ease; /* Transisi untuk kesan hover */
    }

    .table tbody td:first-child {
        font-weight: bold;
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
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan modal */
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan di bawah header modal */
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

    /* Responsive styles */
    @media (max-width: 768px) {
        .table {
            width: 100%; /* Table takes full width on smaller screens */
            overflow-x: auto; /* Allow horizontal scrolling */
        }
    }
</style>




<div class="container">
    <div class="container-fluid mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="head-title">
                <div class="left">
                    <h1>Institution Management</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Institution Management</a></li>
                    </ul>
                </div>
            </div>
        
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstitutionModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Add New Institution
            </a>
        </div>
    </div>

    {{-- Add Institution Modal --}}
    <div class="modal fade" id="addInstitutionModal" tabindex="-1" aria-labelledby="addInstitutionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstitutionModalLabel">Add New Institution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('institutions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Institution Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="state_id" class="form-label">State</label>
                            <select class="form-select" id="state_id" name="state_id" required>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Address</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Institution</button>
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
                    <th>State</th>
                    <th>ADDRESS</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($institutions as $index => $institution)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $institution->name }}</td>
                    <td>{{ $institution->state->name }}</td>
                    <td>{{ $institution->description }}</td>
                    <td>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editInstitutionModal{{ $institution->id }}">Edit</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-permission-id="{{ $institution->id }}"
                            data-permission-name="{{ $institution->name }}">
                            Delete
                        </button>
                    </td>
                </tr>

                {{-- Edit Institution Modal --}}
                <div class="modal fade" id="editInstitutionModal{{ $institution->id }}" tabindex="-1" aria-labelledby="editInstitutionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editInstitutionModalLabel">Edit Institution</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('institutions.update', $institution->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Institution Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $institution->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="state_id" class="form-label">State</label>
                                        <select class="form-select" id="state_id" name="state_id" required>
                                            @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ $state->id == $institution->state_id ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description">{{ $institution->description }}</textarea>
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
                    <p>Are you sure you want to delete the institution:</p>
                    <b><span id="deletePermissionName" style="font-weight: bold; text-transform: uppercase;"></span></b>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:blue">Cancel</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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
            var nameSpan = document.getElementById('deletePermissionName'); // Corrected span ID

            form.action = '/institutions/' + permissionId; // Set the form action dynamically
            nameSpan.textContent = permissionName; // Set the permission name in the modal
        });
    });
</script>

@endsection
