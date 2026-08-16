<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Leadership Message') }}");
</script>

<form action="{{ route('leadership-messages.update', $leadershipMessage->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="name">{{ __('Name') }} </label>
        <input class="form-control" name="name" type="text" id="name" value="{{ $leadershipMessage->name }}" />
    </div>
    <div class="form-group mb-2">
        <label class="control-label" for="designation">{{ __('Designation') }} </label>
        <input class="form-control" name="designation" type="text" id="designation" value="{{ $leadershipMessage->designation }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        <img src="{{ asset($leadershipMessage->image) }}" alt="{{ $leadershipMessage->title }}" height="50">
        <small class="text-muted text-danger">
            {{ __('Recommended size: 1000 x 563px, Max file size: 200KB') }}
        </small>
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="contents">{{ __('Content') }}</label>
        <textarea name="contents" id="contents" class="form-control">{{ old('contents', $leadershipMessage->content) }}</textarea>
    </div>

    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" id="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
                <option value="{{ $key }}" {{ $leadershipMessage->status?->value === $key ? 'selected' : '' }}>
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
<script>
    ClassicEditor
        .create(document.querySelector('#contents'), {
            ckfinder: {
                uploadUrl: "{{ route('ckEditorUpload') . '?_token=' . csrf_token() }}"
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
