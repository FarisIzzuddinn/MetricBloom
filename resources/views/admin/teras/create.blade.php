<x-createButton name="Tambah Teras" target="#addTerasModal" />

<div class="modal fade" id="addTerasModal" tabindex="-1" aria-labelledby="addTerasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTerasModalLabel">Tambah Teras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="card-body">
                <form action="{{ url('teras') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="teras">Nama Teras</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Simpan</button> 
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batalkan</button> 
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div> 