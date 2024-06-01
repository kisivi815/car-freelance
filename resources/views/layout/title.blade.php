<header class="mb-3">
    <a href="#" class="burger-btn d-block">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>
<div class="page-heading">
    <h3>{{$title}}</h3>
</div>
@if (session('error'))
<div class="alert alert-danger alert-dismissible show fade" bis_skin_checked="1">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif