<!-- Bootstrap bundle JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>


<!--app-->
<script src="/assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        $("#menu").metisMenu();
    });
    new PerfectScrollbar(".user-list")

    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap-5",
            minimumInputLength: 0,
            allowClear: true,
        })

        $('#example').DataTable();
    });

    $(document).ready(function() {
        $('.topAlert').show().delay(1000).fadeOut(8000);
        //$('.topAlert').show();
    });
</script>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "classic",
                minimumInputLength: 0,
                placeholder: "Select One",
                allowClear: true,
            });

            $('.search_branch').select2({
                theme: 'classic',
                width: '100%',
                minimumInputLength: 0,
                dropdownParent: $('#branch_id').closest('.dropdown-menu'),
                placeholder: "Search Branch...",
                allowClear: true,
                ajax: {
                    url: "{{ route('branch.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        q: params.term,
                        page_limit: 10
                    }),
                    processResults: data => ({
                        results: $.map(data, item => ({
                            text: item.name,
                            id: item.id
                        }))
                    }),
                    cache: true
                }
            });

            $('.search_branch').on('change', function() {
                let branchId = $(this).val();
                if (!branchId) return;

                $.ajax({
                    url: "{{ route('branch.switch') }}",
                    method: "POST",
                    data: {
                        branch_id: branchId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                    if (res.status === 'success') {
                        location.reload();
                    }
                    },
                    error: function(err) {
                        alert("Something went wrong!");
                    }
                });
            });
        });
    </script>


@push('scripts')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
@endpush
