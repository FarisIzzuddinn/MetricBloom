<!-- Butang Delete dengan Modal -->
<button type="button" class="btn btn-danger" 
    data-bs-toggle="modal" 
    data-bs-target="#deleteModal{{ $sector->id }}"
    onclick="setDeleteModal('{{ $sector->name }}', '{{ route('sector.destroy', $sector->id) }}', '{{ $sector->id }}')">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" 
        class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
    </svg>
</button>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $sector->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $sector->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <h5 class="modal-title" id="deleteModalLabel{{ $sector->id }}">Pengesahan Pemadaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Adakah anda pasti memadamkan sektor ini?</p>
                <p class="text-danger fw-bold" id="deleteSektorName{{ $sector->id }}"></p>
                <p>Tindakan ini tidak boleh kembali.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <form id="deleteSektorForm{{ $sector->id }}" method="POST" action="{{ route('sector.destroy', $sector->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Padam</button>
                </form>
            </div>
        </div>
    </div>
</div>
