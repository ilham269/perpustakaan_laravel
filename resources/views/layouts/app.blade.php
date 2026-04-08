<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Security --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Perpustakaan'))</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/templatemo-tiya-golf-club.css') }}" rel="stylesheet">

    {{-- Custom Override (biar gampang styling tambahan) --}}
    <style>
        .navbar-brand-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
    </style>

    {{-- Extra styles --}}
    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    {{-- JS --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/click-scroll.js') }}"></script>
    <script src="{{ asset('js/animated-headline.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    {{-- Fix Navbar Collapse (kadang error di Bootstrap) --}}
    <script>
        document.querySelectorAll('.navbar-nav a').forEach(link => {
            link.addEventListener('click', () => {
                let navbar = document.querySelector('.navbar-collapse');
                if (navbar.classList.contains('show')) {
                    new bootstrap.Collapse(navbar).toggle();
                }
            });
        });
    </script>

    {{-- Extra scripts --}}
    @stack('scripts')

</body>

</html>