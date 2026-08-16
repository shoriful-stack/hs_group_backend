<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Tag') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('tags.update', $tag->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="form-group col-md-6 mb-2">
            <label for="language_id">{{ __('Language') }}</label>
            <select name="language_id" id="language_id" class="form-control" required>
                @foreach($languages as $id => $name)
                    <option value="{{ $id }}" {{ $tag->language_id == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="name">{{ __('Tag Name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $tag->name }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ $tag->serial_no }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $tag->status?->value === $key ? 'selected' : '' }}>
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
