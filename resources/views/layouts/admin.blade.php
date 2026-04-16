<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --sb-w:256px;--sb-bg:#0f172a;--sb-border:rgba(255,255,255,.07);
  --accent:#6366f1;--topbar-h:60px;--pad:24px;
  --bg:#f1f5f9;--surface:#fff;--border:#e2e8f0;
  --text:#0f172a;--text2:#475569;--text3:#94a3b8;
}
html,body{height:100%}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased}

/* Shell */
.shell{display:flex;min-height:100vh}

/* Sidebar */
.sidebar{
  width:var(--sb-w);flex-shrink:0;background:var(--sb-bg);
  background-image:radial-gradient(ellipse at 20% 0%,rgba(99,102,241,.15) 0%,transparent 60%);
  display:flex;flex-direction:column;
  position:fixed;top:0;left:0;height:100vh;z-index:200;
  transition:transform .25s cubic-bezier(.4,0,.2,1);
}
.sb-brand{display:flex;align-items:center;gap:10px;padding:16px;border-bottom:1px solid var(--sb-border);text-decoration:none;flex-shrink:0}
.sb-logo{width:34px;height:34px;background:linear-gradient(135deg,#818cf8,#6366f1);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;box-shadow:0 4px 12px rgba(99,102,241,.4);flex-shrink:0}
.sb-brand-name{font-size:13px;font-weight:700;color:#f8fafc;line-height:1.2}
.sb-brand-tag{font-size:10px;color:rgba(255,255,255,.3)}
.sb-scroll{flex:1;overflow-y:auto;padding:8px;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.08) transparent}
.sb-label{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:rgba(255,255,255,.25);padding:14px 8px 4px;user-select:none}
.sb-link{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:8px;font-size:13px;font-weight:500;color:rgba(255,255,255,.55);text-decoration:none;transition:background .15s,color .15s;margin-bottom:1px;position:relative}
.sb-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;background:rgba(255,255,255,.04);transition:background .15s}
.sb-link:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.85)}
.sb-link:hover .sb-icon{background:rgba(255,255,255,.08)}
.sb-link.active{background:rgba(99,102,241,.2);color:#a5b4fc;font-weight:600}
.sb-link.active .sb-icon{background:rgba(99,102,241,.3)}
.sb-link.active::after{content:'';position:absolute;left:-8px;top:50%;transform:translateY(-50%);width:3px;height:20px;background:linear-gradient(180deg,#818cf8,#6366f1);border-radius:0 3px 3px 0}
.sb-pill{margin-left:auto;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;line-height:1.5;flex-shrink:0}
.sb-pill-amber{background:rgba(251,191,36,.15);color:#fbbf24;border:1px solid rgba(251,191,36,.2)}
.sb-pill-red{background:rgba(248,113,113,.15);color:#f87171;border:1px solid rgba(248,113,113,.2)}
.sb-divider{height:1px;background:var(--sb-border);margin:6px 8px}
.sb-footer{padding:12px 14px;border-top:1px solid var(--sb-border);display:flex;align-items:center;gap:9px;flex-shrink:0}
.sb-avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#818cf8,#6366f1);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
.sb-uname{font-size:12px;font-weight:600;color:rgba(255,255,255,.85)}
.sb-urole{font-size:10px;color:rgba(255,255,255,.3)}
.sb-logout{background:none;border:none;cursor:pointer;color:rgba(255,255,255,.3);font-size:15px;padding:4px;transition:color .15s;flex-shrink:0}
.sb-logout:hover{color:#f87171}

/* Main */
.main{flex:1;margin-left:var(--sb-w);display:flex;flex-direction:column;min-height:100vh;min-width:0}

/* Topbar */
.topbar{height:var(--topbar-h);background:var(--surface);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 var(--pad);position:sticky;top:0;z-index:100;box-shadow:0 1px 2px rgba(0,0,0,.05);flex-shrink:0;gap:12px}
.topbar-l{display:flex;align-items:center;gap:10px;min-width:0}
.topbar-r{display:flex;align-items:center;gap:6px;flex-shrink:0}
.topbar-title{font-size:15px;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.topbar-sep{width:1px;height:16px;background:var(--border);flex-shrink:0}
.topbar-crumb{font-size:12px;color:var(--text3);white-space:nowrap}
.hamburger{display:none;width:32px;height:32px;border-radius:7px;border:1px solid var(--border);background:none;align-items:center;justify-content:center;cursor:pointer;font-size:16px;color:var(--text2);flex-shrink:0}
.hamburger:hover{background:var(--bg)}
.tb-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:7px;font-size:12px;font-weight:500;border:1px solid var(--border);background:var(--surface);color:var(--text2);text-decoration:none;cursor:pointer;transition:all .15s;white-space:nowrap}
.tb-btn:hover{background:var(--bg);color:var(--text)}
.tb-btn.danger{color:#dc2626;border-color:#fecaca}
.tb-btn.danger:hover{background:#fef2f2}
.tb-btn.warn{color:#d97706;border-color:#fde68a;background:#fffbeb}
.tb-btn.warn:hover{background:#fef3c7}

/* Flash */
.flash{display:flex;align-items:center;gap:9px;padding:11px 16px;border-radius:9px;font-size:13px;font-weight:500;margin:16px var(--pad) 0;animation:flashIn .2s ease}
.flash.ok{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}
.flash.err{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}
@keyframes flashIn{from{opacity:0;transform:translateY(-5px)}to{opacity:1;transform:translateY(0)}}

/* Page body */
.page-body{flex:1;padding:var(--pad)}

/* Overlay */
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:199;backdrop-filter:blur(2px)}
.overlay.open{display:block}

/* Responsive */
@media(max-width:1024px){
  .sidebar{transform:translateX(calc(-1 * var(--sb-w)))}
  .sidebar.open{transform:translateX(0);box-shadow:8px 0 32px rgba(0,0,0,.25)}
  .main{margin-left:0}
  .hamburger{display:flex}
  .topbar-sep,.topbar-crumb{display:none}
}

/* Pagination */
.pagination{display:flex;flex-wrap:wrap;gap:4px;margin:0;padding:0;list-style:none}
.pagination .page-item .page-link{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:34px;height:34px;padding:0 10px;
  border-radius:8px!important;border:1px solid var(--border);
  background:var(--surface);color:var(--text2);
  font-size:13px;font-weight:500;text-decoration:none;
  transition:all .15s;line-height:1;
}
.pagination .page-item .page-link:hover{background:var(--bg);border-color:#cbd5e1;color:var(--text)}
.pagination .page-item.active .page-link{background:var(--accent);border-color:var(--accent);color:#fff;font-weight:600}
.pagination .page-item.disabled .page-link{opacity:.4;pointer-events:none;cursor:default}
</style>
@stack('styles')
</head>
<body>

<div class="overlay" id="overlay" onclick="sbClose()"></div>

<div class="shell">

  @include('partials.sidebar')

  <div class="main">
    <header class="topbar">
      <div class="topbar-l">
        <button class="hamburger" onclick="sbOpen()"><i class="bi bi-list"></i></button>
        <span class="topbar-title">@yield('page-title','Dashboard')</span>
        <div class="topbar-sep"></div>
        <span class="topbar-crumb">Perpustakaan Admin</span>
      </div>
      <div class="topbar-r">
        @php $pc = \App\Models\Peminjaman::where('status','pending')->count() @endphp
        @if($pc > 0)
        <a href="{{ route('admin.peminjaman.index') }}?status=pending" class="tb-btn warn">
          <i class="bi bi-hourglass-split"></i> {{ $pc }} Pending
        </a>
        @endif
        <a href="{{ route('home') }}" target="_blank" class="tb-btn">
          <i class="bi bi-globe"></i><span class="d-none d-md-inline"> Situs</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="tb-btn danger"><i class="bi bi-power"></i><span class="d-none d-md-inline"> Logout</span></button>
        </form>
      </div>
    </header>

    @if(session('success'))
      <div class="flash ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="flash err"><i class="bi bi-x-circle-fill"></i> {{ session('error') }}</div>
    @endif

    <main class="page-body">@yield('content')</main>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function sbOpen(){document.getElementById('sidebar').classList.add('open');document.getElementById('overlay').classList.add('open');document.body.style.overflow='hidden'}
function sbClose(){document.getElementById('sidebar').classList.remove('open');document.getElementById('overlay').classList.remove('open');document.body.style.overflow=''}
document.addEventListener('keydown',e=>{if(e.key==='Escape')sbClose()});
document.querySelectorAll('.flash').forEach(el=>setTimeout(()=>{el.style.transition='opacity .3s';el.style.opacity='0';setTimeout(()=>el.remove(),300)},4000));
</script>
@stack('scripts')
</body>
</html>
