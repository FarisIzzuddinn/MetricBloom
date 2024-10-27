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
        background-color: #f8f9fa;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 16px;
        color: #495057;
    }

    .table tbody tr {
        border-bottom: 1px solid #dee2e6;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .table tbody tr:hover {
        background-color: #f1f3f5;
        transform: translateY(-2px);
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
    }

    /* Butang Gaya Konsisten */
    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 0.875rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
        background-color: #e3342f;
        border-color: #e3342f;
    }

    .badge-admin {
        background-color: #f5a623;
        color: rgb(0, 0, 0);
    }

    .badge-superadmin {
        background-color: #da58da;
        color: rgb(0, 0, 0);
    }

    .badge-user {
        background-color: #1acfc9;
        color: rgb(3, 0, 0);
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
        color: #343a40;
        margin-bottom: 16px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .modal-content {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px; /* Radius untuk sudut modal */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2), 0 8px 40px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
}

.modal-content:hover {
    transform: translateY(-10px); /* Angkat modal sedikit ke atas apabila hover */
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3), 0 16px 40px rgba(0, 0, 0, 0.2); /* Bayangan lebih dalam */
}
</style>

<div class="">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                                <button type="button" class="btn btn-success edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editModal" data-permission-id="{{ $permission->id }}"
                                    data-permission-name="{{ $permission->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </button>

                                <button type="button" class="btn btn-danger delete-btn"
                                    data-permission-id="{{ $permission->id }}"
                                    data-permission-name="{{ $permission->name }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
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
                <span id="deletePermissionName" style="font-weight: bold;"></span>
            </div>
            <div class="modal-footer justify-content-center red-background">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
                </button>
                <form method="POST" action="" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                    </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>




        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const permissionId = this.getAttribute('data-permission-id');
            const permissionName = this.getAttribute('data-permission-name');

            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/permissions/${permissionId}`;
            document.getElementById('deletePermissionName').textContent = permissionName;
        });
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const permissionId = this.getAttribute('data-permission-id');
            const permissionName = this.getAttribute('data-permission-name');

            const editForm = document.getElementById('editForm');
            editForm.action = `/permissions/${permissionId}`;
            document.getElementById('editPermissionName').value = permissionName;
        });
    });
</script>

@endsection
