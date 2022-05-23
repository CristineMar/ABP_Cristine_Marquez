@if (Session::has("error"))
<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    {{ Session::get("error") }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
</div>
@endif

@if (Session::has('mensaje'))
<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
    {{ Session::get('mensaje') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
</div>
@endif