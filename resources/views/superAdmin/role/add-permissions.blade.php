@extends('layout')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="container-fluid">
            <h3 class="fw-bold fs-4 ms-2 mb-3">Roles : {{ $role->name }}
                <a href="{{ url('roles') }}" class="btn btn-danger float-end">back</a>
            </h3>
        </div>

            <div class="card-body">
                <form action="{{ url('roles/'.$role->id.'/give-permission') }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        @error('permission')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <label for="">Permissions</label>

                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-2">
                                <label >
                                    <input type="checkbox" name="permission[]" value="{{ $permission->name }}"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked': '' }}
                                    
                                    >
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection




