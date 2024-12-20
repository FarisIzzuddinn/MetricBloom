<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal"
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
                    <x-floating-form id="editUsername" name="name" type="text" placeholder="Full Name" />

                    {{-- email --}}
                    <x-floating-form id="editEmail" name="email" type="email" placeholder="Email Address" />

                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="password" name=password class="form-control" id="editPassword" placeholder="Password" autocomplete="off">
                    </div>

                    {{-- roles --}}
                    <x-select-dropdown id="editRole" name="roles" :options="$roles" label="Role" />

                    {{-- state --}}
                    <x-select-dropdown-none id="editStateContainer" name="state_id" style="display: none" :options="$states" label="State" />

                    {{-- institution --}}
                    <x-select-dropdown-none id="editInstitutionContainer" name="institution_id" style="display: none" :options="$institutions" label="Institution" />

                    {{-- sector --}}
                    <div class="mb-3" id="editSectorContainer" style="display: none;">
                        <label for="editSectorId">Select Sector:</label>
                        <select name="sector_id" id="editSectorId" class="form-control">
                            <option value="">Select Sector</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- bahagian --}}
                    <div class="mb-3" id="editBahagianContainer" style="display: none;">
                        <label for="editBahagianId">Select Bahagian:</label>
                        <select name="bahagian_id" id="editBahagianId" class="form-control">
                            <option value="">Select Bahagian</option>
                            @foreach($bahagians as $bahagian)
                                <option value="{{ $bahagian->id }}">{{ $bahagian->nama_bahagian }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

