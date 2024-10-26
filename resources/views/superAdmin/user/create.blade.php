@extends('layoutNoName')
@section('title', 'Dashboard')
@section('content')



   
        <div class="content px-2 py-4">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Create User
                    <a href="{{ url('users') }}" class="btn btn-danger float-end">back</a>
                </h3>
            </div>

            <div class="card-body">
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
                   
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
  
 

<script>
     document.addEventListener('DOMContentLoaded', function () {
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

