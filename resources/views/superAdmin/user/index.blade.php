{{-- Link for Pagination --}}
<!-- DataTable Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTable Bootstrap 5 JS -->



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
    @if(session('status'))
        <div id="alert-message" class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert">
            {{ session('status') }}
        </div>

        <script>
            setTimeout(function() {
                let alert = document.getElementById('alert-message');
                if(alert){
                    alert.classList.add('fade-out'); // Start fade-out effect
                    setTimeout(() => alert.remove(), 500); // Remove after fade-out completes
                }
            }, 2000);
        </script>
    @endif

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

    {{-- add modal  --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ url('users') }}" method="POST">
                        @csrf

                        {{-- Username --}}
                        <x-floating-form id="addUsername" name="name" type="text" placeholder="Full Name"/> 

                        {{-- email --}}
                        <x-floating-form id="addEmail" name="email" type="email" placeholder="Email Address"/>

                        {{-- password  --}}
                        <x-floating-form id="addPassword" name="password" type="password" placeholder="Password"/>
                     
                        {{-- roles  --}}
                        <x-select-dropdown id="addRole" name="roles" :options="$roles" label="Role"/>
                    
                        {{-- state  --}}
                        <x-select-dropdown-none id="state-container" name="state_id" style="display: none" :options="$states" label="State"/>

                        {{-- institution  --}}
                        <x-select-dropdown-none id="institution-container" name="institution_id" style="display: none" :options="$institutions" label="Institution"/>

                        <div class="mb-3" id="sector-container" style="display: none;">
                            <label for="sector_id">Select Sector:</label>
                            <select name="sector_id" id="sector_id" class="form-control">
                                <option value="">Select Sector</option>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="bahagian-container" style="display: none;">
                            <label for="bahagian_id">Select bahagian:</label>
                            <select name="bahagian_id" id="bahagian_id" class="form-control">
                                <option value="">Select bahagian</option>
                                @foreach($bahagians as $bahagian)
                                    <option value="{{ $bahagian->id }}">{{ $bahagian->nama_bahagian }}</option>
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
                        @include('superAdmin.user.edit')
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

