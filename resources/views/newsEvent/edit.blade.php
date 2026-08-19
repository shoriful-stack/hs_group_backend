<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Event') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('newsEvents.update', $newsEvent->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ $newsEvent->serial_no }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="event_date">{{ __('Event Date') }} <span class="text-danger">*</span></label>
            <input class="form-control" id="event_date" name="event_date" type="date" value="{{ optional($newsEvent->event_date)->format('Y-m-d') }}" required />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="title" type="text" id="title" value="{{ $newsEvent->title }}" required />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="location">{{ __('Location') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="location" type="text" id="location" value="{{ $newsEvent->location }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="cta_label">{{ __('Button Label') }}</label>
            <input class="form-control" name="cta_label" type="text" id="cta_label" value="{{ $newsEvent->cta_label }}" placeholder="Register Interest" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="cta_href">{{ __('Button Link') }}</label>
            <input class="form-control" name="cta_href" type="text" id="cta_href" value="{{ $newsEvent->cta_href }}" placeholder="/contact" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="image">{{ __('Image') }}</label>
            <input class="form-control" id="image" name="image" type="file" accept="image/*" />
            @if($newsEvent->image)
                <div class="mt-2">
                    <img src="{{ str_starts_with($newsEvent->image, 'http') ? $newsEvent->image : asset($newsEvent->image) }}" alt="{{ $newsEvent->title }}" height="60">
                </div>
            @endif
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $newsEvent->status?->value === $key ? 'selected' : '' }}>
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
