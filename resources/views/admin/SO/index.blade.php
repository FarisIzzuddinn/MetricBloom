@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h4>SO
                    <a href="{{ url('so/create') }}" class="btn btn-danger float-end mb-3">Add SO </a>
                </h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>SO</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($so as $so)
                        <tr>
                            <td>{{ $so->id }}</td>
                            <td>{{ $so->SO }}</td>
                            <td>
                                <a href="{{ url('so/'.$so->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{ url('so/'.$so->id.'/delete') }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>   

