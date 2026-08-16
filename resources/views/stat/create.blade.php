<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Stat') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('stats.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label for="title" class="control-label">{{ __('Title') }}<span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="value" class="control-label">{{ __('Value') }}<span class="text-danger">*</span></label>
            <input type="number" min="0" name="value" id="value" value="{{ old('value') }}" class="form-control">
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="serial_no" class="control-label">{{ __('Serial No') }} <span class="text-danger">*</span></label>
            <input type="number" name="serial_no" id="serial_no" value="{{ old('serial_no') }}" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
