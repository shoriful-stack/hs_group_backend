<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Service Category') }}");
</script>

<form action="{{ route('serviceCategories.update', $serviceCategory->id) }}" method="POST" enctype="multipart/form-data"
    id="myForm">
    @csrf
    @method('PUT')

    <div class="form-group mb-2">
        <label for="name">{{ __('Name') }}</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ $serviceCategory->name }}" />
    </div>

    <div class="form-group mb-2">
        <label>{{ __('Status') }}</label>
        <select name="status" id="status" class="form-control select2">
            @foreach (\App\Enums\Status::options() as $key => $label)
            <option value="{{ $key }}" {{ $serviceCategory->status?->value === $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">Update</button>
    </div>
</form>