<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Industry') }}");
</script>

<form action="{{ route('industries.store') }}" method="POST" id="myForm">
    @csrf
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
        <input class="form-control" required name="title" type="text" id="title" value="{{ old('title') }}" />
    </div>
    <div class="row">
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="icon">{{ __('Icon') }}</label>
            <input class="form-control" name="icon" type="text" id="icon" value="{{ old('icon') }}"
                placeholder="Zap, Radio, Sun" />
        </div>
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="serial_no">{{ __('Serial') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="serial_no" type="number" id="serial_no" value="{{ old('serial_no') }}" />
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="control-label" for="contents">{{ __('Content') }}</label>
        <textarea name="contents" id="contents" class="form-control" rows="3">{{ old('contents') }}</textarea>
    </div>
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info text-white">{{ __('Save') }}</button>
    </div>
</form>
