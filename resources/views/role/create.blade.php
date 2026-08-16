<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Role') }}");
    // $(".modal-dialog").addClass('modal-lg');
</script>
<form action="{{ route('roles.store') }}" method="POST" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name"/>
        </div>
    </div>
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
    </div>

</form>
