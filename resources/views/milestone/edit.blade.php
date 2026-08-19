<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Milestone') }}");
</script>

<form action="{{ route('milestones.update', $milestone->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} </label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $milestone->title }}" />
    </div>



    <div class="row">
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="year">{{ __('Year') }}</label>
            <input class="form-control" name="year" type="text" id="year"
                value="{{ $milestone->year }}" />
        </div>
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="serial_no">{{ __('Serial') }}</label>
            <input class="form-control" name="serial_no" type="number" id="serial_no"
                value="{{ $milestone->serial_no }}" />
        </div>
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        @if($milestone->image)
            <img src="{{ asset($milestone->image) }}" alt="{{ $milestone->title }}" height="50" class="mt-2" />
        @endif
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="contents">{{ __('Content') }}</label>
        <textarea name="contents" id="contents" class="form-control">{{ old('contents', $milestone->content) }}</textarea>
    </div>

    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" id="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
            <option value="{{ $key }}" {{ $milestone->status?->value === $key ? 'selected' : '' }}>
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