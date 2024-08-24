

@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    .table {
        margin-bottom: 0;
    }
    .table th:first-child {
        border-top-left-radius: 12px;
    }
    .table th:last-child {
        border-top-right-radius: 12px;
    }
    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }
    .table tbody tr:last-child td:last-child {
    }

    h4{
        text-align: start;
    }
</style>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid">
                <h4>SO
                    <a href="{{ url('so/create') }}" class="btn btn-danger float-end mb-3">Add SO </a>
                </h4>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr class="table-secondary">
                            <th>NO</th>
                            <th>SO</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($so  as $index => $so)
                        <tr>
                            <td>{{ $index + 1 }}</td>
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
        </div>
    </div>
</div>

@endsection



