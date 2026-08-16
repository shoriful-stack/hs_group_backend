<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Stat') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('stats.update', $stat->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="title">{{ __('Title') }}</label>
            <input class="form-control"  name="title" type="text" id="title" value="{{ $stat->title }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="value">{{ __('Value') }}</label>
            <input class="form-control" name="value" type="number" min="0" id="value" value="{{ $stat->value }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" required type="number" value="{{ $stat->serial_no }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $stat->status?->value === $key ? 'selected' : '' }}>
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
