<x-editButton target="#editModal{{ $sector->id }}" />

<div class="modal fade" id="editModal{{ $sector->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $sector->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $sector->id }}">Edit Sektor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('sector/'.$sector->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sector_name" class="form-label">Nama Sektor</label>
                        <input type="text" class="form-control" id="sector_name" name="name" value="{{ $sector->name }}" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>