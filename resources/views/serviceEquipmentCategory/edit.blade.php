<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Service Equipment Category') }}");
</script>

<form action="{{ route('serviceEquipmentCategories.update', $serviceEquipmentCategory->id) }}" method="POST" enctype="multipart/form-data"
    id="myForm">
    @csrf
    @method('PUT')

    <div class="form-group mb-2">
        <label for="name">{{ __('Name') }}</label>
        <input class="form-control" name="name" type="text" id="name" value="{{ $serviceEquipmentCategory->name }}" />
    </div>

    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">Update</button>
    </div>
</form>