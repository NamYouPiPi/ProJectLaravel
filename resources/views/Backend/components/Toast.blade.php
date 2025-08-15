<div class="toast-container position-fixed top-0 end-0 p-3">
    @if(session('success'))
        <div class="toast show" id="success-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('success') }}
            </div>
        </div>
    @elseif(session('error'))
        <div class="toast show" id="error-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>


<script>
    $(document).ready(function () {
        // Initialize and show toasts
        $('.toast').each(function () {
            var toast = new bootstrap.Toast(this, {
                autohide: true,
                delay: 1000 // Auto hide after 5 seconds
            });
            toast.show();
        });
    });
</script>