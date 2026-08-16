<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Award') }}");
</script>

<form action="{{ route('awards.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
        <input class="form-control" required name="title" type="text" id="title" value="{{ old('title') }}"
            placeholder="Enter your title" />
    </div>

    <div class="form-group mb-2" id="imageField">
        <label class="control-label" for="image">{{ __('Choose Image') }} <span class="text-danger">*</span></label>
        <input class="form-control" id="image" name="image" type="file" required accept="image/*" />
        <small class="text-muted text-danger">
            {{ __('Recommended size: 1000 x 563px, Max file size: 200KB') }}
        </small>
    </div>
    <div class="form-group mb-2" id="">
        <label class="control-label" for="contents">{{ __('Content') }} <span class="text-danger">*</span></label>
        <textarea name="contents" id="contents" class="form-control"></textarea>
    </div>



    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
