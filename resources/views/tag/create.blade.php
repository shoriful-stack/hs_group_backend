<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Tag') }}");
    // $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('tags.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf

        <div class="form-group mb-2">
            <label for="language_id">{{ __('Language') }} <span class="text-danger">*</span></label>
            <select name="language_id" id="language_id" class="form-control" required>
                @foreach($languages as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>


    <div class="form-group mb-2">
        <label for="name">{{ __('Tag Name') }} <span class="text-danger">*</span></label>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name') }}" required />
    </div>

    <div class="form-group mb-2">
        <label for="serial_no">{{ __('Serial No') }} <span class="text-danger">*</span></label>
        <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', 1) }}"
            required />
    </div>



    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect"
            data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>

