<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }

        .sidebar {
            width: 260px; min-height: 100vh; background-color: #ffffff;
            border-right: 1px solid #e5e7eb; position: fixed; top: 0; left: 0; z-index: 1000;
        }
        .sidebar .brand {
            padding: 20px; border-bottom: 1px solid #e5e7eb;
            font-weight: 700; font-size: 18px; display: flex; align-items: center; gap: 10px;
        }
        .sidebar .nav-link {
            color: #6b7280; padding: 12px 16px; border-radius: 10px;
            margin: 4px 12px; font-weight: 500; display: flex; align-items: center;
            gap: 10px; transition: .2s; text-decoration: none;
        }
        .sidebar .nav-link:hover { background-color: #f1f5f9; color: #0d6efd; }
        .sidebar .nav-link.active { background-color: rgba(13,110,253,.1); color: #0d6efd; }
        .nav-section { font-size: 11px; text-transform: uppercase; color: #9ca3af; padding: 14px 24px 6px; }

        .main-content { margin-left: 260px; min-height: 100vh; background-color: #f8fafc; }
        .topbar {
            background: #ffffff; border-bottom: 1px solid #e5e7eb;
            padding: 14px 24px; display: flex; justify-content: space-between; align-items: center;
        }
        .card { border: 0; border-radius: 14px; box-shadow: 0 8px 24px rgba(0,0,0,.04); }
        .avatar { width: 36px; height: 36px; object-fit: cover; }

        @media (max-width: 992px) {
            .sidebar { position: relative; width: 100%; }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <aside class="sidebar d-flex flex-column">
        <div class="brand">
            <i class="bi bi-book fs-4 text-primary"></i>
            Admin Panel
        </div>

        <nav class="flex-grow-1 py-3">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-section">Koleksi</div>

            <a href="{{ route('admin.buku.index') }}"
               class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Buku
            </a>

            <a href="{{ route('admin.catalog.index') }}"
               class="nav-link {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}">
                <i class="bi bi-folder"></i> Katalog
            </a>

            <div class="nav-section">Transaksi</div>

            <a href="{{ route('admin.peminjaman.index') }}"
               class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Peminjaman
                @php $pending = \App\Models\Peminjaman::where('status','pending')->count() @endphp
                @if($pending > 0)
                    <span class="badge bg-warning text-dark ms-auto">{{ $pending }}</span>
                @endif
            </a>

            <a href="{{ route('admin.denda.index') }}"
               class="nav-link {{ request()->routeIs('admin.denda.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i> Denda
                @php $dendaBelum = \App\Models\Denda::where('status','belum bayar')->count() @endphp
                @if($dendaBelum > 0)
                    <span class="badge bg-danger ms-auto">{{ $dendaBelum }}</span>
                @endif
            </a>
        </nav>

        {{-- User Info --}}
        <div class="p-3 border-top">
            <div class="d-flex align-items-center gap-3">
                <div style="width:36px;height:36px;border-radius:50%;background:#e0edff;display:flex;align-items:center;justify-content:center;font-weight:600;color:#0d6efd;font-size:14px;flex-shrink:0;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0">
                    <div class="fw-semibold text-truncate" style="font-size:14px">{{ auth()->user()->name }}</div>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="main-content">

        {{-- Topbar --}}
        <div class="topbar">
            <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-arrow-up-right"></i> Lihat Situs
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- Flash --}}
        <div class="px-4 pt-3">
            @include('components.flash-messages')
        </div>

        {{-- Page Content --}}
        <main class="p-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>