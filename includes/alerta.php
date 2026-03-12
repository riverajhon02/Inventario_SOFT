<?php if ($toast): ?>

    <div class="position-fixed top-0 end-0 p-3" style="z-index:9999">

        <div id="liveToast" class="toast text-bg-<?php echo $toast_type; ?> border-0">

            <div class="d-flex">

                <div class="toast-body">
                    <?php echo $toast ?>
                </div>

                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var toastEl = document.getElementById("liveToast");

            var toast = new bootstrap.Toast(toastEl, {
                delay: 3000
            });

            toast.show();

        });
    </script>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>