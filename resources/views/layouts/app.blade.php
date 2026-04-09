<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perpustakaan')</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/templatemo-tiya-golf-club.css') }}" rel="stylesheet">
    <style>
                    .navbar {
    background: #ffffff !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.navbar .navbar-brand,
.navbar .nav-link {
    color: #333 !important;
}

.navbar .nav-link:hover {
    color: #0d6efd !important;
}

.navbar .navbar-brand-image {
    filter: none !important; /* balikin warna logo */
}
    </style>
   

    @stack('styles')
</head>

<body>

{{-- ================= NAVBAR ================= --}}
@if (!trim($__env->yieldContent('hide-chrome')))
    @include('components.navbar')
@endif


{{-- ================= CONTENT ================= --}}
<main>
    <div class="container">
        @yield('content')
    </div>
</main>


{{-- ================= FOOTER ================= --}}
@unless (View::hasSection('hide-chrome'))
<footer class="text-center py-4 mt-5 text-muted">
    © {{ date('Y') }} Perpustakaan
</footer>
@endunless


{{-- JS --}}
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@stack('scripts')

</body>
</html>