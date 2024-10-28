@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }


    .btn {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px); /* Angkat butang ke atas */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Tambah bayangan */
    }

    .dropdown-menu {
        position: absolute;
        z-index: 1050; /* Higher z-index to appear on top */
        top: 100%; /* Align below the button */
        right: 0; /* Align to the right */
        margin-top: 0.5rem;
        min-width: 150px;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
    }

    /* Ensure the parent container doesn’t clip the dropdown */
    .d-flex {
        position: relative;
        overflow: visible; /* Prevents overflow clipping */
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
    <div class="container-fluid mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="head-title">
                <div class="left">
                    <h1>Roles Management</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Roles Management</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Cards -->
    <div class="row">
        @foreach ($roles as $role)
            <div class="col-md-4 mb-4">
                <div class="card p-3" style="border-radius: 10px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-normal mb-0">Total users: {{ $role->users_count ?? 4 }}</h6>
                    </div>

                    <h5 class="mb-1" style="text-transform: capitalize;">{{ $role->name }}</h5>

                    <div class="d-flex justify-content-between align-items-center ">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#permissionModal-{{ $role->id }}" class="text-decoration-none">Add Permissions</a>  

                        <div class="dropdown test text-end">
                            <a href="#" class="text-dark" id="dropdownMenuButton-{{ $role->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                </svg>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $role->id }}">
                                <a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square mb-1" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg> Edit Role
                                </a>
                                <li>
                                    <a class="dropdown-item" href="#"  data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash mb-1" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg> Delete Role
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for adding permissions -->
            <div class="modal fade" id="permissionModal-{{ $role->id }}" tabindex="-1" aria-labelledby="permissionModalLabel-{{ $role->id }}" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ url('roles/'.$role->id.'/give-permission') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="permissionModalLabel-{{ $role->id }}">Assign Permissions to {{ $role->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="mb-6">Role Permissions</h5>
                                <table class="table table-borderless">
                                    <tbody>
                                        @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="permission[]" value="{{ $permission->name }}"
                                                    {{ isset($rolePermissions[$role->id]) && in_array($permission->id, $rolePermissions[$role->id]) ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>                                    
                                </table>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

             <!-- Edit Role Modal -->
            <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel{{ $role->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Role: {{ $role->name }}</h5>
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
                                <button type="submit" class="btn btn-primary">Save Changes</button>
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
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                </svg>
                <h5 class="modal-title mb-0" id="deleteModalLabel{{ $role->id }}">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete the role <strong>{{ $role->name }}</strong>?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
                </button>
                <form action="{{ url('roles/'.$role->id) }}" method="POST">
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


        @endforeach

        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
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

        <!-- Add New Role -->
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-body">
                    <p>Add new role if it doesn't exist.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus me-2" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
    </svg>Add New Role</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add event listener for clicks on modal trigger links
        document.querySelectorAll('a[data-bs-toggle="modal"]').forEach(function (link) {
            link.addEventListener('click', function () {
                var modalId = this.getAttribute('data-bs-target');
                var roleId = this.getAttribute('data-role-id'); // Ensure this attribute is set in the link

                // Perform an AJAX request to fetch the permissions data
                fetch(`/roles/${roleId}/permissions`)
                    .then(response => response.json())
                    .then(data => {
                        var modal = document.querySelector(modalId);
                        var checkboxes = modal.querySelectorAll('input[type="checkbox"]');

                        // Update checkboxes based on the fetched data
                        checkboxes.forEach(function (checkbox) {
                            checkbox.checked = data.permissions.includes(parseInt(checkbox.value));
                        });
                    });
            });
        });
    });
</script>

@endsection
