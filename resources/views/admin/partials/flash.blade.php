@if (session('success'))
<div class="idx-alert idx-alert-success">
    <i class="bi bi-check-circle-fill"></i>
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="idx-alert idx-alert-error">
    <i class="bi bi-x-circle-fill"></i>
    {{ session('error') }}
</div>
@endif
