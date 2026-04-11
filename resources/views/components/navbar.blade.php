<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">

<style>
  .site-navbar {
    background: #FEFCF7;
    border-bottom: 1px solid #E8DFC8;
    padding: 0.85rem 0;
    font-family: 'Lora', serif;
  }
  .navbar-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
  .navbar-brand-text {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 600; color: #3A2E1A; line-height: 1.2;
  }
  .navbar-brand-text small {
    display: block; font-family: 'Lora', serif; font-size: 10px;
    font-weight: 400; color: #8A7A55; letter-spacing: 0.08em;
    text-transform: uppercase; font-style: italic;
  }
  .site-navbar .nav-link {
    font-family: 'Lora', serif; font-size: 14px; color: #6B5B3E;
    padding: 6px 14px; border-radius: 8px; transition: background 0.15s, color 0.15s;
  }
  .site-navbar .nav-link:hover { background: #F0E6C8; color: #3A2E1A; }
  .site-navbar .nav-link.active { background: #EDE0BE; color: #3A2E1A; font-weight: 500; }
  .site-navbar .navbar-toggler { border: 1px solid #D4C490; border-radius: 8px; padding: 6px 10px; }
  .site-navbar .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%233A2E1A' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }
  .btn-nav {
    background: #3A2E1A; color: #F5EDD6 !important;
    font-family: 'Playfair Display', serif; font-size: 13px; font-weight: 500;
    padding: 8px 20px; border-radius: 8px; border: none; cursor: pointer;
    text-decoration: none; letter-spacing: 0.03em;
    transition: background 0.2s, transform 0.15s; display: inline-block;
  }
  .btn-nav:hover { background: #4E3D24; transform: translateY(-1px); color: #F5EDD6 !important; }
  .btn-admin {
    background: #0d6efd; color: #fff !important;
    font-family: 'Playfair Display', serif; font-size: 12px; font-weight: 500;
    padding: 6px 14px; border-radius: 8px; text-decoration: none;
    transition: background 0.2s; display: inline-block;
  }
  .btn-admin:hover { background: #0b5ed7; color: #fff !important; }
</style>

<nav class="navbar navbar-expand-lg site-navbar">
  <div class="container">

    <a class="navbar-brand" href="{{ route('home') }}">
      <span class="navbar-brand-text">
        Perpustakaan
        <small>Nasional</small>
      </span>
    </a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center gap-1">

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
             href="{{ route('home') }}">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('daftarbuku') ? 'active' : '' }}"
             href="{{ route('daftarbuku') }}">Buku</a>
        </li>

        @auth
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}"
             href="{{ route('user.peminjaman.index') }}">Pinjaman Saya</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
             href="{{ route('profile.show') }}">Profil</a>
        </li>

        {{-- Tombol admin panel — hanya muncul kalau user adalah admin --}}
        @if(auth()->user()->role === 'admin')
        <li class="nav-item ms-1">
          <a href="{{ route('admin.dashboard') }}" class="btn-admin">
            &#9881; Admin
          </a>
        </li>
        @endif

        <li class="nav-item ms-1">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-nav">Logout</button>
          </form>
        </li>
        @endauth

        @guest
        <li class="nav-item ms-1">
          <a href="{{ route('login') }}" class="btn-nav">Login</a>
        </li>
        @endguest

      </ul>
    </div>

  </div>
</nav>