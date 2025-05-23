<!-- Edit Button -->
<button 
    type="button" 
    class="btn btn-primary btn-sm me-2" 
    data-bs-toggle="modal" 
    data-bs-target="#editKpi" 
    data-kpi-id="{{ $addKpi->id }}" 
    data-teras-id="{{ $addKpi->teras_id }}" 
    data-sectors-id="{{ $addKpi->sectors_id }}" 
    data-pernyataan="{{ $addKpi->pernyataan_kpi }}" 
    data-sasaran="{{ json_encode($addKpi->sasaran) }}" 
    data-jenis-sasaran="{{ json_encode($addKpi->jenis_sasaran) }}"
    data-indikator="{{ $addKpi->indikator }}" 
    data-strategi="{{ $addKpi->strategi }}" 
    data-program="{{ $addKpi->program }}" 
    data-aktiviti="{{ $addKpi->aktiviti }}"
    data-outcome="{{ $addKpi->outcome }}"
    data-keterangan="{{ $addKpi->keterangan }}"
    data-justifikasi="{{ $addKpi->justifikasi }}"
    data-trend-pencapaian="{{ $addKpi->trend_pencapaian }}"
    data-kaveat="{{ $addKpi->kaveat }}"
    data-formula="{{ $addKpi->formula }}"
    data-kategori-report="{{ $addKpi->kategori_report }}"
    data-owners="{{ json_encode(array_merge(
        $addKpi->bahagians->map(fn($b) => "bahagian-" . $b->id)->toArray(),
        $addKpi->states->map(fn($s) => "state-" . $s->id)->toArray(),
        $addKpi->institutions->map(fn($i) => "institution-" . $i->id)->toArray(),
        $addKpi->kjps->map(fn($i) => "kjp-" . $i->id)->toArray()
    )) }}">
    <i class="bi bi-pencil-square"></i>
</button>       

