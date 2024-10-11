<link rel="stylesheet" href="{{ asset('css/superAdminRoles.css') }}">

{{-- Link untuk pagination --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>

@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    /* Konsistenkan Reka Bentuk Jadual */
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
        border: 1px solid #e1e1e1;
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

    /* Badge Styles */
    .badge {
        font-size: 0.85em;
        padding: 5px 10px;
        border-radius: 12px;
    }

    .badge-admin {
        background-color: #f5a623; /* Custom Orange */
        color: rgb(0, 0, 0);
    }

    .badge-superadmin {
        background-color: #da58da; /* Custom Red */
        color: rgb(0, 0, 0);
    }

    .badge-user {
        background-color: #1acfc9; /* Custom Green */
        color: rgb(3, 0, 0);
    }

    /* Butang Gaya Konsisten */
    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.2s; /* Tambah transform ke transisi */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Bayangan butang */
    }

    .btn-success {
        background-color: #28a745; /* Green for success */
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545; /* Red for danger */
        color: #fff;
    }

    .btn:hover {
        opacity: 0.8; /* Reduce opacity on hover */
        transform: translateY(-2px); /* Lift effect */
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* Shadow effect on hover */
    }

    .btn:active {
        transform: translateY(0); /* Kembalikan ke posisi asal ketika ditekan */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Kurangkan bayangan ketika ditekan */
    }

    /* Sticky Position */
    .cont {
        position: sticky;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .table {
            overflow-x: auto; /* Allow horizontal scrolling */
        }

        .table th, .table td {
            padding: 10px; /* Reduce padding on smaller screens */
            font-size: 0.9rem; /* Adjust font size for better readability */
        }

        .btn {
            width: 100%; /* Make buttons full width on small screens */
            margin-bottom: 10px; /* Add spacing between buttons */
        }

        .badge {
            font-size: 0.8rem; /* Adjust badge font size */
        }

        h4 {
            font-size: 2rem; /* Reduce heading size */
        }
    }
</style>


<div class="">
    <div class="row">
        <div class="cont sticky-top container-fluid">
            <h4 style="font-size: 3rem;">Staff Directory</h4>
            <div class="action-bar d-flex justify-content-between align-items-center mb-3">
                <form id="searchForm" action="{{ url('users') }}" method="GET" class="d-flex align-items-center">
                    <select name="role" class="form-control me-2" style="width: 200px;">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
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
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-id="{{ $user->id }}">Edit</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user-name="{{ $user->name }}" data-user-id="{{ $user->id }}">Delete</button>
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
        // Modal delete
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

        // Modal edit
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
