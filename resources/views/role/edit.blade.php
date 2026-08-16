<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Role') }}");
    // $(".modal-dialog").addClass('modal-lg');
</script>
<form action="{{ route('roles.update', $role->id) }}" method="POST" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group animated-form col-md-12 mb-2">
            <label class="control-label" for="name">{{ __('Name') }}</label>
            <input class="form-control" required name="name" type="text" id="name"
                value="{{ $role->name }}" />
        </div>


        <div class="form-group animated-form filled col-md-12 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $role->status?->value === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
    </div>
</form>
