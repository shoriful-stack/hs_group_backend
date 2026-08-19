<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Author') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('blogAuthors.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }} <span class="text-danger">*</span></label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', 1) }}" required />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="designation">{{ __('Designation') }}</label>
            <input class="form-control" name="designation" type="text" id="designation" value="{{ old('designation') }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="department">{{ __('Department') }}</label>
            <input class="form-control" name="department" type="text" id="department" value="{{ old('department') }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="email">{{ __('Email') }}</label>
            <input class="form-control" name="email" type="email" id="email" value="{{ old('email') }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="linkedin">{{ __('LinkedIn') }}</label>
            <input class="form-control" name="linkedin" type="text" id="linkedin" value="{{ old('linkedin') }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="bio">{{ __('Bio') }}</label>
            <textarea class="form-control" name="bio" id="bio" rows="3">{{ old('bio') }}</textarea>
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="photo">{{ __('Photo') }}</label>
            <input class="form-control" id="photo" name="photo" type="file" accept="image/*" />
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
