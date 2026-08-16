<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Slider') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">

    {{--         <div class="form-group col-md-6 mb-2">
            <label for="language_id">{{ __('Language') }}</label>
            <select name="language_id" id="language_id" class="form-control" required>
                @foreach($languages as $id => $name)
                    <option value="{{ $id }}" {{ $slider->language_id == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="title">{{ __('Title') }}</label>
            <input class="form-control"  name="title" type="text" id="title" value="{{ $slider->title }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="sub_title">{{ __('Sub Title') }}</label>
            <input class="form-control" name="sub_title" type="text" id="sub_title" value="{{ $slider->sub_title }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="contents">{{ __('Content') }}</label>
            <textarea name="contents" id="contents" class="form-control">{{ $slider->content }}</textarea>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="sub_content">{{ __('Badge Content') }}</label>
            <textarea name="sub_content" id="sub_content" class="form-control">{{ $slider->sub_content }}</textarea>
        </div>
        
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="url">{{ __('URL') }}</label>
            <input class="form-control" name="url" type="url" id="url" value="{{ $slider->url }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" required type="number" value="{{ $slider->serial_no }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="image">{{ __('Image') }}</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            <small class="text-muted text-danger">
                {{ __('Recommended size: 1920 x 900px, Max file size: 100kb') }}
            </small>
            @if($slider->image)
                <img src="{{ asset($slider->image) }}" alt="Slider Image" class="img-thumbnail mt-2" width="120">
            @endif
        </div>


        <div class="form-group col-md-6 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $slider->status?->value === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Update') }}</button>
    </div>
</form>
