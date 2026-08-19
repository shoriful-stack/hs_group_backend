<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Tag') }}");
</script>

<form action="{{ route('tags.store') }}" method="POST" id="myForm">
    @csrf
    <div class="form-group mb-2">
        <label for="name">{{ __('Tag Name') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}" required />
    </div>

    <div class="form-group mb-2">
        <label for="serial_no">{{ __('Serial No') }} <span class="text-danger">*</span></label>
        <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', 1) }}" required />
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
