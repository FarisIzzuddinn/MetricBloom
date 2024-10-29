{{-- Link for Pagination --}}
<!-- DataTable Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTable Bootstrap 5 JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTable Buttons Extension -->
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}


@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    .table {
        width: 100%;
        border-collapse: collapse;
        background-color: #f9f9f9;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 0;
        border-radius: 12px; /* Rounded corners for the table */
        overflow: hidden; /* Ensures corners are rounded */
    }

    .table thead {
        background-color: #007bff; /* Header background color */
        color: #fff; /* White text for header */
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table thead th {
        padding: 12px 15px;
    }

    /* Corner Radius for Header */
    .table th:first-child {
        border-top-left-radius: 12px;
    }

    .table th:last-child {
        border-top-right-radius: 12px;
    }

    .table tbody tr {
        border-bottom: 1px solid #e1e1e1;
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #e9ecef; /* Slightly darker grey on hover */
    }

    .table tbody td {
        padding: 12px 15px;
        position: relative; /* Required for shadow effect */
    }

    /* Corner Radius for Bottom Row */
    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-top: 1rem;
        gap: 10px;
    }

    .dataTables_info {
        margin: 0;
        padding: 0;
        flex-shrink: 0;
    }

    .dataTables_paginate {
        margin: 0;
        padding: 0;
        display: flex;
        gap: 5px;
        justify-content: flex-end;
        align-items: center;
    }

    #myTable_filter {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pagination-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }

    .sticky-header {
        background-color: #f8f9fa; /* Light background */
        padding: 10px;
        position: sticky;
        top: 0;
        z-index: 1000; /* Ensure it stays above other elements */
        border-bottom: 1px solid #ddd; /* Optional: Adds a subtle border */
    }
</style>

<div class="container-fluid">
    <div class="head-title">
        <div class="left">
            <h1>User Management</h1>
            <ul class="breadcrumb">
                <li><a href="#">User Management</a></li>
            </ul>
        </div>
    </div>
   
    <!-- {{-- add new user button --}} -->
<a href="#" class="btn btn-primary ms-0 mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus me-2" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
    </svg>Add user
</a>

