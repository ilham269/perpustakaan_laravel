<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Perpustakaan Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
        --sidebar-w: 256px;
        --topbar-h: 60px;
        --accent: #6366f1;
        --accent-dark: #4f46e5;
        --accent-light: #eef2ff;
        --surface: #ffffff;
        --bg: #f4f6fb;
        --border: #e8ecf4;
        --text: #111827;
        --text-muted: #6b7280;
        --text-xs: #9ca3af;
        --radius: 12px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        --shadow: 0 4px 16px rgba(0,0,0,.06), 0 1px 4px rgba(0,0,0,.04);
        --shadow-lg: 0 10px 40px rgba(0,0,0,.1);
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg);
        color: var(--text);
        margin: 0;
        -webkit-font-smoothing: antialiased;
    }

    /* ══════════════════════════════════════════
       SIDEBAR
    ══════════════════════════════════════════ */
    .sidebar {
        width: var(--sidebar-w);
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
        background: #1e1b4b;
        overflow: hidden;
    }

    /* Subtle noise texture overlay */
    .sidebar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* Brand */
    .sb-brand {
        padding: 20px 20px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        flex-shrink: 0;
    }
    .sb-brand-icon {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, #818cf8, #6366f1);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,.4);
        flex-shrink: 0;
    }
    .sb-brand-text { line-height: 1.2; }
    .sb-brand-name { font-size: 14px; font-weight: 700; color: #fff; letter-spacing: -.01em; }
    .sb-brand-sub  { font-size: 11px; color: rgba(255,255,255,.4); }

    /* Nav */
    .sb-nav { flex: 1; padding: 12px 10px; overflow-y: auto; }
    .sb-nav::-webkit-scrollbar { width: 4px; }
    .sb-nav::-webkit-scrollbar-track { background: transparent; }
    .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 4px; }

    .sb-section {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .1em; color: rgba(255,255,255,.3);
        padding: 16px 12px 6px;
    }

    .sb-link {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 9px;
        font-size: 13px; font-weight: 500; color: rgba(255,255,255,.6);
        text-decoration: none; transition: all .15s;
        margin-bottom: 2px; position: relative;
    }
    .sb-link i { font-size: 16px; flex-shrink: 0; width: 20px; text-align: center; }
    .sb-link:hover { background: rgba(255,255,255,.07); color: rgba(255,255,255,.9); }
    .sb-link.active {
        background: rgba(99,102,241,.25);
        color: #a5b4fc;
        font-weight: 600;
    }
    .sb-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 50%;
        transform: translateY(-50%);
        width: 3px; height: 20px;
        background: #818cf8;
        border-radius: 0 3px 3px 0;
    }
    .sb-badge {
        margin-left: auto;
        font-size: 10px; font-weight: 700;
        padding: 2px 7px; border-radius: 20px;
        line-height: 1.4;
    }
    .sb-badge-warn { background: #fef9c3; color: #854d0e; }
    .sb-badge-danger { background: #fee2e2; color: #991b1b; }

    /* User footer */
    .sb-user {
        padding: 14px 16px;
        border-top: 1px solid rgba(255,255,255,.08);
        display: flex; align-items: center; gap: 10px;
        flex-shrink: 0;
    }
    .sb-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #818cf8, #6366f1);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .sb-user-name  { font-size: 13px; font-weight: 600; color: rgba(255,255,255,.9); }
    .sb-user-role  { font-size: 11px; color: rgba(255,255,255,.35); }

    /* ══════════════════════════════════════════
       MAIN CONTENT
    ══════════════════════════════════════════ */
    .main-wrap {
        margin-left: var(--sidebar-w);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Topbar */
    .topbar {
        height: var(--topbar-h);
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 0 24px;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 50;
        box-shadow: var(--shadow-sm);
        flex-shrink: 0;
    }
    .topbar-left { display: flex; align-items: center; gap: 12px; }
    .topbar-breadcrumb {
        font-size: 13px; color: var(--text-muted);
    }
    .topbar-title {
        font-size: 16px; font-weight: 700; color: var(--text);
    }
    .topbar-divider {
        width: 1px; height: 20px; background: var(--border);
    }
    .topbar-right { display: flex; align-items: center; gap: 8px; }

    .tb-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 500;
        border: 1px solid var(--border); background: var(--surface);
        color: var(--text-muted); text-decoration: none; cursor: pointer;
        transition: all .15s;
    }
    .tb-btn:hover { background: var(--bg); color: var(--text); }
    .tb-btn-danger { border-color: #fecaca; color: #dc2626; }
    .tb-btn-danger:hover { background: #fef2f2; }

    /* Page content */
    .page-content { padding: 24px; flex: 1; }

    /* ══════════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .sidebar { transform: translateX(-100%); transition: transform .25s; }
        .sidebar.open { transform: translateX(0); }
        .main-wrap { margin-left: 0; }
        .sb-toggle { display: flex !important; }
    }
    .sb-toggle {
        display: none;
        width: 36px; height: 36px; border-radius: 8px;
        border: 1px solid var(--border); background: var(--surface);
        align-items: center; justify-content: center;
        cursor: pointer; font-size: 18px; color: var(--text-muted);
    }
    </style>
    @stack('styles')
</head>
<body>

<div style="display:flex;">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sb-brand">
            <div class="sb-brand-icon"><i class="bi bi-book-half"></i></div>
            <div class="sb-brand-text">
                <div class="sb-brand-name">Perpustakaan</div>
                <div class="sb-brand-sub">Admin Panel</div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="sb-nav">

            <a href="{{ route('admin.dashboard') }}"
               class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>

            <div class="sb-section">Koleksi</div>

            <a href="{{ route('admin.buku.index') }}"
               class="sb-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Buku</span>
            </a>

            <a href="{{ route('admin.catalog.index') }}"
               class="sb-link {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}">
                <i class="bi bi-collection"></i>
                <span>Katalog</span>
            </a>

            <div class="sb-section">Transaksi</div>

            <a href="{{ route('admin.peminjaman.index') }}"
               class="sb-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i>
                <span>Peminjaman</span>
                @php $pending = \App\Models\Peminjaman::where('status','pending')->count() @endphp
                @if($pending > 0)
                    <span class="sb-badge sb-badge-warn">{{ $pending }}</span>
                @endif
            </a>

            <a href="{{ route('admin.denda.index') }}"
               class="sb-link {{ request()->routeIs('admin.denda.*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i>
                <span>Denda</span>
                @php $dendaBelum = \App\Models\Denda::where('status','belum bayar')->count() @endphp
                @if($dendaBelum > 0)
                    <span class="sb-badge sb-badge-danger">{{ $dendaBelum }}</span>
                @endif
            </a>

        </nav>

        {{-- User --}}
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div style="min-width:0;flex:1;">
                <div class="sb-user-name text-truncate">{{ auth()->user()->name }}</div>
                <div class="sb-user-role">Administrator</div>
            </div>
        </div>

    </aside>

    {{-- ══ MAIN ══ --}}
    <div class="main-wrap">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                <button class="sb-toggle" id="sbToggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-divider"></div>
                <div class="topbar-breadcrumb">Perpustakaan Admin</div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('home') }}" target="_blank" class="tb-btn">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span class="d-none d-sm-inline">Lihat Situs</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="tb-btn tb-btn-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('success') || session('error'))
        <div class="px-4 pt-3">
            @include('components.flash-messages')
        </div>
        @endif

        {{-- Content --}}
        <main class="page-content">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
