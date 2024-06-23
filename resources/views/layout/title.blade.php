<header class="mb-3">
    <div style="display: flex;justify-content: space-between;">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>
        <div style="align-content: center;">
            <span style="font-size: 1.5rem">Hi, {{Auth::user()->name}} </span>
        </div>
    </div>
</header>
<div class="page-heading">
    <h3>{{$title}}</h3>
</div>

@if (session('error'))
<div class="alert alert-danger alert-dismissible show fade" bis_skin_checked="1">
    {!! session('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@php
session()->forget('error');
@endphp
@endif

@if(session('message'))
<div class="alert alert-success alert-dismissible show fade">
    {!! session('message') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@php
session()->forget('message');
@endphp
@endif

<div class="alert alert-danger alert-dismissible show fade" bis_skin_checked="1" style="display: none;">
    <p id="error-text"></p>
    <button type="button" class="btn-close" data-bs-dismiss="" aria-label="Close"></button>
</div>

<div class="alert alert-success alert-dismissible show fade" style="display: none;">
    <p id="success-text"></p>
    <button type="button" class="btn-close" data-bs-dismiss="" aria-label="Close"></button>
</div>

<script>
    $(document).ready(function() {
        $('.btn-close').on('click', function() {
            $(this).closest('.alert').hide();
        });
    });
</script>