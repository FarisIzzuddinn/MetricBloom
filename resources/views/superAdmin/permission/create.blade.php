@extends('layoutNoName')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Create Permissions
                    <a href="{{ url('permissions') }}" class="btn btn-danger float-end">back</a>
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ url('permissions') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="">Permissions Name</label>
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


