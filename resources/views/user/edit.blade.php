<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit User') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>
<form action="{{ route('users.update', $user->id) }}" method="POST" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="role">{{ __('Role') }} <span class="text-danger">*</span></label>
            <select name="role_id" id="role" class="form-select">
                @foreach ($roles as $id => $name)
                    <option value="{{ $id }}" {{ $user->role_id == $id ? 'selected' : '' }}>
                        {{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="branch">{{ __('Branch') }} <span class="text-danger">*</span></label>
            <select name="branch_id" id="branch" class="form-select">
                @foreach ($branches as $id => $name)
                    <option value="{{ $id }}" {{ $user->branch_id == $id ? 'selected' : '' }}>
                        {{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name"
                value="{{ $user->name }}" />
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="email" type="email" id="email"
                value="{{ $user->email }}" />
        </div>

        <div class="form-group animated-form filled col-md-6 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $user->is_active?->value === $key ? 'selected' : '' }}>
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
