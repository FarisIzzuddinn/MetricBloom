<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-id="{{ $user->id }}">Edit</button>


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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal edit
       
    });
</script>