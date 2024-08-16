@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')
<link rel="stylesheet" href="{{ asset('css/superAdminPremissions.css') }}">
<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
        <div class="container-fluid">
                <h4>Permissions
                    <a href="{{ url('permissions/create') }}" class="btn btn-danger float-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg> ADD PERMISSIONS
                    </a>
                </h4>
            </div>
            <div class="card-body">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ url('permissions/'.$permission->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{ url('permissions/'.$permission->id.'/delete') }}" class="btn btn-danger">Delete</a>
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
