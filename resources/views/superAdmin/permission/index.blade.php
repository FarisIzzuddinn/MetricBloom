@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    .table {
        margin-bottom: 0;
        border-radius: 12px; /* Rounded corners for the table */
        overflow: hidden; /* Ensures corners are rounded */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    }

    .table th {
        background-color: #f8f9fa; /* Light background for header */
        color: #333; /* Dark text for better readability */
        font-weight: bold; /* Bold text for emphasis */
        text-align: center; /* Center align header text */
    }

    .table td {
        text-align: center; /* Center align table data */
    }

    .table tr:nth-child(even) {
        background-color: #f2f2f2; /* Light grey for even rows */
    }

    .table tr:hover {
        background-color: #e9ecef; /* Slightly darker grey on hover */
    }

    .table th:first-child {
        border-top-left-radius: 12px;
    }

    .table th:last-child {
        border-top-right-radius: 12px;
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    .badge-admin {
        background-color: #f5a623;  /* Custom Orange */
        color: rgb(0, 0, 0);
    }

    .badge-superadmin {
        background-color: #da58da;  /* Custom Red */
        color: rgb(0, 0, 0);
    }

    .badge-user {
        background-color: #1acfc9;  /* Custom Green */
        color: rgb(3, 0, 0);
    }

    .btn {
        transition: background-color 0.3s; /* Smooth transition for buttons */
    }

    .btn:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
</style>

<div class="container rounded-1">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="font-size: 3rem;">Permissions</h4>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Add New Permissions
                    </a>
                </div>                
            </div>

            <!-- Add Permission Modal -->
            <div class="modal fade" id="addPermissionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fs-5" id="addPermissionModalLabel">Add Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/permissions" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="permissionName" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control" id="permissionName" name="name" placeholder="Enter permission name">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive">
                    <thead>
                        <tr class="table-secondary">
                            <th>NAME</th>
                            <th>ASSIGNED TO</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $index => $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                @foreach($permission->roles as $role)
                                <span class="badge badge-{{ strtolower(str_replace(' ', '', $role->name)) }}">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </td>
                            <td>
                                <!-- Button trigger edit modal -->
                                <button type="button" class="btn btn-success edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-permission-id="{{ $permission->id }}"
                                    data-permission-name="{{ $permission->name }}">
                                    Edit
                                </button>

                                <!-- Button trigger delete modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-permission-id="{{ $permission->id }}"
                                    data-permission-name="{{ $permission->name }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-2 text-center">{{ $permissions->links() }}</div>
            </div>

            <!-- Edit Permission Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="editPermissionName" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control" id="editPermissionName" name="name">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                            <p>Are you sure you want to delete the permission:</p>
                            <b><span id="deletePermissionName" style="font-weight: bold; text-transform: uppercase;"></span></b>?
                        </div>
                        <div class="modal-footer justify-content-center">
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

            form.action = '/permissions/' + permissionId; // Set the form action dynamically
            nameSpan.textContent = permissionName; // Set the permission name in the modal
        });

        // Edit Modal Configuration
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var permissionId = button.getAttribute('data-permission-id');
            var permissionName = button.getAttribute('data-permission-name');
            var form = document.getElementById('editForm');
            var nameInput = document.getElementById('editPermissionName');

            form.action = '/permissions/' + permissionId;
            nameInput.value = permissionName;
        });
    });
</script>

@endsection
