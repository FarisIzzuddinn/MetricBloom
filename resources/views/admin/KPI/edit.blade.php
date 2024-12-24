{{-- edit button  --}}
<button 
    type="button" 
    class="btn btn-primary btn-sm" 
    data-bs-toggle="modal" 
    data-bs-target="#editKpi" 
    data-kpi-id="{{ $addKpi->id }}" 
    data-teras-id="{{ $addKpi->teras_id }}" 
    data-sectors-id="{{ $addKpi->sectors_id }}" 
    data-pernyataan="{{ $addKpi->pernyataan_kpi }}" 
    data-sasaran="{{ $addKpi->sasaran }}" 
    data-jenis-sasaran="{{ $addKpi->jenis_sasaran }}" 
    data-owners="{{ json_encode(array_merge(
        $addKpi->bahagians->map(fn($b) => "bahagian-" . $b->id)->toArray(),
        $addKpi->states->map(fn($s) => "state-" . $s->id)->toArray(),
        $addKpi->institutions->map(fn($i) => "institution-" . $i->id)->toArray()
    )) }}">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
    </svg>
</button>


{{-- modal edit kpi  --}}
<div class="modal fade" id="editKpi" tabindex="-1" aria-labelledby="editKpiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editKpiLabel"><i class="bi bi-pencil-square"></i> Edit KPI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editKpiForm" method="POST" action="{{ route('kpi.update', ['id' => $addKpi->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editKpiId" name="kpi_id">

                    <!-- Teras and Sector Fields -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editTeras" class="form-label">Teras</label>
                            <select id="editTeras" name="teras_id" class="form-select" required>
                                <option value="" disabled selected>Select Teras</option>
                                @foreach ($teras as $teras)
                                    <option value="{{ $teras->id }}">{{ $teras->teras }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editSO" class="form-label">Sector</label>
                            <select id="editSO" name="sectors_id" class="form-select" required>
                                <option value="" disabled selected>Select Sector</option>
                                @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Owner Selection -->
                    <div class="form-group mt-4">
                        <label for="editOwner" class="form-label">Select Owners</label>
                        <div class="border p-3 rounded shadow-sm">
                            <div class="accordion" id="ownersAccordion">
                                <!-- States Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingStates">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStates" aria-expanded="true" aria-controls="collapseStates">
                                            States
                                        </button>
                                    </h2>
                                    <div id="collapseStates" class="accordion-collapse collapse show" aria-labelledby="headingStates" data-bs-parent="#ownersAccordion">
                                        <div class="accordion-body">
                                            @foreach ($states as $state)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="owners[]" value="state-{{ $state->id }}" id="state-{{ $state->id }}"
                                                    @if($addKpi->states->contains('id', $state->id)) checked @endif>
                                                    <label class="form-check-label" for="state-{{ $state->id }}">{{ $state->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Institutions Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingInstitutions">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInstitutions" aria-expanded="false" aria-controls="collapseInstitutions">
                                            Institutions
                                        </button>
                                    </h2>
                                    <div id="collapseInstitutions" class="accordion-collapse collapse" aria-labelledby="headingInstitutions" data-bs-parent="#ownersAccordion">
                                        <div class="accordion-body">
                                            @foreach ($institutions as $institution)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="owners[]" value="institution-{{ $institution->id }}" id="institution-{{ $institution->id }}"
                                                @if($addKpi->institutions->contains('id', $institution->id)) checked @endif>
                                                <label class="form-check-label" for="institution-{{ $institution->id }}">{{ $institution->name }}</label>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Bahagian Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBahagian">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBahagian" aria-expanded="false" aria-controls="collapseBahagian">
                                            Bahagian
                                        </button>
                                    </h2>
                                    <div id="collapseBahagian" class="accordion-collapse collapse" aria-labelledby="headingBahagian" data-bs-parent="#ownersAccordion">
                                        <div class="accordion-body">
                                            @foreach ($bahagians as $bahagian)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="owners[]" value="bahagian-{{ $bahagian->id }}" id="bahagian-{{ $bahagian->id }}"
                                                @if($addKpi->bahagians->contains('id', $bahagian->id)) checked @endif>
                                                <label class="form-check-label" for="bahagian-{{ $bahagian->id }}">{{ $bahagian->nama_bahagian }}</label>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI Details -->
                    <div class="row g-3 mt-4">
                        <!-- KPI Statement -->
                        <div class="col-md-12">
                            <label for="editPernyataanKpi" class="form-label">KPI Statement</label>
                            <textarea id="editPernyataanKpi" name="pernyataan_kpi" class="form-control" rows="3" required>
                               
                            </textarea>
                        </div>
                    
                        <!-- Sasaran -->
                        <div class="col-md-6">
                            <label for="editSasaran" class="form-label">Sasaran</label>
                            <input type="number" id="editSasaran" name="sasaran" class="form-control" required>
                        </div>
                    
                        <!-- Jenis Sasaran -->
                        <div class="col-md-6">
                            <label for="editJenisSasaran" class="form-label">Jenis Sasaran</label>
                            <select id="editJenisSasaran" name="jenis_sasaran" class="form-select" required>
                                <option value="" disabled selected>Select</option>
                                <option value="peratus">Peratus</option>
                                <option value="bilangan">Bilangan</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="row mb-3 mt-3">
                        <label for="pdf_file_path" class="col-sm-5 col-form-label">Current PDF File</label>
                        <div class="col-sm-7">
                            @if (!empty($currentPdfFilePath))
                                <a href="{{ url('storage/' . $currentPdfFilePath) }}" target="_blank" class="btn btn-link">View Current PDF</a>
                                <small class="text-muted ms-3">You can replace this file below.</small>
                            @else
                                <p class="text-muted">No PDF file currently uploaded.</p>
                            @endif
                        </div>
                    </div> --}}

                    <div class="row mb-3 mt-3">
                        <label for="pdf_file_path" class="col-sm-5 col-form-label">Upload New PDF File</label>
                        <div class="col-sm-7">
                            <input type="file" name="pdf_file_path" id="pdf_file_path" class="form-control" accept="application/pdf">
                            <small class="text-muted">Only PDF files are allowed. Uploading a new file will replace the current one.</small>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
      document.addEventListener('DOMContentLoaded', function () {
        const editKpiModal = document.getElementById('editKpi');
        editKpiModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const modal = event.target; // Modal being shown

            // Retrieve data attributes
            const kpiId = button.getAttribute('data-kpi-id');
            const terasId = button.getAttribute('data-teras-id');
            const sectorsId = button.getAttribute('data-sectors-id');
            const pernyataan = button.getAttribute('data-pernyataan');
            const sasaran = button.getAttribute('data-sasaran');
            const jenisSasaran = button.getAttribute('data-jenis-sasaran');
            const owners = JSON.parse(button.getAttribute('data-owners') || '[]'); // Fallback to empty array

            // Log the data to the console for debugging
            console.log('KPI ID:', kpiId);  // This should print the correct kpi_id

            // Populate modal fields
            modal.querySelector('#editTeras').value = terasId;
            modal.querySelector('#editSO').value = sectorsId;
            modal.querySelector('#editPernyataanKpi').value = pernyataan;
            modal.querySelector('[name="sasaran"]').value = sasaran;
            modal.querySelector('[name="jenis_sasaran"]').value = jenisSasaran;

            // Set the correct kpi_id in the hidden field
            modal.querySelector('#editKpiId').value = kpiId;

            // Update the form action URL dynamically to include the correct kpi_id
            const formActionUrl = `/admin/addKpi/update/${kpiId}`; // Correct route URL
            modal.querySelector('form').action = formActionUrl;

            // Clear all owner checkboxes
            const ownerCheckboxes = modal.querySelectorAll('input[name="owners[]"]');
            ownerCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Check the correct owner checkboxes
            owners.forEach(ownerId => {
                const ownerCheckbox = modal.querySelector(`input[name="owners[]"][value="${ownerId}"]`);
                if (ownerCheckbox) {
                    ownerCheckbox.checked = true;
                }
            });
        });
    });
</script>