

@extends('layout')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row">
     
        <div class="container-fluid">
            <h3 class="fw-bold fs-4 ms-2 mb-3">Create Roles
                <a href="{{ url('roles') }}" class="btn btn-danger float-end">back</a>
            </h3>
        </div>
        </div>

            <div class="card-body">
                <form action="{{ url('roles') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="">Roles Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection




