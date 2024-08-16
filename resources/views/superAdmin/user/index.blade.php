@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')
<link rel="stylesheet" href="{{ asset('css/superAdminUser.css') }}">

<style>
    .action-bar {
        margin-top: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center; /* Pastikan semua item berada di tengah-tengah secara menegak */
    }

    .search-bar {
        display: flex;
        align-items: center;
    }

    .search-bar input[type="text"] {
        width: 300px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    .search-bar select {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-right: 10px;
    }

    .search-bar button {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .search-bar button svg {
        margin-right: 8px; /* Jarak antara ikon dan teks */
    }

    .search-bar button:hover {
        background-color: #0056b3;
    }

    .add-role-btn {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-decoration: none; /* Menghapuskan garis bawah pada pautan */
    }

    .add-role-btn svg {
        margin-right: 8px; /* Jarak antara ikon dan teks */
    }

    .add-role-btn:hover {
        background-color: #c82333;
    }

    .table {
        background-color: transparent; /* Menghapuskan warna latar belakang kelabu */
        border-collapse: collapse; /* Menggabungkan sempadan sel jadual */
        width: 100%; /* Opsional: memastikan jadual mengambil keseluruhan lebar yang tersedia */
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #ddd; /* Menggunakan warna sempadan yang lebih ringan */
        background-color: transparent; /* Menghapuskan warna latar belakang sel */
        text-transform: uppercase; 
    }

    .table .badge {
        font-size: 14px;
        padding: 5px 10px;
        background-color: transparent; /* Jika badge mempunyai warna latar belakang kelabu, anda boleh menukarnya */
    }

    .table .btn {
        margin-right: 5px;
    }
</style>

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h4>Users</h4>

                <!-- Search Bar and Add Role Button -->
                <div class="action-bar">
                    <form action="{{ url('users') }}" method="GET" class="search-bar">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                            Search
                        </button>
                    </form>
                    <a href="{{ url('users/create') }}" class="add-role-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                        </svg>
                        ADD ROLE
                    </a>
                </div>

            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $rolename)
                                        <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('users/'.$user->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{ url('users/'.$user->id.'/delete') }}" class="btn btn-danger">Delete</a>
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
