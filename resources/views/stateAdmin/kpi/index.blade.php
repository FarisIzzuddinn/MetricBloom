@extends('layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<div class="head-title">
    <div class="left">
        <h1>KPI Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('stateAdmin.dashboard') }}">KPI Management</a>
            </li>
        </ul>
    </div>
</div>

<a href="#" class="btn btn-primary mb-3" id="assignKPIButton" data-bs-toggle="modal" data-bs-target="#assignKpiModal">Assign New KPI</a>

<!-- Display Success or Error Messages -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>KPI</th>
            <th>Institutions</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kpis->unique('pernyataan_kpi') as $kpi)
        <tr>
            <td>{{ $kpi->pernyataan_kpi }}</td>
            <td>
                @if ($kpi->institutions->isNotEmpty())
                    {{ $kpi->institutions->pluck('name')->unique()->implode(', ') }}
                @else
                    No Institution Assigned
                @endif
            </td>
            <td>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-name="{{ $kpi->pernyataan_kpi }}" data-url="{{ route('admin-state-kpis.destroy', $kpi->id) }}">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Assign New KPI Modal -->
<div class="modal fade" id="assignKpiModal" tabindex="-1" aria-labelledby="assignKpiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignKpiModalLabel">Assign New KPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignKpiForm" method="POST" action="{{ route('stateAdmin.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="kpi">Select KPI:</label>
                        <select name="kpi_id" class="form-control" required>
                            @foreach($kpis as $kpi)
                                <option value="{{ $kpi->id }}">{{ $kpi->pernyataan_kpi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="institution">Select Institution:</label>
                        <select name="institution_id" class="form-control" required>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">ASSIGN KPI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Are you sure you want to delete this <strong id="modalItemName"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: blue;">CANCEL</button>
                <form method="POST" id="deleteForm" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary" style="background: red;">DELETE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk mengatur modal delete
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Tombol yang memicu modal
        var itemName = button.getAttribute('data-name'); // Ambil nama KPI dari data-name
        var modalItemName = deleteModal.querySelector('#modalItemName');
        modalItemName.textContent = itemName; // Set nama KPI di dalam modal

        // Set action URL secara dinamis
        var form = document.getElementById('deleteForm');
        form.action = button.getAttribute('data-url'); // Set URL untuk form delete
    });

   
</script>

<style>
    /* Gaya Umum */
body {
}

/* Gaya untuk jadual */
.table {
    margin-bottom: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.table th, .table td {
    padding: 15px;
    text-align: left;
}

.table th {
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #343a40; /* Warna teks header */
}

.table tbody tr {
    border-bottom: 1px solid #dee2e6;
    transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s;
}

.table tbody tr:hover {
    background-color: #f1f3f5;
    transform: translateY(-2px);
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
}

.table tbody td {
    vertical-align: middle;
}

.table tbody td:first-child {
    font-weight: bold;
}

/* Gaya untuk tajuk */
h4 {
    text-align: start;
    color: #343a40;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Gaya Butang */
.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.875rem;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease-in-out;
}

.btn-primary {
}

.btn-success {
    background-color: #38c172; /* Warna hijau */
    border-color: #38c172;
}

.btn-danger {
    background-color: #e3342f; /* Warna merah */
    border-color: #e3342f;
}

.btn:hover {
    transform: translateY(-2px);
}

/* Gaya Modal */
.modal-content {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

.modal-title {
    font-weight: bold;
    color: #495057;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

/* Responsif */
@media (max-width: 768px) {
    .table {
        width: 100%;
        overflow-x: auto;
    }
}
</style>
@endsection
