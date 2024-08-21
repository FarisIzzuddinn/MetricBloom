@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h4>Teras
                    <a href="{{ url('teras/create') }}" class="btn btn-danger float-end">Add Teras </a>
                </h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Teras</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teras as $teras)
                        <tr>
                            <td>{{ $teras->id }}</td>
                            <td>{{ $teras->teras }}</td>
                            <td>
                                <a href="{{ url('teras/'.$teras->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{ url('teras/'.$teras->id.'/delete') }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>   

