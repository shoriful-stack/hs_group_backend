<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Author') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>

<form action="{{ route('blogAuthors.update', $blogAuthor->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label for="language_id">{{ __('Language') }}</label>
            <select name="language_id" id="language_id" class="form-control" required>
                @foreach($languages as $id => $name)
                    <option value="{{ $id }}" {{ $blogAuthor->language_id == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="serial_no">{{ __('Serial No') }}</label>
            <input class="form-control" id="serial_no" name="serial_no" type="number" value="{{ $blogAuthor->serial_no }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="name">{{ __('Name') }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ $blogAuthor->name }}" required />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="designation">{{ __('Designation') }}</label>
            <input class="form-control" name="designation" type="text" id="designation" value="{{ $blogAuthor->designation }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="department">{{ __('Department') }}</label>
            <input class="form-control" name="department" type="text" id="department" value="{{ $blogAuthor->department }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="email">{{ __('Email') }}</label>
            <input class="form-control" name="email" type="email" id="email" value="{{ $blogAuthor->email }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="linkedin">{{ __('LinkedIn') }}</label>
            <input class="form-control" name="linkedin" type="text" id="linkedin" value="{{ $blogAuthor->linkedin }}" />
        </div>

        <div class="form-group col-md-12 mb-2">
            <label for="bio">{{ __('Bio') }}</label>
            <textarea class="form-control" name="bio" id="bio" rows="3">{{ $blogAuthor->bio }}</textarea>
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="photo">{{ __('Photo') }}</label>
            <input class="form-control" id="photo" name="photo" type="file" accept="image/*" />
            @if($blogAuthor->photo)
                <div class="mt-2">
                    <img src="{{ asset($blogAuthor->photo) }}" alt="{{ $blogAuthor->name }}" height="60">
                </div>
            @endif
        </div>

        <div class="form-group col-md-6 mb-2">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $blogAuthor->status?->value === $key ? 'selected' : '' }}>
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
