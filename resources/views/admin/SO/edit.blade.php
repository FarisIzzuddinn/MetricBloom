@extends('layoutNoName')
@section('title', 'Dashboard')
@section('content')

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Edit SO
                    <a href="{{ url('so') }}" class="btn btn-danger float-end">back</a>
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ url('so/'.$so->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="">SO Name</label>
                        <input type="text" name="SO" value="{{ $so->SO }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>   

@endsection



