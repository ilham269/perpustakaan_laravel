<nav class="navbar navbar-expand-lg">
    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo2.png') }}" 
                 class="navbar-brand-image img-fluid">

            <span class="navbar-brand-text">
                Perpustakaan 
                <small>Nasional</small>
            </span>
        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- MENU --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('buku*') ? 'active' : '' }}" href="{{ route('daftarbuku') }}">
                        Buku
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
                        Peminjaman
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                        Profile
                    </a>
                </li>

                {{-- AUTH --}}
                @auth
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="custom-btn ms-3">
                            Logout
                        </button>
                    </form>
                </li>
                @endauth

                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="custom-btn ms-3">
                        Login
                    </a>
                </li>
                @endguest

            </ul>
        </div>

    </div>
</nav>