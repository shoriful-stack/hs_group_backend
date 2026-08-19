<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Industry') }}");
</script>

<form action="{{ route('industries.update', $industry->id) }}" method="POST" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }}</label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $industry->title }}" />
    </div>
    <div class="row">
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="icon">{{ __('Icon') }}</label>
            <input class="form-control" name="icon" type="text" id="icon" value="{{ $industry->icon }}" />
        </div>
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="serial_no">{{ __('Serial') }}</label>
            <input class="form-control" name="serial_no" type="number" id="serial_no" value="{{ $industry->serial_no }}" />
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="control-label" for="contents">{{ __('Content') }}</label>
        <textarea name="contents" id="contents" class="form-control" rows="3">{{ $industry->content }}</textarea>
    </div>
    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
                <option value="{{ $key }}" {{ $industry->status?->value === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info text-white">{{ __('Update') }}</button>
    </div>
</form>
