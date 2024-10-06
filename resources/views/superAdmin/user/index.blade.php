<link rel="stylesheet" href="{{ asset('css/superAdminRoles.css') }}">

{{-- Link untuk pagination --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>

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
    .cont {
        position: sticky;
    }
</style>

<div class="container">
    <div class="row">
        <div class="cont sticky-top container-fluid">
            <h4>Staff Directory</h4>
            <!-- Search Bar and Select Role -->
            <div class="action-bar d-flex justify-content-between align-items-center mb-3">
                <form id="searchForm" action="{{ url('users') }}" method="GET" class="d-flex align-items-center">
                    <!-- Select Role Dropdown -->
                    <select name="role" class="form-control me-2" style="width: 200px;">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
    
                    <!-- Search Bar -->
                    <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}" style="width: 200px;">
                </form>
            </div>
        </div>
        <div class="col-lg-12">

            <div class="card-body">
                <table id="myTable" class="table">
                    <thead>
                        <tr class="table-secondary">
                            <th>NO</th>
                            <th>Name</th>
                            <th>Email</th>
                          
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                         
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $rolename)
                                        <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header d-flex flex-column align-items-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                            <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p id="deleteMessage">Are you sure you want to delete this user?</p>
                        </div>
                        <div class="modal-footer">
                            <form id="deleteForm" action="" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:blue;">CANCEL</button>
                                <button type="submit" class="btn btn-danger" style="background:red;">DELETE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#myTable').DataTable({
            layout: {
                topEnd: null,
            },
            lengthMenu: [
                [10, 20, 30, 50, -1],
                [10, 20, 30, 50, 'All']
            ]
        });

        // Fungsi untuk auto-submit apabila peranan dipilih atau teks dimasukkan
        $('select[name="role"], input[name="search"]').on('change keyup', function() {
            $('#searchForm').submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var userName = button.getAttribute('data-user-name'); // Extract info from data-* attributes
            var userId = button.getAttribute('data-user-id');

            var modalMessage = deleteModal.querySelector('#deleteMessage');
            var form = deleteModal.querySelector('#deleteForm');

            // Kemas kini mesej modal dengan nama pengguna yang betul
            modalMessage.innerHTML = 'Are you sure you want to delete user <strong>' + userName + '</strong>?';
            // Betulkan action URL pada form
            form.action = '{{ url('users') }}/' + userId;
        });
    });
</script>

@endsection
