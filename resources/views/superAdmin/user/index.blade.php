@extends('layout')
@section('content')

<link rel="stylesheet" href="{{ url('css/content-layout.css') }}">

<div class="container-fluid">
    <div class="dashboard-header">
        <div class="d-flex align-items-center justify-content-between">
            <x-dashboard-title title="Pengurusan Pengguna" />
            @include('superAdmin.user.create')
        </div>
    </div>

    <div class="filter-section mb-4">
        <div class="row d-flex align-items-center">
            <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Carian Nama Atau Alamat E-Mel...">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 mb-2 mb-md-0">
                <select class="form-select" id="roleFilter">    
                    <option value="">Semua Peranan</option>
                    @foreach($roles as $id => $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12 d-md-block d-none">
                <button id="resetFilters" class="btn btn-outline-secondary w-100">Set Semula</button>
            </div>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView" class="card-body">
        <div class="table-responsive">
            <table class="table" id="usersTable">
                <thead>
                    <tr class="table-secondary">
                        <th>Bil.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peranan</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="user-row">
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td data-name="{{ $user->name }}">{{ $user->name }}</td>
                            <td data-email="{{ $user->email }}">{{ $user->email }}</td>
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    <span class="badge bg-primary mx-1" data-role="{{ $role }}">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-user-email="{{ $user->email }}"
                                            data-user-roles="{{ implode(',', $user->roles->pluck('name')->toArray()) }}"
                                            data-user-state-id="{{ $user->state_id ?? '' }}"
                                            data-user-institution-id="{{ $user->institution_id ?? '' }}"
                                            data-user-sector-id="{{ $user->sector_id ?? '' }}"
                                            data-user-bahagian-id="{{ $user->bahagian_id ?? '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                    </button>

                                    @include('superAdmin.user.delete')
                                </div>
                            </td>
                        </tr>   
                    @endforeach
                </tbody>

                @include('superAdmin.user.edit')
            </table>
        </div>
        <div id="emptyMessage" class="alert alert-info mt-3" style="display: none;">
            Tiada pengguna sepadan dengan kriteria carian anda.
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4 pagination-container">
        {{ $users->links() }}
    </div>
</div>

@include('toast-notification')

<script>
    $(document).ready(function() {
        // Role-based container visibility for Add User form
        const rolesSelect = document.getElementById('addRole');
        const stateContainer = document.getElementById('state-container');
        const institutionContainer = document.getElementById('institution-container');
        const sectorContainer = document.getElementById('sector-container');
        const bahagianContainer = document.getElementById('bahagian-container');

        if (rolesSelect) {
            const stateSelect = stateContainer?.querySelector('select');
            const institutionSelect = institutionContainer?.querySelector('select');
            const sectorSelect = document.getElementById('sector_id');
            const bahagianSelect = document.getElementById('bahagian_id');

            // Function to toggle container visibility based on selected roles
            const checkRolesAdd = () => {
                const selectedRoles = Array.from(rolesSelect.selectedOptions).map(option => option.value);

                // Show/hide State dropdown
                if (stateContainer && stateSelect) {
                    if (selectedRoles.includes('Admin State')) {
                        stateContainer.style.display = 'block';
                        stateSelect.setAttribute('required', 'required');
                    } else {
                        stateContainer.style.display = 'none';
                        stateSelect.removeAttribute('required');
                        stateSelect.value = "";
                    }
                }

                // Show/hide Institution dropdown
                if (institutionContainer && institutionSelect) {
                    if (selectedRoles.includes('Institution Admin')) {
                        institutionContainer.style.display = 'block';
                        institutionSelect.setAttribute('required', 'required');
                    } else {
                        institutionContainer.style.display = 'none';
                        institutionSelect.removeAttribute('required');
                        institutionSelect.value = "";
                    }
                }

                // Show/hide Sector dropdown
                if (sectorContainer && sectorSelect) {
                    if (selectedRoles.includes('Admin Sector')) {
                        sectorContainer.style.display = 'block';
                        sectorSelect.setAttribute('required', 'required');
                    } else {
                        sectorContainer.style.display = 'none';
                        sectorSelect.removeAttribute('required');
                        sectorSelect.value = "";
                    }
                }

                // Show/hide Bahagian dropdown
                if (bahagianContainer && bahagianSelect) {
                    if (selectedRoles.includes('Admin Bahagian')) {
                        bahagianContainer.style.display = 'block';
                        bahagianSelect.setAttribute('required', 'required');
                    } else {
                        bahagianContainer.style.display = 'none';
                        bahagianSelect.removeAttribute('required');
                        bahagianSelect.value = "";
                    }
                }
            };

            // Trigger role check on page load and role selection change
            checkRolesAdd();
            rolesSelect.addEventListener('change', checkRolesAdd);
        }

        // Delete modal functionality
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-permission-id');
                const userName = button.getAttribute('data-permission-name');

                document.getElementById('deleteUserName').textContent = userName;
                document.getElementById('deleteUserForm').action = '/users/' + userId;
            });
        }

        // Search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const roleFilter = document.getElementById('roleFilter');
        const resetFilters = document.getElementById('resetFilters');
        const emptyMessage = document.getElementById('emptyMessage');
        const userRows = document.querySelectorAll('.user-row');

        // Function to filter users based on search input and role selection
        function filterUsers() {
            const searchTerm = (searchInput.value || '').toLowerCase().trim();
            const selectedRole = (roleFilter.value || '').toLowerCase().trim();
            let visibleCount = 0;

            userRows.forEach(row => {
                const name = row.querySelector('td[data-name]').getAttribute('data-name').toLowerCase();
                const email = row.querySelector('td[data-email]').getAttribute('data-email').toLowerCase();
                const roleBadges = row.querySelectorAll('span[data-role]');
                
                // Get all roles for this user
                const userRoles = Array.from(roleBadges).map(badge => 
                    badge.getAttribute('data-role').toLowerCase()
                );

                // Determine if row matches search criteria
                const matchesSearch = searchTerm === '' || 
                                     name.includes(searchTerm) || 
                                     email.includes(searchTerm);
                
                // Determine if row matches role filter
                const matchesRole = selectedRole === '' || 
                                   userRoles.some(role => role.includes(selectedRole));
                
                // Show or hide row based on filters
                if (matchesSearch && matchesRole) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show/hide empty message
            emptyMessage.style.display = visibleCount === 0 ? 'block' : 'none';
            
            // Update pagination info
            updatePaginationInfo(visibleCount);
        }

        // Function to update pagination information
        function updatePaginationInfo(count) {
            const infoElement = document.getElementById('myTable_info');
            if (infoElement) {
                infoElement.textContent = `Showing ${count} of ${userRows.length} users`;
            }
        }

        // Initialize pagination info
        updatePaginationInfo(userRows.length);

        // Event listeners for search and filter
        searchButton.addEventListener('click', function() {
            filterUsers();
        });
        
        searchInput.addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                filterUsers();
            }
        });
        
        // Important fix: Add direct event listener for role filter change
        roleFilter.addEventListener('change', function() {
            filterUsers();
        });
        
        // Reset filters
        if (resetFilters) {
            resetFilters.addEventListener('click', function() {
                console.log('Resetting filters');
                searchInput.value = '';
                roleFilter.value = '';
                filterUsers();
            });
        }

        // Initialize responsive table behavior
        const tableContainer = document.querySelector('.table-responsive');
        if (tableContainer) {
            const handleResize = () => {
                const table = tableContainer.querySelector('table');
                if (window.innerWidth < 768 && table) {
                    table.classList.add('table-sm');
                } else if (table) {
                    table.classList.remove('table-sm');
                }
            };
            
            // Run on load and resize
            handleResize();
            window.addEventListener('resize', handleResize);
        }

        // Initial filter to ensure everything works on page load
        filterUsers();
    });
</script>

@endsection