<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Tag') }}");
</script>

<form action="{{ route('tags.update', $tag->id) }}" method="POST" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-12 mb-2">
            <label for="name">{{ __('Tag Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name', $tag->name) }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', $tag->serial_no) }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $tag->status?->value) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Update') }}</button>
    </div>
</form>
