<style>
    .glass-modal {
        backdrop-filter: blur(8px);
        background: #ffffff;
        border-radius: 18px !important;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
        animation: fadeInScale 0.25s ease-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.85);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .delete-icon {
        font-size: 4rem;
        color: #ff4d4f;
        animation: pulse 1.4s infinite ease-in-out;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.75;
        }

        50% {
            transform: scale(1.15);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 0.75;
        }
    }

    .btn-modern-danger {
        background: linear-gradient(45deg, #ff4d4f, #d9363e);
        border: none;
        box-shadow: 0 4px 12px rgba(255, 77, 79, 0.4);
        transition: 0.2s ease;
    }

    .btn-modern-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 77, 79, 0.5);
    }

    .btn-modern-secondary {
        border: none;
        background: #e4e6eb;
        color: #333;
        transition: 0.2s ease;
    }

    .btn-modern-secondary:hover {
        background: #d6d8db;
        transform: translateY(-2px);
    }
</style>


<div id="deleteModal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal">

            <div class="modal-body text-center p-5">

                <i class="bi bi-trash3-fill delete-icon mb-3"></i>

                <h3 class="fw-bold mb-2 text-danger">
                    Delete Confirmation
                </h3>

                <p class="text-muted mb-4" style="font-size: 15px;">
                    Are you sure you want to delete this item?<br>
                    This action is permanent and cannot be undone.
                </p>

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <button class="btn btn-modern-secondary px-4 py-2"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-modern-danger px-4 py-2 text-white"
                        id="deleteConfirmBtn">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function openDeleteModal(url) {
        $('#deleteConfirmBtn').data('url', url);
        $('#deleteModal').modal('show');
    }

    $('#deleteConfirmBtn').click(function() {

        let url = $(this).data('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },

            beforeSend: function() {
                $('#deleteConfirmBtn')
                    .html('<span class="spinner-border spinner-border-sm"></span> Deleting...')
                    .prop('disabled', true);
            },

            success: function(res) {

                $('#deleteModal').modal('hide');

                $('#deleteConfirmBtn')
                    .prop('disabled', false)
                    .html('<i class="bi bi-trash"></i> Delete');

                if (res.status === 'success') {
                    alert("Product Deleted Successfully!");
                    window.location.reload();
                }
            },

            error: function() {
                $('#deleteConfirmBtn')
                    .prop('disabled', false)
                    .html('<i class="bi bi-trash"></i> Delete');

                alert("Server error!");
            }
        });
    });
</script>