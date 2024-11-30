<!-- Button trigger modal -->
<button type="button" class="btn btn-primary float-end mt-5 mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
</svg>Add New KPI
</button>

  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">ADD KPI</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kpi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="teras" class="col-sm-5 col-form-label">Teras</label>
                        <div class="col-sm-7">
                            <select id="addTeras" name="teras_id" class="form-select" required>
                                @foreach ($teras as $teras)
                                    <option value="{{ $teras->id }}">{{ $teras->teras }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="SO" class="col-sm-5 col-form-label">Sector</label>
                        <div class="col-sm-7">
                            <select id="sectors_id" name="sectors_id" class="form-select" required>
                                @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group mt-4">
                        <label>Select Owners:</label>
                        <div class="border p-3">
                            <h5>States</h5>
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
                
                            <h5 class="mt-3">Institutions</h5>
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
                
                            <h5 class="mt-3">Bahagian</h5>

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


                    <div class="row mb-3">
                        <label for="pernyataan_kpi" class="col-sm-5 col-form-label">KPI</label>
                        <div class="col-sm-7">
                            <input type="text" id="addPernyataanKpi" name="pernyataan_kpi" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sasaran" class="col-sm-5 col-form-label">Target</label>
                        <div class="col-sm-7">
                            <input type="number" inputmode="numeric" id="addSasaran" name="sasaran" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="addJenisSasaran" class="col-sm-5 col-form-label">Target Type</label>
                        <div class="col-sm-7">
                            <select id="addJenisSasaran" name="jenis_sasaran" class="form-select" required>
                                <option value="" disabled selected>Select Target Type</option>
                                <option value="peratus">Percentage(%)</option>
                                <option value="bilangan">Number</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sasaran" class="col-sm-5 col-form-label">Upload PDF File</label>
                        <div class="col-sm-7">
                            <input type="file" name="pdf_file_path" id="pdf_file_path" class="form-control" accept="application/pdf">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>