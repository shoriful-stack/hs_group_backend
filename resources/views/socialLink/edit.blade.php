<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Social Link') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('socialLinks.update', $socialLink->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="form-group col-md-6 mb-2">
            <label for="icon">{{ __('Icon') }} </label>
            
            <select name="icon" class="form-select"
                onchange="document.getElementById('icon-preview').className = this.value;">
                @foreach ($icons as $icon)
                    <option value="{{ $icon }}" @if ($socialLink->icon == $icon) selected @endif>{{ $icon }}</option>
                @endforeach
            </select>
            <div class="mt-2">
                <i id="icon-preview" class="{{ $socialLink->icon }}" style="font-size: 24px;"></i>
            </div>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="link">{{ __('Link') }} </label>
            <input type="url" class="form-control" name="link" id="link" value="{{ old('link', $socialLink->link) }}">
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }} </label>
            <input type="number" class="form-control" name="serial_no" id="serial_no" value="{{ old('serial_no', $socialLink->serial_no) }}">
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select class="form-control" name="status" id="status">
                <option value="1" {{ $socialLink->status->value == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ $socialLink->status->value == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
            </select>
        </div>

    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Update') }}</button>
    </div>
</form>
