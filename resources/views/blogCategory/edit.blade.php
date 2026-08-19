<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Blog Category') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('blogCategories.update', $blogCategory->id) }}" method="POST" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-8 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name" value="{{ old('name', $blogCategory->name) }}" />
        </div>

        <div class="form-group col-md-4 mb-2">
            <label class="control-label" for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', $blogCategory->serial_no) }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="seo_title">{{ __('SEO Title') }}</label>
            <input class="form-control" id="seo_title" name="seo_title" type="text" value="{{ old('seo_title', $blogCategory->seo_title) }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="seo_description">{{ __('SEO Description') }}</label>
            <textarea name="seo_description" id="seo_description" class="form-control">{{ old('seo_description', $blogCategory->seo_description) }}</textarea>
        </div>

        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="seo_keywords">{{ __('SEO Keywords') }}</label>
            <textarea class="form-control" id="seo_keywords" name="seo_keywords">{{ old('seo_keywords', $blogCategory->seo_keywords) }}</textarea>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $blogCategory->status?->value) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">Update</button>
    </div>
</form>
