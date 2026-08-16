<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Product Brand') }}");
</script>

<form action="{{ route('productBrands.update', $productBrand->id) }}" method="POST" enctype="multipart/form-data"
    id="myForm">
    @csrf
    @method('PUT')
        <div class="form-group mb-2">
            <label for="language_id">{{ __('Language') }}</label>
            <select name="language_id" id="language_id" class="form-control search_language" required>
                @if (isset($productBrand) && $productBrand->language)
                    <option value="{{ $productBrand->language->id }}" selected>
                        {{ $productBrand->language->name }}
                    </option>
                @endif
            </select>
        </div>

        <div class="form-group mb-2">
            <label for="name">{{ __('Brand Name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $productBrand->name }}"
                required />
        </div>

        <div class="form-group mb-2">
            <label for="serial">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial" name="serial" type="number"
                value="{{ $productBrand->serial }}" />
        </div>

        <div class="form-group mb-2" id="imageField">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        <img src="{{ asset($productBrand->image) }}" alt="{{ $productBrand->name }}" height="50">
    </div>
        <div class="form-group mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control select2">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}"
                        {{ $productBrand->status?->value === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Update') }}</button>
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
