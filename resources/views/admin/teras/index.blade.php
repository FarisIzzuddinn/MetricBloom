@extends('layout')
@section('title', 'Dashboard')
@section('body')

@include('sidebar')

<style>

    .main {
        margin-left: 300px; 
        margin-right: 20px; 
        padding: 20px;
    }

    .table-bordered {
        border: 2px solid #1c1c1c; /* Thicker border */
        border-radius: 0.375rem; /* Adjust radius as needed */
        overflow: hidden; /* Ensures border-radius affects table corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #1c1c1c; /* Thicker border for cells */
    }
</style>

<div class="container">
    <div class="main">
        <main class="content px-2 py-4">
            <div class="container-fluid">
                <h4>Teras
                    <a href="{{ url('teras/create') }}" class="btn btn-danger float-end mb-3">Add Teras</a>
                </h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
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
                                <a href="{{ url('teras/'.$teras->id.'/edit') }}" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>Edit</a>
                                <a href="{{ url('teras/'.$teras->id.'/delete') }}" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>   

