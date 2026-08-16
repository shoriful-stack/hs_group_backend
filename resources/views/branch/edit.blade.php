<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit  Concern Company') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>
<form action="{{ route('branches.update', $branch->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group animated-form col-md-6 mb-2">
            <label class="control-label" for="name">{{ __('Name') }}</label>
            <input class="form-control"  name="name" type="text" id="name"
                value="{{ $branch->name }}" />
        </div>

        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="domain">{{ __('Domain') }}</label>
            <input class="form-control"  name="domain" type="text" id="domain"
                value="{{ $branch->domain }}" />
        </div>
        <div class="form-group col-md-4 mb-2">
            <label class="control-label" for="serial">{{ __('Serial') }}</label>
            <input class="form-control" id="serial" name="serial"  type="number"
                value="{{ $branch->serial }}" />
        </div>
        <div class="form-group col-md-4 mb-2">
            <label class="control-label" for="is_land_business">{{ __('Is Default ?') }}</label>
            <select name="is_default" class="form-select">
                <option @if($branch->is_default==0) selected @endif value="0">No</option>
                <option @if($branch->is_default==1) selected @endif value="1">Yes</option>
            </select>
        </div>

        <div class="form-group animated-form filled col-md-4 mb-2">
            <label class="control-label">{{ __('Status') }}</label>
            <select name="status" id="status" class="form-control">
                @foreach (\App\Enums\Status::options() as $key => $label)
                    <option value="{{ $key }}" {{ $branch->status?->value === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="logo">{{ __('Logo') }}</label>
            <input class="form-control" id="logo" name="image" type="file" accept="image/*" />
            <img src="{{ asset($branch->image) }}" height="30" title="logo" />
            <small class="text-muted text-danger">
                {{ __('Recommended size: 480 x 430px, Max file size: 200KB') }}
            </small>
        </div>
        
        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="content">{{ __('Content') }}</label>
            <textarea name="content" id="content" class="form-control">{!! $branch->content !!}</textarea>
        </div>
    </div>


    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
    </div>
</form>
