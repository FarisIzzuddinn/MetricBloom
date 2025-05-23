<!-- Butang Tambah Sektor -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectorModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
    </svg>
    Tambah Sektor
</button>

<!-- Add Sector Modal -->
<div class="modal fade" id="addSectorModal" tabindex="-1" aria-labelledby="addSectorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectorModalLabel">Tambah Sektor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('sector') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sector_name" class="form-label">Nama Sektor</label>
                        <input type="text" class="form-control" id="sector_name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button> 
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batalkan</button> 
                </div>
            </form>
        </div>
    </div>
</div>
