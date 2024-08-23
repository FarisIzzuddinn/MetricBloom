{{-- <link rel="stylesheet" href="{{ asset('css/superAdminRoles.css') }}"> --}}

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
    .table tbody tr:last-child td:last-child {
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <h4>Roles
                    <a href="{{ url('roles/create') }}" class="btn btn-danger float-end mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        Add Role
                    </a>
                </h4>
            </div>

         
                <div class="card-body">
                    <table class="table ">
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
                                <!-- Butang Delete dalam jadual -->
                                <td>
                                    <a href="{{ url('roles/'.$role->id.'/give-permission') }}" class="btn btn-success">Add / Edit Role Permission</a>
                                    <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                    <!-- Butang Delete dengan data-bs-toggle dan data-bs-target -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">Delete</button>
    
                                    <!-- Modal Dinamik untuk Roles -->
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
                                                    <button style="background:blue;"type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                                                    <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger">DELETE</a>
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

            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-column align-items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                            <h5 class="modal-title mb-0" id="deleteModalLabel">Confirm Deletion</h5>
                        </div>
                        <div class="modal-body text-center">
                            <p>Are you sure you want to delete the permission</p>
                            <b><span id="permissionName" style="font-weight: bold; text-transform: uppercase;"></span></b>?
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
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var permissionId = button.getAttribute('data-permission-id');
            var permissionName = button.getAttribute('data-permission-name');
            var form = document.getElementById('deleteForm');
            var nameSpan = document.getElementById('permissionName');
            
            form.action = '/permissions/' + permissionId;
            nameSpan.textContent = permissionName;
        });
    });
</script>

@endsection




