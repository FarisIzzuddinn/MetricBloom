@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    .table {
        margin-bottom: 0;
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
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <h4>Permissions
                    <a href="#" class="btn btn-danger float-end mb-2" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg> ADD PERMISSIONS
                    </a>
                </h4>
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
                            <!-- Borang tambah permission -->
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
                <table class="table">
                    <thead>
                        <tr class="table-secondary">
                            <th>NO</th>
                            <th>NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
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
                                <button type="submit" class="btn btn-primary">Save changes</button>
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
