<!-- Button trigger modal -->
<button type="button" class="btn btn-primary float-end mt-5 mb-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Add New KPI
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
                        <label for="states" class="col-sm-5 col-form-label">Negeri:</label>
                        <div class="col-sm-7">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Select States
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                    @foreach($states as $state)
                                        <li>
                                            <div class="form-check px-3">
                                                <input class="form-check-input" type="checkbox" name="states[]" id="state_{{ $state->id }}" value="{{ $state->id }}">
                                                <label class="form-check-label" for="state_{{ $state->id }}">{{ $state->name }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- {{-- <div class="row mb-3">
                        <label for="addPemilik" class="col-sm-5 col-form-label">PEMILIK</label>
                        <div class="col-sm-7">
                            <select id="addPemilik" name="user_id" class="form-select" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>   
                                @endforeach
                            </select>
                        </div>
                    </div> --}} -->

                    <div class="row mb-3">
                        <label for="pernyataan_kpi" class="col-sm-5 col-form-label">PERNYATAAN KPI</label>
                        <div class="col-sm-7">
                            <input type="text" id="addPernyataanKpi" name="pernyataan_kpi" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sasaran" class="col-sm-5 col-form-label">SASARAN</label>
                        <div class="col-sm-7">
                            <input type="number" inputmode="numeric" id="addSasaran" name="sasaran" class="form-control" required>
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