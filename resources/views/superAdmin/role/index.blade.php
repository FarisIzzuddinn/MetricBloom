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
                <h4>Roles
                    <!-- Add Role Button Trigger Modal -->
                    <button type="button" class="btn btn-danger float-end mb-2" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg> Add Role
                    </button>
                </h4>
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
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ url('roles/'.$role->id.'/give-permission') }}" class="btn btn-success">Add / Edit Role Permission</a>
                                <!-- Edit Button Trigger Modal -->
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}">Edit</button>
                                <!-- Delete Button Trigger Modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">Delete</button>

                                <!-- Edit Role Modal -->
                                <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel{{ $role->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoleModalLabel{{ $role->id }}">Edit Role</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('roles/'.$role->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="roleName" class="form-label">Role Name</label>
                                                        <input type="text" class="form-control" id="roleName" name="name" value="{{ $role->name }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Role Modal -->
                                <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex flex-column align-items-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                                </svg>
                                                <h5 class="modal-title mb-0" id="deleteModalLabel{{ $role->id }}">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p>Are you sure you want to delete the role <strong class="text-uppercase">{{ $role->name }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:blue;">Cancel</button>
                                                <form action="{{ url('roles/'.$role->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('roles') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="addRoleName" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="addRoleName" name="name" placeholder="Enter role name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Role</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
