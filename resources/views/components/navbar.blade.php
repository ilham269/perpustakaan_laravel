<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo2.png') }}" 
                 class="navbar-brand-image img-fluid" 
                 style="width:60px; height:60px; object-fit:contain;">
            
            <span class="navbar-brand-text">
                Perpustakaan 
                <small>Nasional</small>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Katalog Buku</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Peminjaman</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                @auth
    <li class="nav-item d-flex align-items-center">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger ms-3">
                Logout
            </button>
        </form>
    </li>
@endauth

@guest
    <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
    </li>
@endguest
            </ul>
        </div>
    </div>
</nav>