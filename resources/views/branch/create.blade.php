<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Concern Company') }}");
    $(".modal-dialog").addClass('modal-lg');
</script>
<form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    <div class="row">
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input class="form-control" required name="name" type="text" id="name"/>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="domain">{{ __('Domain') }}</label><span class="text-danger">*</span>
            <input class="form-control" required name="domain" type="text" id="domain"/>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="serial">{{ __('Serial') }} <span class="text-danger">*</span></label>
            <input class="form-control" id="serial" name="serial" required type="number" />
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="is_land_business">{{ __('Is Default ?') }}</label>
            <select name="is_default" class="form-select">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
        <div class="form-group col-md-6 mb-2">
            <label class="control-label" for="logo">{{ __('Logo') }}</label> <span class="text-danger">*</span>
            <input class="form-control" id="logo" name="image" type="file" accept="image/*" />
            <small class="text-muted text-danger">
                {{ __('Recommended size: 480 x 430px, Max file size: 200KB') }}
            </small>
        </div>
     
        <div class="form-group col-md-12 mb-2">
            <label class="control-label" for="content">{{ __('Content') }}</label>
            <textarea name="content" id="content" class="form-control"></textarea>
        </div>
    </div>
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
    </div>

</form>
