<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Slider') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">
        {{--         <div class="form-group col-md-6 mb-2">
            <label for="language_id">{{ __('Language') }} <span class="text-danger">*</span></label>
            <select name="language_id" id="language_id" class="form-control" required>
                @foreach($languages as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="form-group col-md-6 mb-2">
            <label for="title" class="control-label">{{ __('Title') }}<span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="sub_title" class="control-label">{{ __('Sub Title') }}<span class="text-danger">*</span></label>
            <input type="text" name="sub_title" id="sub_title" value="{{ old('sub_title') }}" class="form-control">
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="contents" class="control-label">{{ __('Content') }}<span class="text-danger">*</span></label>
            <textarea name="contents" id="contents" class="form-control">{{ old('content') }}</textarea>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="sub_content" class="control-label">{{ __('Badge Content') }}<span class="text-danger">*</span></label>
            <textarea name="sub_content" id="sub_content" class="form-control">{{ old('sub_content') }}</textarea>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="url" class="control-label">{{ __('URL') }}</label>
            <input type="url" name="url" id="url" value="{{ old('url') }}" class="form-control">
        </div>
        <div class="form-group col-md-6 mb-2">
            <label for="serial_no" class="control-label">{{ __('Serial No') }} <span class="text-danger">*</span></label>
            <input type="number" name="serial_no" id="serial_no" value="{{ old('serial_no') }}" class="form-control" required>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="image" class="control-label">{{ __('Image') }}<span class="text-danger">*</span></label>
            <input type="file" name="image" required id="image" class="form-control" accept="image/*">
            <small class="text-muted text-danger">
                {{ __('Recommended size: 1920 x 900px, Max file size: 100kb') }}
            </small>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="video" class="control-label">{{ __('Video') }}</label>
            <input type="file" name="video" id="video" class="form-control" accept="video/mp4,video/webm,video/quicktime">
            <small class="text-muted">
                {{ __('Optional. MP4/WebM, max 50MB. Image is used as poster.') }}
            </small>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
