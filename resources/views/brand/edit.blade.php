<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Brand') }}");
</script>

<form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} </label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $brand->title }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        <img src="{{ asset($brand->image) }}" alt="{{ $brand->title }}" height="50">
        <small class="text-muted text-danger">
            {{ __('Recommended size: 1000 x 563px, Max file size: 200KB') }}
        </small>
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="domain">{{ __('Domain') }}</label>
        <input class="form-control" name="domain" type="text" id="domain"
            value="{{ $brand->domain }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="content">{{ __('Content') }}</label>
        <textarea name="content" id="content" class="form-control">{{ old('content', $brand->content) }}</textarea>
    </div>

    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" id="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
            <option value="{{ $key }}" {{ $brand->status?->value === $key ? 'selected' : '' }}>
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