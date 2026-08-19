<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Event') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('newsEvents.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }} <span class="text-danger">*</span></label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ old('serial_no', 1) }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="event_date">{{ __('Event Date') }} <span class="text-danger">*</span></label>
            <input class="form-control" id="event_date" name="event_date" type="date" value="{{ old('event_date') }}" required />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="title">{{ __('Title') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="title" type="text" id="title" value="{{ old('title') }}" required />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="location">{{ __('Location') }} <span class="text-danger">*</span></label>
            <input class="form-control" name="location" type="text" id="location" value="{{ old('location') }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="cta_label">{{ __('Button Label') }}</label>
            <input class="form-control" name="cta_label" type="text" id="cta_label" value="{{ old('cta_label') }}" placeholder="Register Interest" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="cta_href">{{ __('Button Link') }}</label>
            <input class="form-control" name="cta_href" type="text" id="cta_href" value="{{ old('cta_href') }}" placeholder="/contact" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="image">{{ __('Image') }}</label>
            <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        </div>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
