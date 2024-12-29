@extends('layout')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">KPI For {{ $sector }}</h1>
    </div>

    <!-- Success Message -->
    @include('alert')

    <!-- Loop Through Bahagian -->
    @forelse($groupedKpis as $bahagianName => $kpis)
        <div class="mb-5">
            <div class="card shadow-lg border-light rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $bahagianName }}</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-responsive table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>KPI</th>
                                <th>Target</th>
                                <th>Achievement</th>
                                <th>%</th>
                                <th>Dictionary</th>
                                <th>Reason</th>
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
                                    <td>{{ number_format($kpi->peratus_pencapaian ?? 0, 2) }}%</td>
                                    <td>
                                        @if($kpi->kpi->pdf_file_path)
                                            @php
                                                // Extract the file name from the file path
                                                $fileName = basename($kpi->kpi->pdf_file_path);
                                            @endphp
                                            <!-- Inline PDF Icon Link -->
                                            <a href="{{ url('/storage/' . $kpi->kpi->pdf_file_path) }}" target="_blank" 
                                               class="text-decoration-none d-flex align-items-center text-truncate" style="max-width: 150px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf me-2" viewBox="0 0 16 16" style="color: #d9534f;">
                                                    <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                                </svg>
                                                {{ $fileName }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $kpi->reason }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ 
                                            $kpi->status === 'achieved' ? 'success' : 
                                            ($kpi->status === 'pending' ? 'warning text-dark' : 'danger') }}">
                                            {{ ucfirst($kpi->status ?? 'Not Defined') }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" 
                                                data-bs-target="#achievementModal" 
                                                data-kpi-id="{{ $kpi->id }}" 
                                                data-kpi-name="{{ $kpi->kpi->pernyataan_kpi ?? 'N/A' }}" 
                                                data-kpi-target="{{ $kpi->kpi->sasaran ?? 'N/A' }}"
                                                data-kpi-types="{{ $kpi->kpi->jenis_sasaran ?? 'N/A' }}">
                                            Update
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No KPI available for this Bahagian.</td>
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
    <div class="modal-dialog modal-lg">
        <form action="{{ route('user.kpi.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="achievementModalLabel">Update KPI Achievement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="kpi_bahagian_id" id="modalKpiId">

                    <!-- KPI Name (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiName" class="form-label">KPI Name</label>
                        <textarea id="modalKpiName" class="form-control" rows="3" readonly></textarea>
                    </div>
                    
                    <!-- KPI Target (Read-Only) -->
                    <div class="mb-3">
                        <label for="modalKpiTarget" class="form-label">Target</label>
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

