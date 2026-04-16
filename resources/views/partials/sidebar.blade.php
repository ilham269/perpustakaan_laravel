<aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sb-brand">
      <div class="sb-logo"><i class="bi bi-book-half"></i></div>
      <div>
        <div class="sb-brand-name">Perpustakaan</div>
        <div class="sb-brand-tag">Admin Panel</div>
      </div>
    </a>

    <div class="sb-scroll">
      <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="sb-icon"><i class="bi bi-grid-1x2-fill"></i></span><span>Dashboard</span>
      </a>

      <div class="sb-label">Koleksi</div>
      <a href="{{ route('admin.buku.index') }}" class="sb-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
        <span class="sb-icon"><i class="bi bi-book"></i></span><span>Buku</span>
      </a>
      <a href="{{ route('admin.catalog.index') }}" class="sb-link {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}">
        <span class="sb-icon"><i class="bi bi-collection"></i></span><span>Katalog</span>
      </a>

      <div class="sb-label">Transaksi</div>
      <a href="{{ route('admin.peminjaman.index') }}" class="sb-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
        <span class="sb-icon"><i class="bi bi-arrow-left-right"></i></span><span>Peminjaman</span>
        @php $p = \App\Models\Peminjaman::where('status','pending')->count() @endphp
        @if($p > 0)<span class="sb-pill sb-pill-amber">{{ $p }}</span>@endif
      </a>
      <a href="{{ route('admin.denda.index') }}" class="sb-link {{ request()->routeIs('admin.denda.*') ? 'active' : '' }}">
        <span class="sb-icon"><i class="bi bi-cash-coin"></i></span><span>Denda</span>
        @php $d = \App\Models\Denda::where('status','belum bayar')->count() @endphp
        @if($d > 0)<span class="sb-pill sb-pill-red">{{ $d }}</span>@endif
      </a>

      <div class="sb-divider"></div>
      
    </div>

    <div class="sb-footer">
      <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div style="min-width:0;flex:1">
        <div class="sb-uname text-truncate">{{ auth()->user()->name }}</div>
        <div class="sb-urole">Administrator</div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sb-logout" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
      </form>
    </div>
  </aside>