<div>
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
            pageLength: 5,
            lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, 'All']],
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

     // Initialize function and get id based on container and input form for "Add User"
    const rolesSelect = document.getElementById('addRole'); // Role dropdown
    const stateContainer = document.getElementById('state-container'); // State container
    const institutionContainer = document.getElementById('institution-container'); // Institution container
    const sectorContainer = document.getElementById('sector-container'); // Sector container
    const bahagianContainer = document.getElementById('bahagian-container'); // Bahagian container
    const stateSelect = stateContainer.querySelector('select'); // State select
    const institutionSelect = institutionContainer.querySelector('select'); // Institution select
    const sectorSelect = document.getElementById('sector_id'); // Sector select
    const bahagianSelect = document.getElementById('bahagian_id'); // Bahagian select

    // Function to show/hide related containers based on the selected roles for Add User
    const checkRolesAdd = () => {
        const selectedRoles = Array.from(rolesSelect.selectedOptions).map(option => option.value);

        // Show or hide State dropdown
        if (selectedRoles.includes('Admin State')) {
            stateContainer.style.display = 'block';
            stateSelect.setAttribute('required', 'required');
        } else {
            stateContainer.style.display = 'none';
            stateSelect.removeAttribute('required');
            stateSelect.value = ""; 
        }

        // Show or hide Institution dropdown
        if (selectedRoles.includes('Institution Admin')) {
            institutionContainer.style.display = 'block';
            institutionSelect.setAttribute('required', 'required');
        } else {
            institutionContainer.style.display = 'none';
            institutionSelect.removeAttribute('required');
            institutionSelect.value = ""; 
        }

        // Show or hide Sector dropdown
        if (selectedRoles.includes('Admin Sector')) {
            sectorContainer.style.display = 'block';
            sectorSelect.setAttribute('required', 'required');
        } else {
            sectorContainer.style.display = 'none';
            sectorSelect.removeAttribute('required');
            sectorSelect.value = ""; 
        }

        // Show or hide Bahagian dropdown
        if (selectedRoles.includes('Admin Bahagian')) {
            bahagianContainer.style.display = 'block';
            bahagianSelect.setAttribute('required', 'required');
        } else {
            bahagianContainer.style.display = 'none';
            bahagianSelect.removeAttribute('required');
            bahagianSelect.value = ""; 
        }
    };

    // Trigger the function when roles change for "Add User"
    rolesSelect.addEventListener('change', checkRolesAdd);

    // Run on page load to set initial visibility for "Add User"
    checkRolesAdd();

    // Function to show/hide related containers based on the selected roles for Edit User
    const checkRolesEdit = (rolesSelect, stateContainer, institutionContainer, sectorContainer, bahagianContainer) => {
        const selectedRoles = Array.from(rolesSelect.selectedOptions).map(option => option.value);

        // Show or hide State dropdown
        const stateSelect = stateContainer.querySelector('select');
        if (selectedRoles.includes('Admin State')) {
            stateContainer.style.display = 'block';
            stateSelect.setAttribute('required', 'required');
        } else {
            stateContainer.style.display = 'none';
            stateSelect.removeAttribute('required');
            stateSelect.value = "";
        }

        // Show or hide Institution dropdown
        const institutionSelect = institutionContainer.querySelector('select');
        if (selectedRoles.includes('Institution Admin')) {
            institutionContainer.style.display = 'block';
            institutionSelect.setAttribute('required', 'required');
        } else {
            institutionContainer.style.display = 'none';
            institutionSelect.removeAttribute('required');
            institutionSelect.value = "";
        }

        // Show or hide Sector dropdown
        const sectorSelect = sectorContainer.querySelector('select');
        if (selectedRoles.includes('Admin Sector')) {
            sectorContainer.style.display = 'block';
            sectorSelect.setAttribute('required', 'required');
        } else {
            sectorContainer.style.display = 'none';
            sectorSelect.removeAttribute('required');
            sectorSelect.value = "";
        }

        // Show or hide Bahagian dropdown
        const bahagianSelect = bahagianContainer.querySelector('select');
        if (selectedRoles.includes('Admin Bahagian')) {
            bahagianContainer.style.display = 'block';
            bahagianSelect.setAttribute('required', 'required');
        } else {
            bahagianContainer.style.display = 'none';
            bahagianSelect.removeAttribute('required');
            bahagianSelect.value = "";
        }
    };

    // Trigger the function when roles change for "Edit User"
    const editRolesSelect = document.getElementById('editRole');
    const editStateContainer = document.getElementById('editStateContainer');
    const editInstitutionContainer = document.getElementById('editInstitutionContainer');
    const editSectorContainer = document.getElementById('editSectorContainer');
    const editBahagianContainer = document.getElementById('editBahagianContainer');

    editRolesSelect.addEventListener('change', () => checkRolesEdit(editRolesSelect, editStateContainer, editInstitutionContainer, editSectorContainer, editBahagianContainer));

    // Populate the modal with data on open (for editing a user)
    const editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const userId = button.getAttribute('data-user-id');
        const userName = button.getAttribute('data-user-name');
        const userEmail = button.getAttribute('data-user-email');
        const userRoles = button.getAttribute('data-user-roles').split(',');
        const userStateId = button.getAttribute('data-user-state-id');
        const userInstitutionId = button.getAttribute('data-user-institution-id');
        const userSectorId = button.getAttribute('data-user-sector-id');
        const userBahagianId = button.getAttribute('data-user-bahagian-id');

        const formActionUrl = '/users/' + userId;
        document.getElementById('editUserForm').action = formActionUrl;
        console.log("User ID:", userId);
        console.log("Form Action:", formActionUrl);
        console.log('User Details:');
        console.log('User Name:', userName);
        console.log('User Email:', userEmail);
        console.log('User Roles:', userRoles);
        console.log('State ID:', userStateId);
        console.log('Institution ID:', userInstitutionId);
        console.log('Sector ID:', userSectorId);
        console.log('Bahagian ID:', userBahagianId);

        // Populate modal fields with user data
        document.getElementById('editUserId').value = userId;
        document.getElementById('editUsername').value = userName;
        document.getElementById('editEmail').value = userEmail;
        document.getElementById('editPassword').value = ''; // Reset password field (or keep empty)

        // Populate roles (this will need to handle multi-select or checkbox inputs)
        userRoles.forEach(role => {
            const roleOption = document.querySelector(`#editRole option[value="${role}"]`);
            if (roleOption) roleOption.selected = true;
        });

        // Populate state, institution, sector, bahagian (if applicable)
        if (userStateId) {
            const stateSelect = document.getElementById('editStateContainer').querySelector('select');
            stateSelect.value = userStateId;
        }

        if (userInstitutionId) {
            const institutionSelect = document.getElementById('editInstitutionContainer').querySelector('select');
            institutionSelect.value = userInstitutionId;
        }

        if (userSectorId) {
            const sectorSelect = document.getElementById('editSectorContainer').querySelector('select');
            sectorSelect.value = userSectorId;
        }

        if (userBahagianId) {
            const bahagianSelect = document.getElementById('editBahagianContainer').querySelector('select');
            bahagianSelect.value = userBahagianId;
        }

        // Trigger checkRoles to show/hide related fields based on the selected roles
        checkRolesEdit(editRolesSelect, editStateContainer, editInstitutionContainer, editSectorContainer, editBahagianContainer);
    });

});

</script>

@endsection
