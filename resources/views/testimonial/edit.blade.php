<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Testimonial') }}");
</script>

<form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="form-group mb-2">
        <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
        <input class="form-control" required name="name" type="text" id="name" value="{{ $testimonial->name }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="role">{{ __('Role') }}</label>
        <input class="form-control" name="role" type="text" id="role" value="{{ $testimonial->role }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        @if($testimonial->image)
            <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}" height="50">
        @endif
        <small class="text-muted text-danger">
            {{ __('Recommended size: 200 x 200px, Max file size: 200KB') }}
        </small>
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="quote">{{ __('Quote') }} <span class="text-danger">*</span></label>
        <textarea name="quote" id="quote" class="form-control" required rows="4">{{ old('quote', $testimonial->quote) }}</textarea>
    </div>

    <div class="form-group mb-2">
        <label class="control-label">{{ __('Status') }}</label>
        <select name="status" id="status" class="form-control">
            @foreach (\App\Enums\Status::options() as $key => $label)
                <option value="{{ $key }}" {{ $testimonial->status?->value === $key ? 'selected' : '' }}>
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
