<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Nasional</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Lora:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Lora', serif; background: #F9F4EA; color: #3A2E1A; margin: 0; }

        /* NAV */
        .top-nav {
            background: #FEFCF7; border-bottom: 1px solid #E8DFC8;
            padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;
        }
        .logo { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600; color: #3A2E1A; text-decoration: none; }
        .logo small { display: block; font-family: 'Lora', serif; font-size: 10px; color: #8A7A55; letter-spacing: 0.08em; text-transform: uppercase; font-style: italic; font-weight: 400; }
        .nav-links { display: flex; gap: 10px; align-items: center; }
        .btn-login {
            background: transparent; border: 1.5px solid #3A2E1A; color: #3A2E1A;
            font-family: 'Playfair Display', serif; font-size: 13px;
            padding: 7px 20px; border-radius: 8px; text-decoration: none; transition: all 0.2s;
        }
        .btn-login:hover { background: #3A2E1A; color: #F5EDD6; }
        .btn-register {
            background: #3A2E1A; color: #F5EDD6;
            font-family: 'Playfair Display', serif; font-size: 13px;
            padding: 7px 20px; border-radius: 8px; text-decoration: none; transition: all 0.2s;
        }
        .btn-register:hover { background: #4E3D24; color: #F5EDD6; }

        /* HERO */
        .hero {
            min-height: 88vh; display: flex; align-items: center;
            background: #F9F4EA; padding: 4rem 2rem;
        }
        .hero-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; gap: 60px; flex-wrap: wrap; }
        .hero-text { flex: 1; min-width: 280px; }
        .hero-eyebrow {
            display: inline-block; background: #F0E6C8; color: #8A7040; border: 1px solid #D4C490;
            font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase;
            padding: 4px 14px; border-radius: 20px; margin-bottom: 20px;
        }
        .hero-title {
            font-family: 'Playfair Display', serif; font-size: clamp(32px, 5vw, 52px);
            font-weight: 700; line-height: 1.2; color: #3A2E1A; margin-bottom: 18px;
        }
        .hero-title span { color: #8A7040; }
        .hero-desc { font-size: 16px; color: #6B5B3E; line-height: 1.8; margin-bottom: 32px; max-width: 440px; }
        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-cta-primary {
            background: #3A2E1A; color: #F5EDD6;
            font-family: 'Playfair Display', serif; font-size: 15px; font-weight: 500;
            padding: 14px 32px; border-radius: 10px; text-decoration: none;
            transition: background 0.2s, transform 0.15s; display: inline-block;
        }
        .btn-cta-primary:hover { background: #4E3D24; transform: translateY(-2px); color: #F5EDD6; }
        .btn-cta-secondary {
            background: transparent; color: #3A2E1A; border: 1.5px solid #D4C490;
            font-family: 'Lora', serif; font-size: 15px;
            padding: 14px 32px; border-radius: 10px; text-decoration: none;
            transition: all 0.2s; display: inline-block;
        }
        .btn-cta-secondary:hover { background: #F0E6C8; color: #3A2E1A; transform: translateY(-2px); }

        /* ILLUSTRATION */
        .hero-illustration { flex-shrink: 0; }
        .hero-illustration img { width: clamp(200px, 30vw, 320px); opacity: 0.85; }

        /* FITUR */
        .features { background: #FEFCF7; border-top: 1px solid #E8DFC8; border-bottom: 1px solid #E8DFC8; padding: 4rem 2rem; }
        .features-inner { max-width: 1100px; margin: 0 auto; }
        .features-title { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 600; text-align: center; margin-bottom: 10px; }
        .features-sub { text-align: center; color: #8A7A55; margin-bottom: 3rem; }
        .feature-card {
            background: #F9F4EA; border: 1px solid #E8DFC8; border-radius: 14px;
            padding: 28px 24px; text-align: center; height: 100%;
        }
        .feature-icon { font-size: 2rem; color: #8A7040; margin-bottom: 14px; }
        .feature-title { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 600; margin-bottom: 8px; }
        .feature-desc { font-size: 14px; color: #6B5B3E; line-height: 1.7; }

        /* FOOTER */
        .footer { background: #3A2E1A; color: #E8DFC8; text-align: center; padding: 2rem; font-size: 13px; }
        .footer a { color: #D4C490; text-decoration: none; }
    </style>
</head>
<body>

{{-- NAV --}}
<div class="top-nav">
    <a href="/" class="logo">
        Perpustakaan
        <small>Nasional</small>
    </a>
    <div class="nav-links">
        <a href="{{ route('daftarbuku') }}" class="btn-login">Lihat Buku</a>
        @auth
            <a href="{{ route('home') }}" class="btn-register">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            <a href="{{ route('register') }}" class="btn-register">Daftar</a>
        @endauth
    </div>
</div>

{{-- HERO --}}
<section class="hero">
    <div class="hero-inner">
        <div class="hero-text">
            <span class="hero-eyebrow">&#128218; Sistem Perpustakaan Digital</span>
            <h1 class="hero-title">
                Temukan Dunia<br>dari <span>Ribuan Buku</span>
            </h1>
            <p class="hero-desc">
                Jelajahi, pinjam, dan kembalikan buku dengan mudah. Sistem manajemen perpustakaan modern untuk pengalaman membaca yang lebih nyaman.
            </p>
            <div class="hero-cta">
                <a href="{{ route('daftarbuku') }}" class="btn-cta-primary">Jelajahi Koleksi</a>
                @guest
                <a href="{{ route('register') }}" class="btn-cta-secondary">Daftar Gratis</a>
                @endguest
            </div>
        </div>
        <div class="hero-illustration">
            <img src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png" alt="Ilustrasi Buku">
        </div>
    </div>
</section>

{{-- FITUR --}}
<section class="features">
    <div class="features-inner">
        <h2 class="features-title">Kenapa Perpustakaan Kami?</h2>
        <p class="features-sub">Sistem yang dirancang untuk memudahkan peminjaman buku secara digital</p>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">&#128218;</div>
                    <div class="feature-title">Koleksi Lengkap</div>
                    <p class="feature-desc">Ribuan buku dari berbagai kategori siap dipinjam kapan saja dan di mana saja.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">&#9200;</div>
                    <div class="feature-title">Peminjaman Mudah</div>
                    <p class="feature-desc">Ajukan peminjaman secara online, tanpa perlu antri panjang di perpustakaan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">&#128203;</div>
                    <div class="feature-title">Pantau Status</div>
                    <p class="feature-desc">Lihat status peminjaman dan notifikasi batas pengembalian buku secara real-time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<div class="footer">
    <p>&copy; {{ date('Y') }} Perpustakaan Nasional &mdash; Sistem Informasi Perpustakaan</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>