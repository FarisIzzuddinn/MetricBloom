<!-- Button trigger modal -->
<button type="button" class="btn btn-primary float-end mt-5 mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
    </svg>Add New KPI
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-4" id="exampleModalLabel">Add KPI</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kpi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Teras Dropdown -->
                    <div class="mb-4">
                        <label for="teras" class="form-label fw-semibold">Teras</label>
                        <select id="addTeras" name="teras_id" class="form-select shadow-sm" required>
                            @foreach ($teras as $teras)
                                <option value="{{ $teras->id }}">{{ $teras->teras }}</option>   
                            @endforeach
                        </select>
                    </div>

                    <!-- Sector Dropdown -->
                    <div class="mb-4">
                        <label for="SO" class="form-label fw-semibold">Sector</label>
                        <select id="sectors_id" name="sectors_id" class="form-select shadow-sm" required>
                            @foreach ($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>   
                            @endforeach
                        </select>
                    </div>

                    <!-- Owners Accordion -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Select Owners</label>
                        <div class="accordion" id="ownersAccordion">
                            <!-- States Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="statesHeading">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#statesCollapse" aria-expanded="true" aria-controls="statesCollapse">
                                        States
                                    </button>
                                </h2>
                                <div id="statesCollapse" class="accordion-collapse collapse show" aria-labelledby="statesHeading" data-bs-parent="#ownersAccordion">
                                    <div class="accordion-body">
                                        @foreach ($states as $state)
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="owners[]" 
                                                    value="state-{{ $state->id }}" 
                                                    id="state-{{ $state->id }}">
                                                <label class="form-check-label" for="state-{{ $state->id }}">
                                                    {{ $state->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Institutions Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="institutionsHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#institutionsCollapse" aria-expanded="false" aria-controls="institutionsCollapse">
                                        Institutions
                                    </button>
                                </h2>
                                <div id="institutionsCollapse" class="accordion-collapse collapse" aria-labelledby="institutionsHeading" data-bs-parent="#ownersAccordion">
                                    <div class="accordion-body">
                                        @foreach ($institutions as $institution)
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="owners[]" 
                                                    value="institution-{{ $institution->id }}" 
                                                    id="institution-{{ $institution->id }}">
                                                <label class="form-check-label" for="institution-{{ $institution->id }}">
                                                    {{ $institution->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Bahagian Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="bahagianHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bahagianCollapse" aria-expanded="false" aria-controls="bahagianCollapse">
                                        Bahagian
                                    </button>
                                </h2>
                                <div id="bahagianCollapse" class="accordion-collapse collapse" aria-labelledby="bahagianHeading" data-bs-parent="#ownersAccordion">
                                    <div class="accordion-body">
                                        @if($bahagians && $bahagians->isNotEmpty())
                                            @foreach ($bahagians as $bahagian)
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="owners[]"
                                                        value="bahagian-{{ $bahagian->id }}"
                                                        id="bahagian-{{ $bahagian->id }}">
                                                    <label class="form-check-label" for="bahagian-{{ $bahagian->id }}">
                                                        {{ $bahagian->nama_bahagian }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No Bahagian available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI Statement -->
                    <div class="mb-4">
                        <label for="pernyataan_kpi" class="form-label fw-semibold">KPI Statement</label>
                        <input type="text" id="addPernyataanKpi" name="pernyataan_kpi" class="form-control shadow-sm" required>
                    </div>

                    <!-- Target -->
                    <div class="mb-4">
                        <label for="sasaran" class="form-label fw-semibold">Target</label>
                        <input type="number" inputmode="numeric" id="addSasaran" name="sasaran" class="form-control shadow-sm" required>
                    </div>

                    <!-- Target Type -->
                    <div class="mb-4">
                        <label for="addJenisSasaran" class="form-label fw-semibold">Target Type</label>
                        <select id="addJenisSasaran" name="jenis_sasaran" class="form-select shadow-sm" required>
                            <option value="" disabled selected>Select Target Type</option>
                            <option value="peratus">Percentage (%)</option>
                            <option value="bilangan">Number</option>
                        </select>
                    </div>

                    <!-- Upload PDF -->
                    <div class="mb-4">
                        <label for="sasaran" class="form-label fw-semibold">Upload PDF</label>
                        <input type="file" name="pdf_file_path" id="pdf_file_path" class="form-control shadow-sm" accept="application/pdf">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Trigger this when the modal is shown
    var myModal = document.getElementById('exampleModal');
    myModal.addEventListener('shown.bs.modal', function () {
        let owners = [];
        // Get all checked owners checkboxes
        document.querySelectorAll('input[name="owners[]"]:checked').forEach(function(checkbox) {
            console.log("Owner value:", checkbox.value); // Log each selected value
            owners.push(checkbox.value); // Push the selected owner value into the array
        });

        console.log('Selected Owners:', owners); // Log all selected owners
    });
</script>
