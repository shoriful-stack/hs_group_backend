<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Testimonial') }}");
</script>

<form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="form-group mb-2">
        <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
        <input class="form-control" required name="name" type="text" id="name" value="{{ old('name') }}"
            placeholder="Enter name" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="role">{{ __('Role') }}</label>
        <input class="form-control" name="role" type="text" id="role" value="{{ old('role') }}"
            placeholder="Enter role / company" />
    </div>

    <div class="form-group mb-2" id="imageField">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        <small class="text-muted text-danger">
            {{ __('Recommended size: 200 x 200px, Max file size: 200KB') }}
        </small>
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="quote">{{ __('Quote') }} <span class="text-danger">*</span></label>
        <textarea name="quote" id="quote" class="form-control" required rows="4">{{ old('quote') }}</textarea>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
