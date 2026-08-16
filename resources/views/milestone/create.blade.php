<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Milestone') }}");
</script>

<form action="{{ route('milestones.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
        <input class="form-control" required name="title" type="text" id="title" value="{{ old('title') }}"
            placeholder="Enter your title" />
    </div>

    <div class="row">
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="year">{{ __('Year') }}</label><span class="text-danger">*</span>
            <input class="form-control" required name="year" type="text" id="year" />
        </div>
        <div class="form-group mb-2 col-md-6">
            <label class="control-label" for="serial_no">{{ __('Serial') }}</label><span class="text-danger">*</span>
            <input class="form-control" required name="serial_no" type="number" id="serial_no" />
        </div>
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