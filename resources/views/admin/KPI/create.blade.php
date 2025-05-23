<!-- Button trigger modal -->
<x-createButton name="Tambah KPI" target="#exampleModal" />

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-pencil-square"></i> Tambah KPI</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('kpi.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-4">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" id="formProgress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span>Basic Info</span>
                            <span>Owners</span>
                            <span>Details</span>
                            <span>Targets</span>
                            <span>Documents</span>
                        </div>
                    </div>

                    <!-- Form sections with tabs -->
                    <ul class="nav nav-tabs mb-3" id="editKpiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-controls="basic-info" aria-selected="true">1. Basic Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="owners-tab" data-bs-toggle="tab" data-bs-target="#owners" type="button" role="tab" aria-controls="owners" aria-selected="false">2. Owners</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">3. Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="targets-tab" data-bs-toggle="tab" data-bs-target="#targets" type="button" role="tab" aria-controls="targets" aria-selected="false">4. Targets</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">5. Documents</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="editKpiTabContent">
                        <!-- 1. Basic Info Section -->
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Basic Information</h6>
                                    
                                    <div class="row g-3">
                                        <!-- KPI Title -->
                                        <div class="col-12">
                                            <label for="addKpiTitle" class="form-label">Tajuk KPI <span class="text-danger">*</span></label>
                                            <textarea id="addKpiTitle" name="pernyataan_kpi" class="form-control" rows="2" required></textarea>
                                            <div class="invalid-feedback">Please provide a KPI title.</div>
                                        </div>

                                        <!-- Teras and Sector Fields -->
                                        <div class="col-md-6">
                                            <label for="addTeras" class="form-label">Teras <span class="text-danger">*</span></label>
                                            <select id="addTeras" name="teras_id" class="form-select" required>
                                                <option value="" disabled selected>Select Teras</option>
                                                @foreach ($teras as $teras)
                                                    <option value="{{ $teras->id }}">{{ $teras->teras }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Teras.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="addSector" class="form-label">Sector <span class="text-danger">*</span></label>
                                            <select id="addSector" name="sectors_id" class="form-select" required>
                                                <option value="" disabled selected>Select Sector</option>
                                                @foreach ($sectors as $sector)
                                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Sector.</div>
                                        </div>

                                        <!-- Strategy and Program -->
                                        <div class="col-md-6">
                                            <label for="addStrategy" class="form-label">Strategi <span class="text-danger">*</span></label>
                                            <input type="text" id="addStrategy" name="strategi" class="form-control" placeholder="Masukkan strategi" required>
                                            <div class="invalid-feedback">Please provide a strategy.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="addProgram" class="form-label">Program <span class="text-danger">*</span></label>
                                            <input type="text" id="addProgram" name="program" class="form-control" placeholder="Masukkan program" required>
                                            <div class="invalid-feedback">Please provide a program.</div>
                                        </div>

                                        <!-- Indicator -->
                                        <div class="col-12">
                                            <label for="addIndicator" class="form-label">Indikator <span class="text-danger">*</span></label>
                                            <input type="text" id="addIndicator" name="indikator" class="form-control" placeholder="Masukkan indikator" required>
                                            <div class="invalid-feedback">Please provide an indicator.</div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary next-tab" data-bs-target="#owners-tab">Next: Owners</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Owners Section -->
                        <div class="tab-pane fade" id="owners" role="tabpanel" aria-labelledby="owners-tab">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Pemilik KPI</h6>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <i class="bi bi-info-circle-fill me-2"></i> Please select at least one owner for this KPI
                                            </div>

                                            <div class="form-group">
                                                <div class="border p-3 rounded shadow-sm">
                                                    <div class="accordion" id="ownersAccordion">
                                                        <!-- KJP Section -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingKjp">
                                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKjp" aria-expanded="true" aria-controls="collapseKjp">
                                                                    Komisioner Jeneral Penjara
                                                                </button>
                                                            </h2>
                                                            <div id="collapseKjp" class="accordion-collapse collapse show" aria-labelledby="headingKjp" data-bs-parent="#ownersAccordion">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex justify-content-end mb-2">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary select-all" data-target="collapseKjp">Select All</button>
                                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 unselect-all" data-target="collapseKjp">Unselect All</button>
                                                                    </div>
                                                                    <div class="row g-2">
                                                                        @foreach ($kjps as $kjp)
                                                                            <div class="col-md-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" name="owners[]" 
                                                                                        value="kjp-{{ $kjp->id }}" 
                                                                                        id="kjp-{{ $kjp->id }}">
                                                                                    <label class="form-check-label" for="kjp-{{ $kjp->id }}">{{ $kjp->name }}</label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>                                        
                                                            </div>
                                                        </div>

                                                        <!-- States Section -->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingStates">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStates" aria-expanded="false" aria-controls="collapseStates">
                                                                    States
                                                                </button>
                                                            </h2>
                                                            <div id="collapseStates" class="accordion-collapse collapse" aria-labelledby="headingStates" data-bs-parent="#ownersAccordion">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex justify-content-end mb-2">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary select-all" data-target="collapseStates">Select All</button>
                                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 unselect-all" data-target="collapseStates">Unselect All</button>
                                                                    </div>
                                                                    <div class="row g-2">
                                                                        @foreach ($states as $state)
                                                                            <div class="col-md-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" name="owners[]" 
                                                                                        value="state-{{ $state->id }}" 
                                                                                        id="state-{{ $state->id }}">
                                                                                    <label class="form-check-label" for="state-{{ $state->id }}">{{ $state->name }}</label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
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
                                                                    <div class="d-flex justify-content-end mb-2">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary select-all" data-target="collapseInstitutions">Select All</button>
                                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 unselect-all" data-target="collapseInstitutions">Unselect All</button>
                                                                    </div>
                                                                    <div class="row g-2">
                                                                        @foreach ($institutions as $institution)
                                                                            <div class="col-md-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" name="owners[]" 
                                                                                        value="institution-{{ $institution->id }}" 
                                                                                        id="institution-{{ $institution->id }}">
                                                                                    <label class="form-check-label" for="institution-{{ $institution->id }}">{{ $institution->name }}</label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
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
                                                                    <div class="d-flex justify-content-end mb-2">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary select-all" data-target="collapseBahagian">Select All</button>
                                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 unselect-all" data-target="collapseBahagian">Unselect All</button>
                                                                    </div>
                                                                    <div class="row g-2">
                                                                        @foreach ($bahagians as $bahagian)
                                                                            <div class="col-md-4">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" name="owners[]" 
                                                                                        value="bahagian-{{ $bahagian->id }}" 
                                                                                        id="bahagian-{{ $bahagian->id }}">
                                                                                    <label class="form-check-label" for="bahagian-{{ $bahagian->id }}">{{ $bahagian->nama_bahagian }}</label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Category Reporting -->
                                            <div class="mt-4">
                                                <label for="categoryReporting" class="form-label">Kategori Laporan <span class="text-danger">*</span></label>
                                                <select name="kategori_report" id="categoryReporting" class="form-select" required>
                                                    <option value="" selected disabled>Pilih Kategori Laporan</option>
                                                    <option value="monthly">Bulanan</option>
                                                    <option value="quarterly">Sukuan Tahun (Setiap 3 bulan)</option>
                                                    <option value="semi_annually">Setengah Tahun (Setiap 6 Bulan)</option>
                                                    <option value="annually">Tahunan</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a report category.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary prev-tab" data-bs-target="#basic-info-tab">Previous</button>
                                        <button type="button" class="btn btn-primary next-tab" data-bs-target="#details-tab">Next: Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Details Section -->
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">KPI Details</h6>

                                    <div class="row g-3">
                                        <!-- Activities -->
                                        <div class="col-12">
                                            <label for="editAktiviti" class="form-label">Aktiviti KPI <span class="text-danger">*</span></label>
                                            <textarea id="editAktiviti" name="aktiviti" class="form-control" rows="3" required></textarea>
                                            <div class="invalid-feedback">Please provide KPI activities.</div>
                                        </div>

                                        <!-- Outcome -->
                                        <div class="col-12">
                                            <label for="editOutcome" class="form-label">Outcome KPI <span class="text-danger">*</span></label>
                                            <input type="text" id="editOutcome" name="outcome" class="form-control" required>
                                            <div class="invalid-feedback">Please provide KPI outcome.</div>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">
                                            <label for="editKeterangan" class="form-label">Keterangan KPI <span class="text-danger">*</span></label>
                                            <input type="text" id="editKeterangan" name="keterangan" class="form-control" required>
                                            <div class="invalid-feedback">Please provide KPI description.</div>
                                        </div>

                                        <!-- Justification -->
                                        <div class="col-12">
                                            <label for="editJustifikasi" class="form-label">Justifikasi KPI <span class="text-danger">*</span></label>
                                            <input type="text" id="editJustifikasi" name="justifikasi" class="form-control" required>
                                            <div class="invalid-feedback">Please provide KPI justification.</div>
                                        </div>

                                        <!-- Achievement Trend -->
                                        <div class="col-12">
                                            <label for="editTrendPencapaian" class="form-label">Trend Pencapaian <span class="text-danger">*</span></label>
                                            <input type="text" id="editTrendPencapaian" name="trend_pencapaian" class="form-control" required>
                                            <div class="invalid-feedback">Please provide achievement trend.</div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary prev-tab" data-bs-target="#owners-tab">Previous</button>
                                        <button type="button" class="btn btn-primary next-tab" data-bs-target="#targets-tab">Next: Targets</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Targets Section -->
                        <div class="tab-pane fade" id="targets" role="tabpanel" aria-labelledby="targets-tab">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Target Information</h6>

                                    <div class="row g-3">
                                        <div class="target-rows">
                                            <!-- Initial target row -->
                                            <div class="target-row mb-3">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label for="editSasaran_0" class="form-label">Sasaran <span class="text-danger">*</span></label>
                                                        <input type="number" id="editSasaran_0" name="sasaran[]" class="form-control" required>
                                                        <div class="invalid-feedback">Please provide a target value.</div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="editJenisSasaran_0" class="form-label">Jenis Target <span class="text-danger">*</span></label>
                                                        <select id="editJenisSasaran_0" name="jenis_sasaran[]" class="form-select" required>
                                                            <option value="" disabled selected>Select</option>
                                                            <option value="peratus">Peratus</option>
                                                            <option value="bilangan">Bilangan</option>
                                                            <option value="tempoh masa">Tempoh Masa</option>
                                                            <option value="hari">Hari</option>
                                                            <option value="kelajuan">Kelajuan</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a target type.</div>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <!-- No remove button for first row -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Add row button -->
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-outline-primary btn-sm add-target-row">
                                                <i class="bi bi-plus-circle me-1"></i> Add Another Target
                                            </button>
                                        </div>

                                        <!-- Caveats -->
                                        <div class="col-md-6">
                                            <label for="editKaveat" class="form-label">Kaveat/Kekangan <span class="text-danger">*</span></label>
                                            <input type="text" id="editKaveat" name="kaveat" class="form-control" required>
                                            <div class="invalid-feedback">Please provide caveats.</div>
                                        </div>

                                        <!-- Formula -->
                                        <div class="col-md-6">
                                            <label for="editFormula" class="form-label">Kaedah Pengiraan/Formula <span class="text-danger">*</span></label>
                                            <input type="text" id="editFormula" name="formula" class="form-control" required>
                                            <div class="invalid-feedback">Please provide calculation method.</div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary prev-tab" data-bs-target="#details-tab">Previous</button>
                                        <button type="button" class="btn btn-primary next-tab" data-bs-target="#documents-tab">Next: Documents</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Documents Section -->
                        <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Documents</h6>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="pdf_file_path" class="form-label">
                                                <i class="bi bi-file-earmark-pdf me-1"></i> Upload New PDF File
                                            </label>
                                            <input type="file" name="pdf_file_path" id="pdf_file_path" class="form-control" accept="application/pdf">
                                            <div class="form-text">
                                                <small>Only PDF files are allowed. Uploading a new file will replace the current one.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Current File Section -->
                                    <div class="mt-3">
                                        <h6 class="text-muted">Current File</h6>
                                        <div class="card bg-light">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center" id="currentFileDisplay">
                                                    <i class="bi bi-file-earmark-pdf fs-4 me-2 text-danger"></i>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0" id="currentFileName">current_file.pdf</p>
                                                        <small class="text-muted" id="currentFileSize">Size: 2.3 MB</small>
                                                    </div>
                                                    <a href="#" class="btn btn-sm btn-outline-primary" id="viewCurrentFile">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary prev-tab" data-bs-target="#targets-tab">Previous</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-save me-1"></i> Save All Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  // Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Form Progress Tracking
    const progressBar = document.getElementById('formProgress');
    const tabButtons = document.querySelectorAll('.nav-link');
    
    // Tab Navigation
    const nextTabButtons = document.querySelectorAll('.next-tab');
    const prevTabButtons = document.querySelectorAll('.prev-tab');
    
    // Fix for Bootstrap reference - make sure it's properly accessed
    const bootstrap = window.bootstrap || (typeof bootstrap !== 'undefined' ? bootstrap : null);
    if (!bootstrap) {
        console.warn('Bootstrap JavaScript not loaded or not accessible via window.bootstrap');
    }
    
    nextTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTabId = this.getAttribute('data-bs-target');
            const targetTab = document.querySelector(targetTabId);
            
            // Check validity of current tab fields
            const currentTabPane = this.closest('.tab-pane');
            const currentInputs = currentTabPane.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;
            
            currentInputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (isValid) {
                const tab = new bootstrap.Tab(targetTab);
                tab.show();
                updateProgressBar();
            }
        });
    });
    
    prevTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTabId = this.getAttribute('data-bs-target');
            const targetTab = document.querySelector(targetTabId);
            const bootstrap = window.bootstrap || bootstrap;
            const tab = new bootstrap.Tab(targetTab);
            tab.show();
            updateProgressBar();
        });
    });
    
    // Update progress bar when tabs change
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', updateProgressBar);
    });
    
    function updateProgressBar() {
        const activeTab = document.querySelector('.nav-link.active');
        const tabIndex = Array.from(tabButtons).indexOf(activeTab);
        const progress = (tabIndex / (tabButtons.length - 1)) * 100;
        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
    }
    
    // Select/Unselect All Checkboxes
    const selectAllButtons = document.querySelectorAll('.select-all');
    const unselectAllButtons = document.querySelectorAll('.unselect-all');
    
    selectAllButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContainer = document.getElementById(targetId);
            const checkboxes = targetContainer.querySelectorAll('input[type="checkbox"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        });
    });
    
    unselectAllButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetContainer = document.getElementById(targetId);
            const checkboxes = targetContainer.querySelectorAll('input[type="checkbox"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    });
    
    // Add Target Row
    const addTargetButton = document.querySelector('.add-target-row');
    const targetContainer = document.querySelector('.target-rows');
    
    let targetRowIndex = 1;
    
    addTargetButton.addEventListener('click', function() {
        const newRow = document.createElement('div');
        newRow.classList.add('target-row', 'mb-3');
        
        newRow.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="editSasaran_${targetRowIndex}" class="form-label">Sasaran <span class="text-danger">*</span></label>
                    <input type="number" id="editSasaran_${targetRowIndex}" name="sasaran[]" class="form-control" required>
                    <div class="invalid-feedback">Please provide a target value.</div>
                </div>
                <div class="col-md-5">
                    <label for="editJenisSasaran_${targetRowIndex}" class="form-label">Jenis Target <span class="text-danger">*</span></label>
                    <select id="editJenisSasaran_${targetRowIndex}" name="jenis_sasaran[]" class="form-select" required>
                        <option value="" disabled selected>Select</option>
                        <option value="peratus">Peratus</option>
                        <option value="bilangan">Bilangan</option>
                        <option value="tempoh masa">Tempoh Masa</option>
                        <option value="hari">Hari</option>
                        <option value="kelajuan">Kelajuan</option>
                    </select>
                    <div class="invalid-feedback">Please select a target type.</div>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-target-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        targetContainer.appendChild(newRow);
        targetRowIndex++;
        
        // Add event listener to the remove button for this new row
        const removeButton = newRow.querySelector('.remove-target-row');
        removeButton.addEventListener('click', function() {
            newRow.remove();
        });
    });
    
    // Form Validation
    const form = document.querySelector('form.needs-validation');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Find the first invalid field
            const invalidFields = form.querySelectorAll(':invalid');
            if (invalidFields.length > 0) {
                // Find which tab contains the first invalid field
                const firstInvalidField = invalidFields[0];
                const tabPane = firstInvalidField.closest('.tab-pane');
                const tabId = tabPane.id;
                const tabButton = document.querySelector(`button[data-bs-target="#${tabId}"]`);
                
                // Show the tab with the invalid field
                const bootstrap = window.bootstrap || bootstrap;
                const tab = new bootstrap.Tab(tabButton);
                tab.show();
                
                // Scroll to and focus on the invalid field
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => firstInvalidField.focus(), 500);
                
                // Show validation feedback
                form.classList.add('was-validated');
            }
        } else {
            // Valid form
            form.classList.add('was-validated');
        }
    });
    
    // Handle file upload display
    const fileInput = document.getElementById('pdf_file_path');
    const currentFileName = document.getElementById('currentFileName');
    const currentFileSize = document.getElementById('currentFileSize');
    const currentFileDisplay = document.getElementById('currentFileDisplay');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            currentFileName.textContent = file.name;
            currentFileSize.textContent = 'Size: ' + formatFileSize(file.size);
            currentFileDisplay.classList.remove('d-none');
        }
    });
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Initialize the form
    updateProgressBar();
    
    // Optional: Remove "No current file" message if there's no file
    if (currentFileName.textContent.trim() === 'current_file.pdf') {
        // Check if this is a placeholder. If so, you might want to hide the file display initially
        // currentFileDisplay.classList.add('d-none');
    }
});
</script>
