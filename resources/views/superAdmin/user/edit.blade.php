@extends('layoutNoName')
@section('title', 'Dashboard')
@section('content')

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Edit User
                    <a href="{{ url('users') }}" class="btn btn-danger float-end">back</a>
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ url('users/'.$user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" >
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="text" name="email" readonly value="{{ $user->email }}" class="form-control">
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
                                <option value="{{ $role }}" {{ in_array($role, $userRoles) ? "selected" : "" }} >{{ $role }}</option>
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
                                <option value="{{ $state->id }}" {{ $user->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="institution-container" style="display: none;">
                        <label for="institutions_id">Select Institution: (Assign as Institution Admin):</label>
                        <select name="institutions_id" id="institutions_id" class="form-control">
                            <option value="">Select Institution</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}" {{ $user->institutions_id == $institution->id ? 'selected' : '' }}>{{ $institution->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>   

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rolesSelect = document.getElementById('roles');
        const stateContainer = document.getElementById('state-container');
        const institutionContainer = document.getElementById('institution-container');
        const stateSelect = document.getElementById('state_id');
        const institutionSelect = document.getElementById('institutions_id');

        // Function to check selected roles
        function checkRoles() {
            const selectedRoles = Array.from(rolesSelect.selectedOptions).map(option => option.value);

            // Show the state container if 'Admin State' is selected
            stateContainer.style.display = selectedRoles.includes('Admin State') ? 'block' : 'none';

            // Show both containers if 'Institution Admin' is selected
            if (selectedRoles.includes('Institution Admin')) {
                stateContainer.style.display = 'block'; // Also show the state container
                institutionContainer.style.display = 'block'; // Show the institution container
            } else {
                institutionContainer.style.display = 'none'; // Hide the institution container
            }

            // Clear selections if hidden
            if (!selectedRoles.includes('Admin State')) {
                stateSelect.value = "";
                institutionSelect.innerHTML = ''; // Clear institution options
            }
            if (!selectedRoles.includes('Institution Admin')) {
                institutionSelect.value = "";
            }
        }

        // Function to fetch institutions based on selected state
        function fetchInstitutions(stateId) {
            fetch(`/get-institutions/${stateId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear the current options
                    institutionSelect.innerHTML = '<option value="">Choose an institution</option>';
                    // Populate with new options
                    data.forEach(institution => {
                        const option = document.createElement('option');
                        option.value = institution.id;
                        option.textContent = institution.name;
                        institutionSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching institutions:', error));
        }

        // Listen for changes in the state select box
        stateSelect.addEventListener('change', function() {
            const selectedStateId = this.value;
            if (selectedStateId) {
                fetchInstitutions(selectedStateId);
            } else {
                // Clear the institution select if no state is selected
                institutionSelect.innerHTML = '<option value="">Choose an institution</option>';
            }
        });

        // Initial check on page load
        checkRoles();

        // Listen for changes in the roles select box
        rolesSelect.addEventListener('change', checkRoles);
    });
</script>


@endsection
