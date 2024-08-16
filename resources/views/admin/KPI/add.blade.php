<!-- Button trigger modal -->
<button type="button" class="btn btn-primary d-flex align-items-center small-button me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
    </svg>
    <span class="ms-2">ADD NEW</span>
</button>

  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">ADD KPI</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kpi.store') }}" method="POST">
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
                        <label for="SO" class="col-sm-5 col-form-label">SO</label>
                        <div class="col-sm-7">
                            <select id="addSo" name="so_id" class="form-select" required>
                                @foreach ($so as $so)
                                    <option value="{{ $so->id }}">{{ $so->SO }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="row mb-3">
                        <label for="addNegeri" class="col-sm-5 col-form-label">NEGERI</label>
                        <div class="col-sm-7">
                            <select id="addNegeri" name="negeri" class="form-select" required>
                                <option value="" disabled selected>Select Negeri</option>
                                <option value="Johor">JOHOR</option>
                                <option value="Kedah">KEDAH</option>
                                <option value="Kelantan">KELANTAN</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Pulau Pinang">Pulau Pinang</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                                <option value="Wilayah Persekutuan Kuala Lumpur">Wilayah Persekutuan Kuala Lumpur</option>
                                <option value="Wilayah Persekutuan Labuan">Wilayah Persekutuan Labuan</option>
                                <option value="Wilayah Persekutuan Putrajaya">Wilayah Persekutuan Putrajaya</option>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="row mb-3">
                        <label for="addPemilik" class="col-sm-5 col-form-label">PEMILIK</label>
                        <div class="col-sm-7">
                            <select id="addPemilik" name="user_id" class="form-select" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
            
                    <div class="row mb-3">
                        <label for="pernyataan_kpi" class="col-sm-5 col-form-label">PERNYATAAN KPI</label>
                        <div class="col-sm-7">
                            <input type="text" id="addPernyataanKpi" name="pernyataan_kpi" class="form-control" required>
                        </div>
                    </div>
            
                    <div class="row mb-3">
                        <label for="sasaran" class="col-sm-5 col-form-label">SASARAN</label>
                        <div class="col-sm-7">
                            <input type="text" id="addSasaran" name="sasaran" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="addJenisSasaran" class="col-sm-5 col-form-label">JENIS SASARAN</label>
                        <div class="col-sm-7">
                            <select id="addJenisSasaran" name="jenis_sasaran" class="form-select" required>
                                <option value="" disabled selected>Select Jenis Sasaran</option>
                                <option value="peratus">%</option>
                                <option value="bilangan">Bilangan</option>
                            </select>
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

