@extends('layout')
@section('title', 'Dashboard')
@section('content')

<style>
   /* Gaya untuk jadual */
.table {
    margin-bottom: 0; /* Remove margin at the bottom of the table */
    border-radius: 12px; /* Rounded corners for the table */
    overflow: hidden; /* Ensure rounded corners work */
}

.table th, .table td {
    padding: 15px; /* Padding for better spacing */
    text-align: left; /* Align text to the left */
}

.table th {

    text-transform: uppercase; /* Ubah suai huruf besar */
    letter-spacing: 0.1em; /* Jarak huruf */
    padding: 12px 16px; /* Padding untuk header */
}

.table tbody tr {
    border-bottom: 1px solid #dee2e6; /* Light grey border */
    transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s; /* Smooth transition for hover */
}

.table tbody tr:hover {
    background-color: #f1f3f5; /* Light gray background on hover */
    transform: translateY(-2px); /* Kesan angkat */
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan lebih ketara pada hover */
}

.table tbody td {
    padding: 12px 16px; /* Padding untuk sel */
    vertical-align: middle; /* Pusatkan vertikal */
    transition: all 0.2s ease; /* Transisi untuk kesan hover */
}

.table tbody td:first-child {
    font-weight: bold; /* Tebalkan teks pada kolum pertama */
}

h4 {
    text-align: start;
    color: #343a40; /* Darker color for heading */
    margin-bottom: 20px; /* Space below the heading */
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Text shadow */
}

/* Butang Gaya Konsisten */
.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.875rem;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Bayangan butang */
    transition: all 0.2s ease-in-out; /* Animation for button */
}

.btn-success {
    background-color: #38c172; /* Custom green */
    border-color: #38c172;
}

.btn-danger {
    background-color: #e3342f; /* Custom red */
    border-color: #e3342f;
}

.btn:hover {
    transform: translateY(-2px); /* Kesan angkat pada hover */
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); /* Bayangan lebih ketara pada hover */
}

/* Modal Reka Bentuk Konsisten */
.modal-content {
    border-radius: 12px; /* Rounded corners for modal */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Bayangan modal */
    background: linear-gradient(to bottom right, #ffffff, #f8f9fa); /* Gradient background */
}

.modal-header {
    border-bottom: 1px solid #dee2e6; /* Bottom border */
    background-color: #f8f9fa; /* Light grey background */
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan di bawah header modal */
}

.modal-title {
    font-weight: bold; /* Bold title */
    color: #495057; /* Dark grey color */
}

.modal-footer {
    border-top: 1px solid #dee2e6; /* Top border */
}

.btn-close {
    background: none; /* No background */
    border: none; /* No border */
}

/* Responsive styles */
@media (max-width: 768px) {
    .table {
        width: 100%; /* Table takes full width on smaller screens */
        overflow-x: auto; /* Allow horizontal scrolling */
    }
}

</style>

<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="container-fluid mt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" style="font-size: 3rem;">Sektor Operation</h4>
                    <a href="{{ url('so/create') }}" class="btn btn-primary float-end mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg> Add So</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
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
                                <a href="{{ url('so/'.$so->id.'/edit') }}" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                 </svg>
                                </a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$so->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
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
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                            </svg>
                                            </button>
                                            <a href="{{ url('so/'.$so->id.'/delete') }}" class="btn btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                            </svg>
                                            </a>
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
