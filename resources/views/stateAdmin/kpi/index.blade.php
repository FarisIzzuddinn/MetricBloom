@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold">KPI Management for {{ $state->name }}</h1>
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
                @forelse ($kpis as $kpiState)
                <tr>
                    <td class="fw-bold">{{ $loop->iteration }}</td>
                    <td>{{ $kpiState->kpi->pernyataan_kpi ?? 'N/A' }}</td>
                    <td>{{ $kpiState->kpi->sasaran ?? 'N/A' }}</td>
                    <td>{{ $kpiState->pencapaian ?? 0 }}</td>
                    <td>{{ number_format($kpiState->peratus_pencapaian ?? 0, 2) }}</td>
                    <td>
                        @if($kpiState->kpi->pdf_file_path)
                            <a href="{{ url('/storage/' . $kpiState->kpi->pdf_file_path) }}" target="_blank">Download PDF</a>
                        @endif
                    </td>
                    <td>
                        <span class="badge rounded-pill 
                            bg-{{ 
                                $kpiState->status === 'achieved' ? 'success' : 
                                ($kpiState->status === 'pending' ? 'warning text-dark' : 'danger') 
                            }}">
                            {{ ucfirst($kpiState->status ?? 'Not Defined') }}
                        </span>

                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" 
                                data-bs-toggle="modal" 
                                data-bs-target="#achievementModal" 
                                data-kpi-id="{{ $kpiState->id }}" 
                                data-kpi-name="{{ $kpiState->kpi->pernyataan_kpi ?? 'N/A' }}" 
                                data-kpi-target="{{ $kpiState->kpi->sasaran ?? 'N/A' }}">
                            <i class="bi bi-pencil-square"></i> Update
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No KPIs assigned to your state.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Updating Achievement -->
<div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('stateAdmin.kpi.update') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="achievementModalLabel">Update KPI Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kpi_state_id" id="modalKpiId">

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
