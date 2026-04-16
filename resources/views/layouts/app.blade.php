<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perpustakaan')</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">

    {{-- 
        NOTE: templatemo css di-remove karena override style custom.
        Kalau masih butuh, taruh SEBELUM style di bawah ini.
    --}}
    {{-- <link href="{{ asset('css/templatemo-tiya-golf-club.css') }}" rel="stylesheet"> --}}

    <style>
        /* ── RESET GLOBAL ── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #F9F4EA;
            font-family: 'Lora', serif;
            color: #3A2E1A;
        }

        main {
            min-height: calc(100vh - 60px);
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #FEFCF7 !important;
            border-bottom: 1px solid #E8DFC8;
            box-shadow: 0 2px 8px rgba(90, 60, 20, 0.06);
        }

        .navbar .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 18px;
            color: #3A2E1A !important;
            letter-spacing: .02em;
        }

        .navbar .nav-link {
            font-family: 'Lora', serif;
            font-size: 14px;
            color: #5C4A2A !important;
            transition: color .2s;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #3A2E1A !important;
        }

        .navbar .navbar-toggler {
            border-color: #D4C490;
        }

        .navbar .navbar-toggler-icon {
            filter: brightness(0.4) sepia(1) hue-rotate(10deg);
        }

        /* ── FLASH MESSAGE ── */
        .flash-wrapper {
            padding: 0.75rem 0 0;
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- NAVBAR --}}
    @include('components.navbar')

    {{-- FLASH MESSAGE --}}
    <div class="flash-wrapper">
        <div class="container">
            @include('components.flash-messages')
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.footer')

    @stack('scripts')

</body>
</html>