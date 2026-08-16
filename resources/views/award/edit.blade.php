<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Award') }}");
</script>

<form action="{{ route('awards.update', $award->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} </label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $award->title }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        <img src="{{ asset($award->image) }}" alt="{{ $award->title }}" height="50">
        <small class="text-muted text-danger">
            {{ __('Recommended size: 1000 x 563px, Max file size: 200KB') }}
        </small>
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="contents">{{ __('Content') }}</label>
        <textarea name="contents" id="contents" class="form-control">{{ old('contents', $award->content) }}</textarea>
    </div>

    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" id="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
                <option value="{{ $key }}" {{ $award->status?->value === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>


    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">Update</button>
    </div>
</form>
