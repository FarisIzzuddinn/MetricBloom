@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>KPI For {{ $sector }}</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Loop Through Bahagian -->
    @forelse($groupedKpis as $bahagianName => $kpis)
    <div class="mb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $bahagianName }}</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
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
                        @forelse($kpis as $index => $kpi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kpi->kpi->pernyataan_kpi ?? 'N/A' }}</td>
                            <td>{{ $kpi->kpi->sasaran ?? 'N/A' }}</td>
                            <td>{{ $kpi->pencapaian ?? '0' }}</td>
                            <td>{{ number_format($kpi->peratus_pencapaian ?? 0, 2) }}</td>
                            <td>
                                @if($kpi->kpi->pdf_file_path)
                                    <a href="{{ url('/storage/' . $kpi->kpi->pdf_file_path) }}" target="_blank">Download PDF</a>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill 
                                    bg-{{ 
                                        $kpi->status === 'achieved' ? 'success' : 
                                        ($kpi->status === 'pending' ? 'warning text-dark' : 'danger') 
                                    }}">
                                    {{ ucfirst($kpi->status ?? 'Not Defined') }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#achievementModal" 
                                    data-kpi-id="{{ $kpi->id }}" 
                                    data-kpi-name="{{ $kpi->kpi->pernyataan_kpi ?? 'N/A' }}" 
                                    data-kpi-target="{{ $kpi->kpi->sasaran ?? 'N/A' }}">
                                    Update
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No KPI available for this Bahagian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-warning text-center">No KPIs available for your sector.</div>
    @endforelse    
</div>

<!-- Modal for Updating Achievement -->
<div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('user.kpi.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="achievementModalLabel">Update KPI Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Hidden Field for KPI Bahagian ID -->
                    <input type="hidden" name="kpi_bahagian_id" id="modalKpiId">

                    <!-- KPI Name (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiName" class="form-label">KPI Name</label>
                        <input type="text" id="modalKpiName" class="form-control" readonly>
                    </div>

                    <!-- KPI Target (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiTarget" class="form-label">Target</label>
                        <input type="text" id="modalKpiTarget" class="form-control" readonly>
                    </div>

                    <!-- Achievement Field -->
                    <div class="mb-3">
                        <label for="pencapaian" class="form-label">Achievement</label>
                        <input type="number" name="pencapaian" id="pencapaian" class="form-control" placeholder="Enter your achievement" required>
                    </div>

                    {{-- <!-- Numerator Field -->
                    <div class="mb-3">
                        <label for="numerator" class="form-label">Numerator</label>
                        <input type="number" name="numerator" id="numerator" class="form-control" placeholder="Enter numerator value" required>
                    </div>

                    <!-- Denominator Field -->
                    <div class="mb-3">
                        <label for="denominator" class="form-label">Denominator</label>
                        <input type="number" name="denominator" id="denominator" class="form-control" placeholder="Enter denominator value" required>
                    </div>

                    <!-- Calculation Result (Read-Only) -->
                    <div class="mb-3">
                        <label for="calculationResult" class="form-label">Calculated Percentage</label>
                        <input type="text" id="calculationResult" class="form-control" readonly>
                    </div>

                    <!-- Status (Dynamic) -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" id="status" class="form-control" readonly>
                    </div> --}}
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

    document.getElementById('numerator').addEventListener('input', updateCalculation);
document.getElementById('denominator').addEventListener('input', updateCalculation);

function updateCalculation() {
    const numerator = parseFloat(document.getElementById('numerator').value) || 0;
    const denominator = parseFloat(document.getElementById('denominator').value) || 0;
    const resultField = document.getElementById('calculationResult');
    const statusField = document.getElementById('status');

    if (denominator > 0) {
        const percentage = (numerator / denominator) * 100;
        resultField.value = `${percentage.toFixed(2)}%`;

        if (percentage > 100) {
            statusField.value = 'Achieved';
        } else if (percentage > 50) {
            statusField.value = 'Pending';
        } else {
            statusField.value = 'Not Achieved';
        }
    } else {
        resultField.value = '';
        statusField.value = '';
    }
}

</script>
@endsection
