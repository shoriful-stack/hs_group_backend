<style>
    .alert-absolute {
        position: fixed;
        z-index: 99999;
        top: 20px;
        right: 20px;
        min-width: 350px;
    }
</style>
@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show alert-absolute" role="alert">
        <strong>Success!</strong> {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show alert-absolute" role="alert">
        <strong>Error!</strong> {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        <div class="alert alert-warning alert-dismissible fade show alert-absolute" role="alert">
            <strong>Validation Error!</strong> {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif

<div class="alert alert-success alert-dismissible fade show alert-absolute successAlert" role="alert" style="display: none;">
    <strong>Success!</strong> <span id="msgSuccess"></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="alert alert-warning alert-dismissible fade show alert-absolute warningAlert" role="alert" style="display: none;">
    <strong>Warning!</strong> <span id="msgError"></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div id="internet_alert" class="alert alert-warning alert-dismissible fade show alert-absolute mt-3" role="alert" style="display: none;">
    <span class="mdi mdi-wifi-off"></span> <span class="messageInternet"></span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const alerts = document.querySelectorAll('.alert-absolute');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }, 4000);
        });
    });
</script>
