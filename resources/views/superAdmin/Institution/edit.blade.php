{{-- Edit Institution Modal --}}
<x-editButton target="#editInstitutionModal{{ $institution->id }}" />

<div class="modal fade" id="editInstitutionModal{{ $institution->id }}" tabindex="-1" aria-labelledby="editInstitutionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInstitutionModalLabel">Edit Institusi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('institutions.update', $institution->id) }}" method="POST" class="institution-form">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Institusi</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Institution Name" name="name" value="{{ $institution->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="state_id" class="form-label required">Negeri</label>
                        <select class="form-select" id="state_id" name="state_id">
                            <option value="">Pilih Institusi</option>
                            @foreach($states as $state)
                            <option value="{{ $state->id }}" {{ $state->id == $institution->state_id ? 'selected' : '' }}>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>