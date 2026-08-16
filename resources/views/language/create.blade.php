<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Language') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('languages.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name" value="{{ old('name') }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="code">{{ __('Code') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="code" type="text" id="code" value="{{ old('code') }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="direction">{{ __('Direction') }}</label>
            <select name="direction" id="direction" class="form-control">
                <option value="ltr" {{ old('direction') == 'ltr' ? 'selected' : '' }}>LTR</option>
                <option value="rtl" {{ old('direction') == 'rtl' ? 'selected' : '' }}>RTL</option>
            </select>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="is_default">{{ __('Default Language') }}</label>
            <select name="is_default" id="is_default" class="form-control">
                <option value="" disabled selected>Select One</option>
                @foreach (\App\Enums\YesNo::options() as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
