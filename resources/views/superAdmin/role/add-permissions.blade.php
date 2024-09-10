<a href="{{ url('roles/'.$role->id.'/give-permission') }}}" data-bs-toggle="modal" data-bs-target="#permissionModal-{{ $role->id }}" class="text-decoration-none">Add Permissions</a>


<div class="modal fade" id="permissionModal-{{ $role->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('roles/'.$role->id.'/give-permission') }}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Permissions to {{ $role->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach($permissions as $permission)
                        <div class="col-md-4">
                            <label>
                                <input type="checkbox" name="permission[]" value="{{ $permission->name }}"
                                {{ in_array($permission->id, $rolePermissions) ? 'checked': '' }}>
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>