@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold">KPI Management for {{ $state->name }}</h1>
    </div>

    <!-- Success Message -->
    @include('alert')
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
                        <td>{{ $kpiState->kpi->pernyataan_kpi ?? 'N/A' }}</td> <!-- KPI Name -->
                        <td>{{ $kpiState->kpi->sasaran ?? 'N/A' }}</td>       <!-- KPI Target -->
                        <td>{{ $kpiState->pencapaian ?? 0 }}</td>
                        <td>{{ number_format($kpiState->peratus_pencapaian ?? 0, 2) }}</td>
                        <td>
                            @if($kpiState->kpi->pdf_file_path)
                                <a href="{{ url('/storage/' . $kpiState->kpi->pdf_file_path) }}" target="_blank">Download PDF</a>
                            @endif
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-{{ 
                                strtolower(trim($kpiState->status)) === 'achieved' ? 'success' : 
                                (strtolower(trim($kpiState->status)) === 'pending' ? 'warning text-dark' : 'danger') }}">
                                {{ ucfirst($kpiState->status ?? 'Not Defined') }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#achievementModal" 
                                    data-kpi-id="{{ $kpiState->id }}" 
                                    data-kpi-name="{{ $kpiState->kpi->pernyataan_kpi ?? 'N/A' }}" 
                                    data-kpi-target="{{ $kpiState->kpi->sasaran ?? 'N/A' }}"
                                    data-kpi-types="{{ $kpiState->kpi->jenis_sasaran ?? 'N/A' }}">
                                <i class="bi bi-pencil-square"></i> Update
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No KPIs assigned to your state.</td>
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

                    <!-- KPI Name (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiName" class="form-label fw-bold">KPI</label>
                        <textarea id="modalKpiName" class="form-control" rows="3" readonly></textarea>
                    </div>

                    <!-- KPI Target (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiTarget" class="form-label fw-bold">Target</label>
                        <input type="text" id="modalKpiTarget" class="form-control" readonly>
                    </div>

                    <!-- KPI Target Type (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiType" class="form-label" style="display: none;">Target Types</label>
                        <input type="text" id="modalKpiType" class="form-control" readonly style="display: none;">
                    </div>

                     <!-- Container for 'peratus' -->
                     <div id="containerPeratus" style="display: none;">
                        <div class="mb-3">
                            <label for="pencapaian" class="form-label">Achievement</label>
                            <input type="number" name="pencapaian" id="pencapaianPeratus" class="form-control" placeholder="Enter your achievement">
                        </div>
                        <div class="mb-3">
                            <label for="totalValue" class="form-label">Total Value</label>
                            <input type="number" name="totalValue" id="totalValue" class="form-control" placeholder="Enter total">
                        </div>
                    </div>

                    <!-- Container for 'bilangan' -->
                    <div id="containerBilangan" style="display: none;">
                        <div class="mb-3">
                            <label for="pencapaian" class="form-label">Achievement</label>
                            <input type="number" name="pencapaian" id="pencapaianBilangan" class="form-control" placeholder="Enter your achievement">
                        </div>
                    </div>

                     <!-- Achievement Percentage -->
                     <div class="mb-3">
                        <label for="peratus_pencapaian" class="form-label">Achievement Percentage</label>
                        <input type="text" name="peratus_pencapaian" id="peratus_pencapaian" class="form-control" readonly placeholder="Auto-calculated percentage">
                    </div>

                    
                    <!-- Reason Dropdown -->
                    <div class="form-group">
                        <label for="reason" class="form-label">Reason</label>
                        <select id="reason" name="reason" class="form-control" onchange="toggleReasonInput(this)">
                            <option value="">--- Select Reason ---</option>
                            <option value="Money">Money</option>
                            <option value="Manpower">Manpower</option>
                            <option value="Material">Material</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Other Reason Input -->
                    <div class="form-group mt-3" id="other-reason-container" style="display: none;">
                        <label for="other_reason">Please specify:</label>
                        <input type="text" id="other_reason" name="other_reason" class="form-control" placeholder="Enter your reason">
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
 document.addEventListener('DOMContentLoaded', function () {
    const achievementModal = document.getElementById('achievementModal');
    if (!achievementModal) return;  // Exit if the modal is not found
    
    achievementModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const kpiId = button.getAttribute('data-kpi-id');
        const kpiName = button.getAttribute('data-kpi-name');
        const kpiTarget = button.getAttribute('data-kpi-target');
        const kpiTypes = button.getAttribute('data-kpi-types');

        // Ensure fields are present before accessing them
        const modalKpiId = document.getElementById('modalKpiId');
        const modalKpiName = document.getElementById('modalKpiName');
        const modalKpiTarget = document.getElementById('modalKpiTarget');
        const modalKpiType = document.getElementById('modalKpiType');

        if (modalKpiId && modalKpiName && modalKpiTarget && modalKpiType) {
            modalKpiId.value = kpiId;
            modalKpiName.value = kpiName;
            modalKpiTarget.value = kpiTarget;
            modalKpiType.value = kpiTypes;
        }

        toggleKpiTypeContainers(kpiTypes);
    });

    // Toggle KPI type containers (peratus/bilangan)
    function toggleKpiTypeContainers(kpiType) {
        const containerPeratus = document.getElementById('containerPeratus');
        const containerBilangan = document.getElementById('containerBilangan');
        const pencapaianPeratus = document.getElementById('pencapaianPeratus');
        const pencapaianBilangan = document.getElementById('pencapaianBilangan');

        if (!containerPeratus || !containerBilangan || !pencapaianPeratus || !pencapaianBilangan) return;

        // Hide both containers initially
        containerPeratus.style.display = 'none';
        containerBilangan.style.display = 'none';

        // Remove name attributes from both fields
        pencapaianPeratus.removeAttribute('name');
        pencapaianBilangan.removeAttribute('name');

        if (kpiType === 'peratus') {
            containerPeratus.style.display = 'block';
            pencapaianPeratus.setAttribute('name', 'pencapaian');
            console.log('KPI Type: Peratus - Showing Peratus Container');
        } else if (kpiType === 'bilangan') {
            containerBilangan.style.display = 'block';
            pencapaianBilangan.setAttribute('name', 'pencapaian');
            console.log('KPI Type: Bilangan - Showing Bilangan Container');
        }
    }

    // Update percentage
    function updatePercentage() {
    const achievement = parseFloat(this.value) || 0;
    const totalValue = parseFloat(document.getElementById('totalValue').value) || 0;
    const kpiTarget = parseFloat(document.getElementById('modalKpiTarget').value) || 0;
    const peratusPencapaianField = document.getElementById('peratus_pencapaian');

    if (!peratusPencapaianField) return;

    let percentage = 0;

    if (this.id === 'pencapaianPeratus' && totalValue > 0) {
        // Calculate percentage for peratus type
        percentage = (achievement / totalValue) * 100;
    } else if (this.id === 'pencapaianBilangan' && kpiTarget > 0) {
        // Calculate percentage for bilangan type
        percentage = (achievement / kpiTarget) * 100;
    }

    // Set the value to the field without '%' for submission
    if (isFinite(percentage) && percentage >= 0) {
        // Remove the '%' and store only the number
        peratusPencapaianField.value = percentage;
    } else {
        peratusPencapaianField.value = 0;
    }
}

    // Attach event listeners to fields
    const pencapaianPeratusField = document.getElementById('pencapaianPeratus');
    const pencapaianBilanganField = document.getElementById('pencapaianBilangan');

    if (pencapaianPeratusField) {
        pencapaianPeratusField.addEventListener('input', updatePercentage);
    }

    if (pencapaianBilanganField) {
        pencapaianBilanganField.addEventListener('input', updatePercentage);
    }
});
</script>
@endsection
