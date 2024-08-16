@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Edit Teras
                    <a href="{{ url('teras') }}" class="btn btn-danger float-end">Back</a>
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ url('teras/'.$teras->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="teras" class="form-label">Teras Name</label>
                        <input type="text" name="teras" id="teras" value="{{ $teras->teras }}" class="form-control">
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
