



@extends('layoutNoName')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row">
     
        <div class="container-fluid">
            <h3 class="fw-bold fs-4 ms-2 mb-3">Edit Roles
                <a href="{{ url('roles') }}" class="btn btn-danger float-end">back</a>
            </h3>
        </div>
        </div>

            <div class="card-body">
                <form action="{{ url('roles/'.$role->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="">Role Name</label>
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
        </div>
    </div>
</div>



@endsection





