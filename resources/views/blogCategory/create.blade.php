<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Category') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('blogCategories.store') }}" method="POST" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-8 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name" value="{{ old('name') }}" />
        </div>

        <div class="form-group col-md-4 mb-2">
            <label class="control-label" for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', 1) }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="seo_title">{{ __('SEO Title') }}</label>
            <input class="form-control" name="seo_title" type="text" id="seo_title" value="{{ old('seo_title') }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="seo_description">{{ __('SEO Description') }}</label>
            <textarea name="seo_description" id="seo_description" class="form-control">{{ old('seo_description') }}</textarea>
        </div>

        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="seo_keywords">{{ __('SEO Keywords') }}</label>
            <textarea name="seo_keywords" id="seo_keywords" class="form-control">{{ old('seo_keywords') }}</textarea>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
