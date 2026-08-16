<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Branch') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>
<form action="{{ route('users.store') }}" method="POST" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="role">{{ __('Role') }} <span class="text-danger">*</span></label>
            <select name="role_id" id="role" class="form-select">
                @foreach ($roles as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="branch">{{ __('Branch') }} <span class="text-danger">*</span></label>
            <select name="branch_id" id="branch" class="form-select">
                @foreach ($branches as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name" />
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="email">{{ __('Email') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="email" type="email" id="email" />
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="password">{{ __('Password') }} <span class="text-danger">*</span></label>
            <input class="form-control" id="password" name="password" required type="password" />
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="password">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>

    </div>
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
    </div>

</form>
