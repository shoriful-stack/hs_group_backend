<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Customer') }}");
</script>

<form action="{{ route('ourCustomers.update', $ourCustomer->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')

    <div class="form-group mb-2">
        <label class="control-label" for="title">{{ __('Title') }} </label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $ourCustomer->title }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="content">{{ __('Content') }} </label>
        <input class="form-control" name="content" type="text" id="content" value="{{ $ourCustomer->content }}" />
    </div>

    <div class="form-group mb-2">
        <label class="control-label" for="image">{{ __('Choose Image') }}</label>
        <input class="form-control" id="image" name="image" type="file" accept="image/*" />
        <img src="{{ asset($ourCustomer->image) }}" alt="{{ $ourCustomer->title }}" height="50">
        <small class="text-muted text-danger">
            {{ __('Recommended size: 1000 x 563px, Max file size: 200KB') }}
        </small>
    </div>


    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">Update</button>
    </div>
</form>
