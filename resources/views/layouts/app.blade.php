<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <style>
        /* ── TABLE CARD ─────────────────────────────── */
        .table-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .table-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-card .table thead tr { background-color: var(--secondary-color); }
        .table-card .table thead th {
            padding: 14px 16px;
            font-weight: 500;
            font-size: 0.88rem;
            border: 0;
            color: #fff;
        }
        .table-card .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-color: #f5f5f5;
            color: var(--secondary-color);
        }
        .table-card .table tbody tr:hover { background: #fafafa; }

        /* ── BADGE STATUS ────────────────────────────── */
        .badge-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .badge-pending      { background: #fff3cd; color: #856404; }
        .badge-disetujui    { background: #d1e7dd; color: #0a5c36; }
        .badge-ditolak      { background: #f8d7da; color: #842029; }
        .badge-dikembalikan { background: #cfe2ff; color: #084298; }

        /* ── BADGE STOK ──────────────────────────────── */
        .badge-stok { display: inline-block; padding: 4px 12px; border-radius: 50px; font-size: 0.78rem; font-weight: 600; }
        .stok-ada   { background: #d1e7dd; color: #0a5c36; }
        .stok-habis { background: #f8d7da; color: #842029; }

        /* ── TOMBOL AKSI ─────────────────────────────── */
        .btn-aksi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
            margin-right: 4px;
            text-decoration: none;
        }
        .btn-detail { background: rgba(129,178,154,0.15); color: var(--primary-color); }
        .btn-detail:hover { background: var(--primary-color); color: #fff; }
        .btn-edit   { background: rgba(242,204,143,0.2); color: #c9a227; }
        .btn-edit:hover { background: #F2CC8F; color: #fff; }
        .btn-hapus  { background: rgba(224,122,95,0.15); color: var(--custom-btn-bg-hover-color); }
        .btn-hapus:hover { background: var(--custom-btn-bg-hover-color); color: #fff; }

        /* ── FORM CARD ───────────────────────────────── */
        .form-card {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .form-group-custom { margin-bottom: 20px; }
        .form-group-custom label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 0.92rem;
            color: var(--secondary-color);
            background: #fafafa;
            outline: none;
            transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
            font-family: var(--body-font-family);
        }
        .form-input:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(129,178,154,0.15);
        }
        .form-input.is-invalid { border-color: #E07A5F; }
        textarea.form-input { resize: vertical; }
        .form-error {
            display: block;
            font-size: 0.8rem;
            color: #E07A5F;
            margin-top: 5px;
            padding-left: 4px;
        }

        /* ── DETAIL CARD ─────────────────────────────── */
        .detail-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .detail-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-card-header h4,
        .detail-card-header h5 { color: var(--secondary-color); margin-bottom: 0; }
        .detail-card-body { padding: 8px 24px; }
        .detail-card-footer {
            padding: 16px 24px;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }
        .detail-row {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
            gap: 16px;
        }
        .detail-row:last-child { border-bottom: 0; }
        .detail-label {
            min-width: 140px;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--p-color);
            flex-shrink: 0;
        }
        .detail-value { font-size: 0.92rem; color: var(--secondary-color); }

        /* ── BACK LINK ───────────────────────────────── */
        .back-link {
            display: inline-flex;
            align-items: center;
            font-size: 0.88rem;
            color: var(--p-color);
            font-weight: 500;
            transition: color 0.2s;
            text-decoration: none;
        }
        .back-link:hover { color: var(--secondary-color); }

        /* ── ALERT ───────────────────────────────────── */
        .alert-success-custom {
            background: #d1e7dd;
            color: #0a5c36;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* ── DASHBOARD CARDS ─────────────────────────── */
        .dashboard-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .dashboard-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
        .dashboard-card-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .dashboard-card-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary-color);
            line-height: 1;
        }
        .dashboard-card-label { font-size: 0.82rem; color: var(--p-color); margin-top: 4px; }
    </style>

    @stack('styles')
</head>

<body>

    @unless (View::hasSection('hide-chrome'))
        @include('components.navbar')
    @endunless

    <main>
        @yield('content')
    </main>

    @unless (View::hasSection('hide-chrome'))
        @include('components.footer')
    @endunless

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/click-scroll.js') }}"></script>
    <script src="{{ asset('js/animated-headline.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')

</body>

</html>
