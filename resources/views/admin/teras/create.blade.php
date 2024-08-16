@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h3 class="fw-bold fs-4 ms-2 mb-3">Create teras
                    <a href="{{ url('teras') }}" class="btn btn-danger float-end">back</a>
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ url('teras') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="teras">teras Name</label>
                        <input type="text" name="teras" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>   

@endsection

