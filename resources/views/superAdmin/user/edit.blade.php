{{-- <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editUserModal"
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
</button> --}}

{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="editUserId">

                    {{-- Username --}}
                    <x-floating-form labelName="Nama" id="editUsername" name="name" type="text" placeholder="Nama Penuh" />

                    {{-- email --}}
                    <x-floating-form labelName="Email" id="editEmail" name="email" type="email" placeholder="Alamat Email" />

                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Kata Laluan</label>
                        <input type="password" name=password class="form-control" id="editPassword" placeholder="Kata Laluan" autocomplete="off">
                    </div>

                    {{-- roles --}}
                    <x-select-dropdown id="editRole" name="roles" :options="$roles" label="Peranan" />

                    {{-- state --}}
                    <x-select-dropdown-none id="editStateContainer" name="state_id" style="display: none" :options="$states" label="Negeri" />

                    {{-- institution --}}
                    <x-select-dropdown-none id="editInstitutionContainer" name="institution_id" style="display: none" :options="$institutions" label="Institusi" />

                    {{-- sector --}}
                    <div class="mb-3" id="editSectorContainer" style="display: none;">
                        <label for="editSectorId">Sektor:</label>
                        <select name="sector_id" id="editSectorId" class="form-control">
                            <option value="">Pilih Sektor</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- bahagian --}}
                    <div class="mb-3" id="editBahagianContainer" style="display: none;">
                        <label for="editBahagianId">Bahagian:</label>
                        <select name="bahagian_id" id="editBahagianId" class="form-control">
                            <option value="">Pilih Bahagian</option>
                            @foreach($bahagians as $bahagian)
                                <option value="{{ $bahagian->id }}">{{ $bahagian->nama_bahagian }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait for the document to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Get the edit user modal element
        const editUserModal = document.getElementById('editUserModal');
        
        // Add event listener to the modal when it's about to be shown
        if (editUserModal) {
            editUserModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract user information from data attributes
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');
                const userRoles = button.getAttribute('data-user-roles');
                const userStateId = button.getAttribute('data-user-state-id');
                const userInstitutionId = button.getAttribute('data-user-institution-id');
                const userSectorId = button.getAttribute('data-user-sector-id');
                const userBahagianId = button.getAttribute('data-user-bahagian-id');
                
                // Update the modal's content
                const form = document.getElementById('editUserForm');
                form.action = `/users/${userId}`;
                
                // Set form field values
                document.getElementById('editUserId').value = userId;
                document.getElementById('editUsername').value = userName;
                document.getElementById('editEmail').value = userEmail;
                document.getElementById('editPassword').value = ''; // Clear password field
                
                // Set the role dropdown
                const roleSelect = document.getElementById('editRole');
                if (roleSelect) {
                    const rolesArray = userRoles.split(',');
                    for (let i = 0; i < roleSelect.options.length; i++) {
                        roleSelect.options[i].selected = rolesArray.includes(roleSelect.options[i].value);
                    }
                }
                
                // Show/hide and set values for conditional fields based on role
                handleRoleDependentFields(userRoles.split(','), userStateId, userInstitutionId, userSectorId, userBahagianId);
            });
            
            // Add event listener for role changes to dynamically show/hide fields
            const roleDropdown = document.getElementById('editRole');
            if (roleDropdown) {
                roleDropdown.addEventListener('change', function() {
                    const selectedRoles = Array.from(this.selectedOptions).map(option => option.value);
                    handleRoleDependentFields(selectedRoles);
                });
            }
        }
        
        // Function to handle showing/hiding fields based on roles
        function handleRoleDependentFields(selectedRoles, stateId = '', institutionId = '', sectorId = '', bahagianId = '') {
            const stateContainer = document.getElementById('editStateContainer');
            const institutionContainer = document.getElementById('editInstitutionContainer');
            const sectorContainer = document.getElementById('editSectorContainer');
            const bahagianContainer = document.getElementById('editBahagianContainer');
            
            // Get select elements
            const stateSelect = stateContainer?.querySelector('select');
            const institutionSelect = institutionContainer?.querySelector('select');
            const sectorSelect = document.getElementById('editSectorId');
            const bahagianSelect = document.getElementById('editBahagianId');
            
            // Handle State dropdown
            if (stateContainer && stateSelect) {
                if (selectedRoles.includes('Admin State')) {
                    stateContainer.style.display = 'block';
                    stateSelect.setAttribute('required', 'required');
                    if (stateId) stateSelect.value = stateId;
                } else {
                    stateContainer.style.display = 'none';
                    stateSelect.removeAttribute('required');
                    stateSelect.value = "";
                }
            }
            
            // Handle Institution dropdown
            if (institutionContainer && institutionSelect) {
                if (selectedRoles.includes('Institution Admin')) {
                    institutionContainer.style.display = 'block';
                    institutionSelect.setAttribute('required', 'required');
                    if (institutionId) institutionSelect.value = institutionId;
                } else {
                    institutionContainer.style.display = 'none';
                    institutionSelect.removeAttribute('required');
                    institutionSelect.value = "";
                }
            }
            
            // Handle Sector dropdown
            if (sectorContainer && sectorSelect) {
                if (selectedRoles.includes('Admin Sector')) {
                    sectorContainer.style.display = 'block';
                    sectorSelect.setAttribute('required', 'required');
                    if (sectorId) sectorSelect.value = sectorId;
                } else {
                    sectorContainer.style.display = 'none';
                    sectorSelect.removeAttribute('required');
                    sectorSelect.value = "";
                }
            }
            
            // Handle Bahagian dropdown
            if (bahagianContainer && bahagianSelect) {
                if (selectedRoles.includes('Admin Bahagian')) {
                    bahagianContainer.style.display = 'block';
                    bahagianSelect.setAttribute('required', 'required');
                    if (bahagianId) bahagianSelect.value = bahagianId;
                } else {
                    bahagianContainer.style.display = 'none';
                    bahagianSelect.removeAttribute('required');
                    bahagianSelect.value = "";
                }
            }
        }
        
        // Form validation before submission
        const editUserForm = document.getElementById('editUserForm');
        if (editUserForm) {
            editUserForm.addEventListener('submit', function(event) {
                const nameField = document.getElementById('editUsername');
                const emailField = document.getElementById('editEmail');
                const roleField = document.getElementById('editRole');
                
                let isValid = true;
                
                // Simple validation
                if (!nameField.value.trim()) {
                    alert('Name is required');
                    isValid = false;
                }
                
                if (!emailField.value.trim() || !emailField.value.includes('@')) {
                    alert('Valid email is required');
                    isValid = false;
                }
                
                if (!roleField.value) {
                    alert('Role selection is required');
                    isValid = false;
                }
                
                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    });
</script>
