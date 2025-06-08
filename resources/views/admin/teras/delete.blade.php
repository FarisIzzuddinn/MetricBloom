<!-- Delete Permission Modal -->
<x-deleteButton 
    target="#deleteModal"
    permissionId="{{ $tera->id }}"
    permissionName="{{ $tera->teras }}"
    url="{{ route('teras.destroy', $tera->id) }}" />



<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-2" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <h5 class="modal-title" id="deleteModalLabel">Pengesahan Pemadaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body text-center">
            <p>Adakah anda pasti memadamkan institusi ini?</p>
            <p class="text-danger fw-bold" id="deleteTerasName"></p>
            <p>Tindakan ini tidak boleh kembali.</p>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
            <form id="deleteTerasForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Padam</button>
            </form>
        </div>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const url = button.getAttribute('data-url');
        const name = button.getAttribute('data-name');

        const form = document.getElementById('deleteTerasForm');
        const nameDisplay = document.getElementById('deleteTerasName');

        form.action = url;
        nameDisplay.textContent = name;
    });
</script>

