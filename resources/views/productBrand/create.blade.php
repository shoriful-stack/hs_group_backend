<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Product Brand') }}");
</script>

<form action="{{ route('productBrands.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="form-group mb-2">
        <label for="language_id">{{ __('Language') }} <span class="text-danger">*</span></label>
        <select name="language_id" id="language_id" class="form-control search_language" required>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="name">{{ __('Brand Name') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}" required />
    </div>

    <div class="form-group mb-2">
        <label for="serial">{{ __('Serial No') }} <span class="text-danger">*</span></label>
        <input class="form-control" id="serial" name="serial" type="number" value="{{ old('serial', 1) }}"
            required />
    </div>

    <div class="form-group mb-2" id="imageField">
        <label class="control-label" for="image">{{ __('Choose Image') }} <span class="text-danger">*</span></label>
        <input class="form-control" id="image" name="image" type="file" required accept="image/*"/>
        <small class="text-muted text-danger">
            {{ __('Recommended size: 126 x 30px, Max file size: 200KB') }}
        </small>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('.select2').select2({
            theme: "classic",
            minimumInputLength: 0,
            placeholder: "Select One",
            dropdownParent: $("#modal"),
            allowClear: true,
        });

        $('.search_language').select2({
            theme: 'classic',
            minimumInputLength: 0,
            placeholder: "Select Language",
            dropdownParent: $("#modal"),
            allowClear: true,
            ajax: {
                url: "{{ route('language.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        status: 1,
                        page_limit: 10
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    }

                },
                cache: true
            }
        });

    });
</script>
