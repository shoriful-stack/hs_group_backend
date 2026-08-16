<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Language') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('languages.update', $language->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="name">{{ __('Name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $language->name }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="code">{{ __('Code') }}</label>
            <input class="form-control" name="code" type="text" id="code" value="{{ $language->code }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label">{{ __('Direction') }}</label>
            <select name="direction" id="direction" class="form-control">
                <option value="ltr" {{ $language->direction == 'ltr' ? 'selected' : '' }}>LTR</option>
                <option value="rtl" {{ $language->direction == 'rtl' ? 'selected' : '' }}>RTL</option>
            </select>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="is_default">{{ __('Default Language') }}</label>
            <select name="is_default" id="is_default" class="form-control">
            <option value="" disabled selected>Select One</option>
            @foreach (\App\Enums\YesNo::options() as $key => $label)
                <option value="{{ $key }}" {{ $language->is_default?->value == $key ? 'selected' : ''}}>{{ $label }}</option>
            @endforeach
            </select>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $language->status?->value === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">Update</button>
    </div>
</form>
