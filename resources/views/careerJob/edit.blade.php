<script type="text/javascript">
    $(".modal-title").text("{{ __('Edit Career Job') }}");
    $(".modal-dialog").addClass('modal-xl');
</script>

<form action="{{ route('careerJobs.update', $careerJob->id) }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf
    @method('PUT')
    @include('careerJob._form', ['careerJob' => $careerJob])
    <div class="modal-footer mt-1">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-info waves-effect waves-light text-white">{{ __('Update') }}</button>
    </div>
</form>
