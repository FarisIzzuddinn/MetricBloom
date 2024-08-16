@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')

<link rel="stylesheet" href="{{ asset('css/superAdminRoles.css') }}">

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h4>Roles
                    <a href="{{ url('roles/create') }}" class="btn btn-danger float-end">Add Role</a>
                </h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ url('roles/'.$role->id.'/give-permission') }}" class="btn btn-success">Add / Edit Role Permission</a>
                                <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div> 

@endsection
