<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Project Category') }}");
</script>

<form action="{{ route('projectCategories.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf

    <div class="form-group mb-2">
        <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}" required />
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>