<script>
    function loadModal(url){
        $("#body-content").load(url);
    }
</script>
<div id="modal" class="modal fade" role="dialog"  style="display: none;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Small Modal</h4>
                <button type="button" class="close btn-x" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body bg-white" id="body-content">

            </div>
        </div>
    </div>
</div>