<!-- Modal Edit KPI -->
<div class="modal fade" id="editKpi" tabindex="-1" aria-labelledby="editKpiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editKpiLabel"><i class="bi bi-pencil-square"></i> Edit KPI</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editKpiForm" method="POST" action="{{ route('kpi.update', ['id' => $addKpi->id]) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editKpiId" name="kpi_id">

                    <!-- Progress indicator -->
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
                                            <label for="editPernyataanKpi" class="form-label">Tajuk KPI <span class="text-danger">*</span></label>
                                            <textarea id="editPernyataanKpi" name="pernyataan_kpi" class="form-control" rows="2" required></textarea>
                                            <div class="invalid-feedback">Please provide a KPI title.</div>
                                        </div>

                                        <!-- Teras and Sector Fields -->
                                        <div class="col-md-6">
                                            <label for="editTeras" class="form-label">Teras <span class="text-danger">*</span></label>
                                            <select id="editTeras" name="teras_id" class="form-select" required>
                                                <option value="" disabled selected>Select Teras</option>
                                                @foreach ($teras as $teras)
                                                    <option value="{{ $teras->id }}">{{ $teras->teras }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Teras.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editSO" class="form-label">Sector <span class="text-danger">*</span></label>
                                            <select id="editSO" name="sectors_id" class="form-select" required>
                                                <option value="" disabled selected>Select Sector</option>
                                                @foreach ($sectors as $sector)
                                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a Sector.</div>
                                        </div>

                                        <!-- Strategy and Program -->
                                        <div class="col-md-6">
                                            <label for="editStrategi" class="form-label">Strategi <span class="text-danger">*</span></label>
                                            <input type="text" id="editStrategi" name="strategi" class="form-control" placeholder="Masukkan strategi" required>
                                            <div class="invalid-feedback">Please provide a strategy.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editProgram" class="form-label">Program <span class="text-danger">*</span></label>
                                            <input type="text" id="editProgram" name="program" class="form-control" placeholder="Masukkan program" required>
                                            <div class="invalid-feedback">Please provide a program.</div>
                                        </div>

                                        <!-- Indicator -->
                                        <div class="col-12">
                                            <label for="editIndikator" class="form-label">Indikator <span class="text-danger">*</span></label>
                                            <input type="text" id="editIndikator" name="indikator" class="form-control" placeholder="Masukkan indikator" required>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Form validation
        const form = document.getElementById('editKpiForm');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Tab navigation
        const navTabs = document.querySelectorAll('.next-tab, .prev-tab');
        navTabs.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = document.querySelector(this.getAttribute('data-bs-target'));
                const tab = new bootstrap.Tab(targetTab);
                tab.show();
                
                // Update progress bar
                updateProgressBar();
            });
        });

        // Update progress bar based on active tab
        function updateProgressBar() {
            const tabs = ['#basic-info-tab', '#owners-tab', '#details-tab', '#targets-tab', '#documents-tab'];
            const activeTab = document.querySelector('.nav-link.active');
            const activeIndex = tabs.indexOf('#' + activeTab.id);
            const progressPercentage = (activeIndex / (tabs.length - 1)) * 100;
            
            document.getElementById('formProgress').style.width = progressPercentage + '%';
        }

        // Initial progress bar update
        updateProgressBar();

        // Modal data population
        const editKpiModal = document.getElementById('editKpi');
        editKpiModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const kpiId = button.getAttribute('data-kpi-id');
            const terasId = button.getAttribute('data-teras-id');
            const sectorsId = button.getAttribute('data-sectors-id');
            const pernyataan = button.getAttribute('data-pernyataan');
            let sasaran = button.getAttribute('data-sasaran');
            let jenisSasaran = button.getAttribute('data-jenis-sasaran');
            const indikator = button.getAttribute('data-indikator');
            const strategi = button.getAttribute('data-strategi');
            const program = button.getAttribute('data-program');
            const aktiviti = button.getAttribute('data-aktiviti');
            const outcome = button.getAttribute('data-outcome');
            const keterangan = button.getAttribute('data-keterangan');
            const justifikasi = button.getAttribute('data-justifikasi');
            const trendPencapaian = button.getAttribute('data-trend-pencapaian');
            const kaveat = button.getAttribute('data-kaveat');
            const formula = button.getAttribute('data-formula');
            const kategoriReport = button.getAttribute('data-kategori-report');
            const owners = JSON.parse(button.getAttribute('data-owners') || '[]');

            // Set form field values
            document.getElementById('editKpiId').value = kpiId;
            document.getElementById('editTeras').value = terasId;
            document.getElementById('editSO').value = sectorsId;
            document.getElementById('editPernyataanKpi').value = pernyataan;
            document.getElementById('editIndikator').value = indikator;
            document.getElementById('editStrategi').value = strategi;
            document.getElementById('editProgram').value = program;
            
            // Handle target values
            // Assuming sasaran and jenisSasaran are comma-separated values or JSON arrays
            let sasaranValues = [];
            let jenisSasaranValues = [];
            try {
                sasaranValues = sasaran ? JSON.parse(sasaran) : [];
                jenisSasaranValues = jenisSasaran ? JSON.parse(jenisSasaran) : [];
            } catch (e) {
                console.error("JSON Parsing Error:", e);
            }

            // Set KPI ID and pernyataan
            document.getElementById('editKpiId').value = kpiId;
            document.getElementById('editPernyataanKpi').value = pernyataan;

            // Select the container for target rows
            const targetRowsContainer = document.querySelector('.target-rows');
            targetRowsContainer.innerHTML = ''; // Clear existing rows

            // Loop through the values and dynamically generate rows
            for (let i = 0; i < sasaranValues.length; i++) {
                let rowHtml = `
                    <div class="target-row mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Sasaran <span class="text-danger">*</span></label>
                                <input type="number" id="editSasaran_${i}" name="sasaran[]" class="form-control" required value="${sasaranValues[i]}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Jenis Sasaran <span class="text-danger">*</span></label>
                                <select id="editJenisSasaran_${i}" name="jenis_sasaran[]" class="form-select" required>
                                    <option value="" disabled>Select</option>
                                    <option value="peratus" ${jenisSasaranValues[i] === 'peratus' ? 'selected' : ''}>Peratus</option>
                                    <option value="bilangan" ${jenisSasaranValues[i] === 'bilangan' ? 'selected' : ''}>Bilangan</option>
                                    <option value="tempoh masa" ${jenisSasaranValues[i] === 'tempoh masa' ? 'selected' : ''}>Tempoh Masa</option>
                                    <option value="hari" ${jenisSasaranValues[i] === 'hari' ? 'selected' : ''}>Hari</option>
                                    <option value="kelajuan" ${jenisSasaranValues[i] === 'kelajuan' ? 'selected' : ''}>Kelajuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;

                targetRowsContainer.insertAdjacentHTML('beforeend', rowHtml);
            }
            
            // Set additional fields if they exist in the DOM
            if (document.getElementById('editAktiviti')) document.getElementById('editAktiviti').value = aktiviti || '';
            if (document.getElementById('editOutcome')) document.getElementById('editOutcome').value = outcome || '';
            if (document.getElementById('editKeterangan')) document.getElementById('editKeterangan').value = keterangan || '';
            if (document.getElementById('editJustifikasi')) document.getElementById('editJustifikasi').value = justifikasi || '';
            if (document.getElementById('editTrendPencapaian')) document.getElementById('editTrendPencapaian').value = trendPencapaian || '';
            if (document.getElementById('editKaveat')) document.getElementById('editKaveat').value = kaveat || '';
            if (document.getElementById('editFormula')) document.getElementById('editFormula').value = formula || '';
            if (document.getElementById('categoryReporting')) document.getElementById('categoryReporting').value = kategoriReport || '';

            // Update the form action URL dynamically
            const formActionUrl = `/admin/addKpi/update/${kpiId}`;
            editKpiModal.querySelector('form').action = formActionUrl;

            // Clear all owner checkboxes first
            const ownerCheckboxes = editKpiModal.querySelectorAll('input[name="owners[]"]');
            ownerCheckboxes.forEach(checkbox => checkbox.checked = false);

            // Check the appropriate owner checkboxes
            owners.forEach(ownerId => {
                const ownerCheckbox = editKpiModal.querySelector(`input[name="owners[]"][value="${ownerId}"]`);
                if (ownerCheckbox) ownerCheckbox.checked = true;
            });
            
            // Reset form validation state
            form.classList.remove('was-validated');
        });

        // File input preview handler
        const fileInput = document.getElementById('pdf_file_path');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file selected';
                const fileSize = this.files[0]?.size ? formatFileSize(this.files[0].size) : '';
                
                // Update file info display if it exists
                const fileNameDisplay = document.getElementById('selectedFileName');
                const fileSizeDisplay = document.getElementById('selectedFileSize');
                
                if (fileNameDisplay) fileNameDisplay.textContent = fileName;
                if (fileSizeDisplay) fileSizeDisplay.textContent = fileSize ? `Size: ${fileSize}` : '';
            });
        }

        // Utility function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        const addTargetRowBtn = document.querySelector('.add-target-row');
        const targetRowsContainer = document.querySelector('.target-rows');
        
        let rowIndex = 1; // Start from 1 as we already have row 0
        
        // Remove any existing event listeners to prevent duplication
        addTargetRowBtn.replaceWith(addTargetRowBtn.cloneNode(true));
        
        // Get the fresh reference after replacement
        const newAddTargetRowBtn = document.querySelector('.add-target-row');
        
        // Add a single event listener to the button
        newAddTargetRowBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'target-row mb-3';
            newRow.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="editSasaran_${rowIndex}" class="form-label">Sasaran <span class="text-danger">*</span></label>
                        <input type="number" id="editSasaran_${rowIndex}" name="sasaran[]" class="form-control" required>
                        <div class="invalid-feedback">Please provide a target value.</div>
                    </div>
                    <div class="col-md-5">
                        <label for="editJenisSasaran_${rowIndex}" class="form-label">Jenis Target <span class="text-danger">*</span></label>
                        <select id="editJenisSasaran_${rowIndex}" name="jenis_sasaran[]" class="form-select" required>
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
            
            targetRowsContainer.appendChild(newRow);
            rowIndex++;
            
            // Add event listener to the remove button in the new row
            const removeBtn = newRow.querySelector('.remove-target-row');
            removeBtn.addEventListener('click', function() {
                newRow.remove();
            });
        });
        
        // Event delegation for remove buttons
        // This is more efficient than adding individual event listeners
        targetRowsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-target-row')) {
                e.target.closest('.target-row').remove();
            }
        });

        // Select All functionality
        document.querySelectorAll(".select-all").forEach(button => {
            button.addEventListener("click", function () {
                let target = this.getAttribute("data-target");
                document.querySelectorAll(`#${target} .form-check-input`).forEach(checkbox => {
                    checkbox.checked = true;
                });
            });
        });

        // Unselect All functionality
        document.querySelectorAll(".unselect-all").forEach(button => {
            button.addEventListener("click", function () {
                let target = this.getAttribute("data-target");
                document.querySelectorAll(`#${target} .form-check-input`).forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
        });
    });
</script>