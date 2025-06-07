{{-- Add Institution Modal --}}
<x-createButton name="Tambah Institusi" target="#addInstitutionModal" />

<div class="modal fade" id="addInstitutionModal" tabindex="-1" aria-labelledby="addInstitutionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInstitutionModalLabel">Tambah Institusi Baharu </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('institutions.store') }}" method="POST" class="institution-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Institusi</label>
                        <input type="text" class="form-control" placeholder="Enter Institution Name" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="state_id" class="form-label required">Negeri</label>
                        <select class="form-select" id="state_id" name="state_id">
                            <option value="">Pilih Negeri</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Institusi</button>
                </form>
            </div>
        </div>
    </div>
</div>