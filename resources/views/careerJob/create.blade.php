<script type="text/javascript">
    $(".modal-title").text("{{ __('Add Career Job') }}");
    $(".modal-dialog").addClass('modal-xl');
</script>

<form action="{{ route('careerJobs.store') }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @include('careerJob._form')
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Save') }}</button>
    </div>
</form>
