<x-editButton target="#editTerasModal{{ $tera->id }}" />

<div class="modal fade" id="editTerasModal{{ $tera->id }}" tabindex="-1"  aria-labelledby="editModalLabel{{ $tera->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex">
                <h5 class="modal-title" id="editModalLabel{{ $tera->id }}">Edit Teras</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add an ID to the form for easy access in JavaScript -->
                <form id="editForm" method="POST" action="{{ route('teras.update', $tera->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="teras{{ $tera->id }}" class="form-label">Nama Teras</label>
                        <input type="text" name="teras" id="teras{{ $tera->id }}" class="form-control" value="{{ $tera->name }}">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

