<style>
    /* Toast Notification */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1060;
    }

    .toast {
        color: white;
        border: none;
        border-radius: 8px;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
    }

    .toast .error {
        background: linear-gradient(135deg, #F44336, #C62828) !important;
        
    }
</style>

<!-- Toast Notification Container -->
<div class="toast-container">
    @if(session('success'))
        <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

<script>
    // Auto hide toasts after 3 seconds
    const toasts = document.querySelectorAll('.toast.show');
    toasts.forEach(toast => {
        setTimeout(() => {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 3000);
    });
</script>