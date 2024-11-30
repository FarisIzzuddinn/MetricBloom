@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold">KPI Management for {{ $institution->name }}</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- KPIs Table -->
    <div class="table-responsive shadow-sm rounded bg-white p-4">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Bil.</th>
                    <th>KPI</th>
                    <th>Target</th>
                    <th>Current Achievement</th>
                    <th>Percentage (%)</th>
                    <th>Dictionary</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kpis as $kpiInstitution)
                <tr>
                    <td class="fw-bold">{{ $loop->iteration }}</td>
                    <td>{{ $kpiInstitution->kpi->pernyataan_kpi ?? 'N/A' }}</td>
                    <td>{{ $kpiInstitution->kpi->sasaran ?? 'N/A' }}</td>
                    <td>{{ $kpiInstitution->pencapaian ?? 0 }}</td>
                    <td>{{ number_format($kpiInstitution->peratus_pencapaian ?? 0, 2) }}</td>
                    <td>
                        @if($kpiInstitution->kpi->pdf_file_path)
                            <a href="{{ url('/storage/' . $kpiInstitution->kpi->pdf_file_path) }}" target="_blank">Download PDF</a>
                        @endif
                    </td>
                    <td>
                        <span class="badge rounded-pill bg-{{ $kpiInstitution->status == 'achieved' ? 'success' : 'danger' }}">
                            {{ ucfirst($kpiInstitution->status ?? 'Not Defined') }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#achievementModal" 
                                data-kpi-id="{{ $kpiInstitution->id }}" 
                                data-kpi-name="{{ $kpiInstitution->kpi->pernyataan_kpi ?? 'N/A' }}" 
                                data-kpi-target="{{ $kpiInstitution->kpi->sasaran ?? 'N/A' }}">
                            <i class="bi bi-pencil-square"></i> Update
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No KPIs assigned to your institution.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Updating Achievement -->
<div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('institutionAdmin.kpi.assign') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="achievementModalLabel">Update KPI Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kpi_institutions_id" id="modalKpiId">

                    <div class="mb-3">
                        <label for="modalKpiName" class="form-label fw-bold">KPI</label>
                        <input type="text" id="modalKpiName" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="modalKpiTarget" class="form-label fw-bold">Target</label>
                        <input type="text" id="modalKpiTarget" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="pencapaian" class="form-label fw-bold">Achievement</label>
                        <input type="number" name="pencapaian" id="pencapaian" class="form-control" placeholder="Enter your achievement" required>
                        <div class="invalid-feedback">
                            Please enter a valid achievement.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const achievementModal = document.getElementById('achievementModal');
    achievementModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const kpiId = button.getAttribute('data-kpi-id');
        const kpiName = button.getAttribute('data-kpi-name');
        const kpiTarget = button.getAttribute('data-kpi-target');

        document.getElementById('modalKpiId').value = kpiId;
        document.getElementById('modalKpiName').value = kpiName;
        document.getElementById('modalKpiTarget').value = kpiTarget;
    });
</script>
@endsection



{{-- @extends('layout')

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

<a href="{{ route('admin-institution-kpis.create') }}" class="btn btn-primary mb-3">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
</svg>Assign New KPI</a>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>KPI</th>
            <th>NAME</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kpis->unique('pernyataan_kpi') as $kpi)
        <tr>
            <td>{{ $kpi->pernyataan_kpi }}</td>
            <td>@if($kpi->users->isNotEmpty())
                    @foreach ($kpi->users as $user)
                        {{ $user->name }}@if(!$loop->last), @endif
                    @endforeach
                @else
                    No users assigned
                @endif
            </td>
            <td>
                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $kpi->id }}" data-name="{{ $kpi->pernyataan_kpi }}" data-institutions="{{ json_encode($kpi->institutions->pluck('id')) }}">
                    Edit
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-name="{{ $kpi->pernyataan_kpi }}" data-url="{{ route('admin-institution-kpis.destroy', $kpi->id) }}">
                    Delete
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

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
@endsection --}}