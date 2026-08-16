<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Social Link') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('socialLinks.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">

        <div class="form-group col-md-6 mb-2">
            <label for="icon">{{ __('Icon') }} <span class="text-danger">*</span></label>
            <select name="icon" class="form-select"
                onchange="document.getElementById('icon-preview').className = this.value;">
                @foreach ($icons as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </select>
            <div class="mt-2">
                <i id="icon-preview" class="bi bi-facebook" style="font-size: 24px;"></i>
            </div>
        </div>


        <div class="form-group col-md-6 mb-2">
            <label for="link">{{ __('Link') }} <span class="text-danger">*</span></label>
            <input type="url" class="form-control" name="link" id="link" value="{{ old('link') }}"
                required>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="serial_no" id="serial_no"
                value="{{ old('serial_no', 1) }}" required>
        </div>

    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
