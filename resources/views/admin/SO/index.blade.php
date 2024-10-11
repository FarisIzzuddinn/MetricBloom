@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
    /* Gaya untuk jadual */
    .table {
        margin-bottom: 0; /* Tiada margin di bawah jadual */
        border-radius: 12px; /* Sudut bulat untuk jadual */
        overflow: hidden; /* Pastikan sudut bulat berfungsi */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Kesan bayangan lembut untuk jadual */
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa); /* Latar belakang gradient */
    }

    .table th, .table td {
        padding: 15px; /* Padding untuk ruang yang lebih baik */
        text-align: left; /* Selaraskan teks ke kiri */
        position: relative; /* Untuk menggunakan pseudo-element */
        transition: all 0.3s; /* Transisi untuk hover */
    }

    .table th {
        background-color: #f8f9fa; /* Latar belakang header */
        color: #495057; /* Warna teks header */
        text-transform: uppercase; /* Ubah suai huruf besar */
        letter-spacing: 0.1em; /* Jarak huruf */
    }

    .table tbody tr {
        border-bottom: 1px solid #dee2e6; /* Garisan bawah untuk setiap baris */
        transition: background-color 0.3s; /* Transisi lembut untuk hover */
    }

    .table tbody tr:hover {
        background-color: #f1f3f5; /* Kesan hover */
        transform: translateY(-2px); /* Mengangkat baris ketika hover */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan 3D semasa hover */
    }

    .table th:first-child {
        border-top-left-radius: 12px; /* Sudut bulat untuk header pertama */
    }

    .table th:last-child {
        border-top-right-radius: 12px; /* Sudut bulat untuk header terakhir */
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px; /* Sudut bulat untuk sel terakhir */
    }

    h4 {
        text-align: start; /* Selaraskan tajuk ke kiri */
    }
</style>


<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="font-size: 3rem;">Sektor Operation</h4>
                    <a href="{{ url('so/create') }}" class="btn btn-danger float-end mb-3">Add So</a>
                </div>
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
                        @foreach($so as $index => $so)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $so->SO }}</td>
                            <td>
                                <a href="{{ url('so/'.$so->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$so->id}}">
                                    Delete
                                </button>
                            </td>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteModal{{$so->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$so->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex flex-column align-items-center text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                            </svg>
                                            <h5 class="modal-title" id="deleteModalLabel{{$so->id}}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <p>Are you sure you want to delete</p>
                                            <strong style="font-weight: bold; text-transform: uppercase;">{{ $so->SO }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: blue;">Cancel</button>
                                            <a href="{{ url('so/'.$so->id.'/delete') }}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
