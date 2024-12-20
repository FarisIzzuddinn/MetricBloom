<style>
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 30px;
        border-radius: 8px;
        width: auto;
        max-width: 400px;
        transition: opacity 0.5s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .custom-alert .alert-content {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .custom-alert .alert-icon {
        font-size: 20px;
        margin-right: 10px;
        color: white;
    }

    .custom-alert .alert-text {
        flex-grow: 1;
        font-size: 16px;
        color: white;
    }

    .custom-alert .close-alert {
        background: none;
        border: none;
        font-size: 20px;
        color: white;
        cursor: pointer;
    }

    /* Alert Types */
    .alert-info {
        background-color: #17a2b8;
    }

    .alert-success {
        background-color: #28a745;
    }

    .alert-warning {
        background-color: #ffc107;
    }

    .alert-danger {
        background-color: #dc3545;
    }

    /* Fade-out effect */
    .fade-out {
        opacity: 0;
        transform: translateX(20px);
    }

    /* Animation for showing */
    .fade {
        opacity: 1;
        transform: translateX(0);
        animation: slideIn 0.3s ease-out;
    }
</style>

@if(session('status'))
    <div id="alert-message" class="custom-alert alert-{{ session('alert-type', 'info') }} fade show" role="alert">
        <div class="alert-content">
            <span class="alert-icon">&#10003;</span> <!-- Success Icon -->
            <span class="alert-text">{{ session('status') }}</span>
            <button type="button" class="close-alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <script>
        // Auto hide alert after 5 seconds
        setTimeout(function() {
            let alert = document.getElementById('alert-message');
            if (alert) {
                alert.classList.add('fade-out'); // Apply fade-out class
                setTimeout(() => alert.remove(), 500); // Remove after fade-out animation completes
            }
        }, 5000);

        // Manual close button functionality
        document.querySelector('.close-alert').addEventListener('click', function() {
            let alert = document.getElementById('alert-message');
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 500); // Remove after fade-out completes
        });
    </script>
@endif