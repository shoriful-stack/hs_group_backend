<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Capability') }}");
</script>

<form action="{{ route('capabilities.update', $capability->id) }}" method="POST" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }}</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $capability->title }}" />
    </div>
    <div class="row">
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="icon">{{ __('Icon') }}</label>
            <input class="form-control" name="icon" type="text" id="icon" value="{{ $capability->icon }}" />
        </div>
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="serial_no">{{ __('Serial') }}</label>
            <input class="form-control" name="serial_no" type="number" id="serial_no" value="{{ $capability->serial_no }}" />
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="control-label" for="contents">{{ __('Content') }}</label>
        <textarea name="contents" id="contents" class="form-control" rows="3">{{ $capability->content }}</textarea>
    </div>
    <div class="form-group mb-2">
        <label class="control-label" for="features">{{ __('Features') }}</label>
        <input class="form-control" name="features" type="text" id="features" value="{{ $capability->features }}" />
    </div>
    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
                <option value="{{ $key }}" {{ $capability->status?->value === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info text-white">{{ __('Update') }}</button>
    </div>
</form>