<!-- {{-- Modal --}} -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ url('users') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" id="editUserName" class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" id="editUserEmail"  class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Password</label>
                        <input type="text" name="password" class="form-control">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Roles</label>
                        <select multiple name="roles[]" id="roles" class="form-control" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3" id="state-container" style="display: none;">
                        <label for="state_id">Select State: (Assign as Admin State):</label>
                        <select name="state_id" id="state_id" class="form-control">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="institution-container" style="display: none;">
                        <label for="institutions_id">Select Institution: (Assign as Institution Admin):</label>
                        <select name="institutions_id" id="institutions_id" class="form-control">
                            <option value="">Select Institution</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="sector-container" style="display: none;">
                        <label for="sector_id">Select Sector:</label>
                        <select name="sector_id" id="sector_id" class="form-control">
                            <option value="">Select Sector</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Save</button> 
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

   
    <div class="table-responsive">
        <table id="myTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->getRoleNames() as $role)
                            <span class="badge bg-primary mx-1">{{ $role }}</span>
                        @endforeach
                    </td>
                    <td>
                        @include("superAdmin.user.edit")
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                        </button>
                    </td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


          <!-- Modal for Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                <h5 class="modal-title mb-0" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p id="deleteMessage">Are you sure you want to delete this user?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
                </button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
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


            <!-- Modal for Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="editUserName" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input type="text" name="email" id="editUserEmail" readonly class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="">Password (leave blank to keep current password):</label>
                                    <input type="text" name="password" class="form-control">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="">Roles</label>
                                    <select multiple name="roles[]" id="roles" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}">{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3" id="state-container" style="display: none;">
                                    <label for="state_id">Select State: (Assign as Admin State):</label>
                                    <select name="state_id" id="state_id" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3" id="institution-container" style="display: none;">
                                    <label for="institutions_id">Select Institution: (Assign as Institution Admin):</label>
                                    <select name="institutions_id" id="institutions_id" class="form-control">
                                        <option value="">Select Institution</option>
                                        @foreach($institutions as $institution)
                                            <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3" id="sector-container" style="display: none;">
                                    <label for="sector_id">Select Sector:</label>
                                    <select name="sector_id" id="sector_id" class="form-control">
                                        <option value="">Select Sector</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


    <div class="pagination-container">
        <div id="myTable_info" class="dataTables_info"></div>
        <div id="myTable_paginate" class="dataTables_paginate paging_simple_numbers"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            responsive: true,
            fixedHeader: true,
            fixedColumns: true,
            pageLength: 10,
            lengthMenu: [[10, 20, 50, -1], [5, 10, 20, 50, 'All']],
            pagingType: 'full_numbers',

            dom: 
            // "<'row'<'col-sm-12 mb-2'B>>" + // Buttons in a full-width row
            "<'row'<'col-sm-6'l><'col-sm-6'f>>" + // Length menu and search input
            "<'row'<'col-sm-12'tr>>" + // Table
            "<'row'<'col-sm-5'i><'col-sm-7'p>>", // Info and pagination
            
            buttons: ['excel', 'pdf', 'print'],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search users..."
            }
        });

        // Add role dropdown beside the search input
        $('#myTable_filter').append(`
            <select name="role" id="roleFilter" class="form-control form-control-sm ms-2">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        `);

        // Submit the form when the role is changed
        $('#roleFilter').on('change', function() {
            var selectedRole = $(this).val(); // Get the selected role
            table.column(2) // Assuming the role is in the third column (index 2)
                .search(selectedRole) // Use DataTable's built-in search for the specific column
                .draw(); // Redraw the table with the filtered data
        });

        // Setup delete modal
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var userName = button.getAttribute('data-user-name'); // Extract info from data-* attributes
            var userId = button.getAttribute('data-user-id');

            var modalMessage = deleteModal.querySelector('#deleteMessage');
            var form = deleteModal.querySelector('#deleteForm');

            // Kemas kini mesej modal dengan nama pengguna yang betul
            modalMessage.innerHTML = 'Are you sure you want to delete user <strong>' + userName + '</strong>?';
            form.action = '{{ url('users') }}/' + userId;
        });

        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var userName = button.getAttribute('data-user-name'); // Extract info from data-* attributes
            var userEmail = button.getAttribute('data-user-email');
            var userId = button.getAttribute('data-user-id');

            var form = editModal.querySelector('#editForm');
            var userNameInput = editModal.querySelector('#editUserName');
            var userEmailInput = editModal.querySelector('#editUserEmail');

            // Kemas kini borang modal dengan nama dan email pengguna yang betul
            userNameInput.value = userName;
            userEmailInput.value = userEmail;
            form.action = '{{ url('users') }}/' + userId;

            // Periksa peranan dan kemas kini elemen yang sesuai
            checkRoles();
        });

        // Inisialisasi fungsi untuk kontrol pemilihan peranan dan elemen yang ditunjukkan
        const rolesSelect = document.getElementById('roles');
        const stateContainer = document.getElementById('state-container');
        const institutionContainer = document.getElementById('institution-container');
        const sectorContainer = document.getElementById('sector-container');
        const stateSelect = document.getElementById('state_id');
        const institutionSelect = document.getElementById('institutions_id');
        const sectorSelect = document.getElementById('sector_id');

        // Fungsi untuk periksa peranan yang dipilih dan kontrol tampilan field
        function checkRoles() {
            const selectedRoles = Array.from(rolesSelect.selectedOptions).map(option => option.value);

            // Tampilkan field berdasarkan pemilihan peranan
            if (selectedRoles.includes('user')) {
                stateContainer.style.display = 'block';
                institutionContainer.style.display = 'block';
                sectorContainer.style.display = 'block';
            } else {
                stateContainer.style.display = 'none';
                institutionContainer.style.display = 'none';
                sectorContainer.style.display = 'none';

                stateSelect.value = "";
                institutionSelect.value = "";
                sectorSelect.value = "";
            }

            if (selectedRoles.includes('Admin State')) {
                stateContainer.style.display = 'block';
            }

            if (selectedRoles.includes('Institution Admin')) {
                stateContainer.style.display = 'block';
                institutionContainer.style.display = 'block';
            }
        }

        // Fungsi untuk ambil institusi berdasarkan state yang dipilih
        function fetchInstitutions(stateId) {
            fetch(`/get-institutions/${stateId}`)
                .then(response => response.json())
                .then(data => {
                    institutionSelect.innerHTML = '<option value="">Choose an institution</option>';
                    data.forEach(institution => {
                        const option = document.createElement('option');
                        option.value = institution.id;
                        option.textContent = institution.name;
                        institutionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching institutions:', error));
        }

        // Dengarkan perubahan di select box state
        stateSelect.addEventListener('change', function() {
            const selectedStateId = this.value;
            if (selectedStateId) {
                fetchInstitutions(selectedStateId);
            } else {
                institutionSelect.innerHTML = '<option value="">Choose an institution</option>';
            }
        });

        // Awal periksa di muat halaman
        checkRoles();

        // Dengarkan perubahan di select box peranan
        rolesSelect.addEventListener('change', checkRoles);
    });
</script>

@endsection
