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
                    <h4 class="mb-0" style="font-size: 3rem;">Teras</h4>
                    <a href="{{ url('teras/create') }}" class="btn btn-danger float-end mb-3">Add Teras</a>
                </div>                
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TERAS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teras as $index => $teras)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $teras->teras }}</td>
                            <td>
                                <a href="{{ url('teras/'.$teras->id.'/edit') }}" class="btn btn-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>Edit
                                </a>
                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteModal('{{ $teras->teras }}', '{{ url('teras/'.$teras->id.'/delete') }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" fill="currentColor" class="bi bi-trash me-2" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal confirmation for delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete the permission</p>
                <b><span id="delete-item-name" style="font-weight: bold; text-transform: uppercase;"></span></b>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:blue;">Cancel</button>
                <a href="#" id="delete-confirm-btn" class="btn btn-danger" style="background:red;">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    function setDeleteModal(name, url) {
        document.getElementById('delete-item-name').innerText = name;
        document.getElementById('delete-confirm-btn').setAttribute('href', url);
    }
</script>

@endsection
