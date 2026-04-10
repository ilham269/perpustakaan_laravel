@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    .membership-section {
        min-height: 100vh;
        background: #F5F0E8;
        display: flex;
        align-items: center;
        padding: 3rem 1rem;
    }

    .login-card {
        background: #FDFAF4;
        border: 1px solid #DDD5C0;
        border-radius: 2px;
        padding: 3rem 2.5rem 2.5rem;
        position: relative;
        font-family: 'Jost', sans-serif;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 6px; left: 6px; right: -6px; bottom: -6px;
        border: 1px solid #C9BC9E;
        border-radius: 2px;
        z-index: -1;
    }

    /* Brand */
    .login-brand h3 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 26px;
        color: #3A2E1E;
        letter-spacing: 0.03em;
        margin-bottom: 4px;
    }

    .login-brand p {
        font-size: 13px;
        color: #8C7D65;
        font-weight: 300;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    /* Divider */
    .login-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 1.5rem 0;
    }

    .login-divider::before,
    .login-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #C9BC9E;
    }

    .login-divider span {
        font-size: 10px;
        color: #A8966F;
        letter-spacing: 0.2em;
        text-transform: uppercase;
    }

    /* Label */
    .login-label {
        display: block;
        font-size: 10px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #8C7D65;
        margin-bottom: 6px;
        font-weight: 500;
    }

    /* Input override — non-floating */
    .login-input {
        width: 100%;
        background: #FAF6EE !important;
        border: 1px solid #C9BC9E !important;
        border-radius: 1px !important;
        padding: 11px 14px !important;
        font-family: 'Jost', sans-serif !important;
        font-size: 14px !important;
        color: #3A2E1E !important;
        box-shadow: none !important;
        transition: border-color 0.2s, background 0.2s;
    }

    .login-input:focus {
        border-color: #8C7D65 !important;
        background: #FDFAF4 !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .login-input.is-invalid {
        border-color: #c0392b !important;
    }

    /* Remember me */
    .login-check-label {
        font-size: 12px;
        color: #8C7D65 !important;
        letter-spacing: 0.04em;
    }

    /* Submit button */
    .btn-login-submit {
        width: 100%;
        background: #3A2E1E;
        color: #F5F0E8;
        border: none;
        border-radius: 1px;
        padding: 13px;
        font-family: 'Jost', sans-serif;
        font-size: 12px;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-login-submit:hover {
        background: #2A2010;
        color: #F5F0E8;
    }

    /* Links */
    .login-link {
        font-size: 12px;
        color: #8C7D65;
        text-decoration: none;
        letter-spacing: 0.04em;
        border-bottom: 1px solid transparent;
        transition: color 0.2s, border-color 0.2s;
    }

    .login-link:hover {
        color: #3A2E1E;
        border-bottom-color: #3A2E1E;
    }

    .login-link-dark {
        color: #3A2E1E;
        font-weight: 500;
    }

    .login-footer-text {
        font-size: 12px;
        color: #A8966F;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<section class="membership-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-12">

                <div class="login-card">

                    {{-- Brand --}}
                    <div class="text-center login-brand mb-0">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo2.png') }}" alt="{{ config('app.name') }}" height="55" class="mb-3">
                        </a>
                        <h3>Selamat Datang</h3>
                        <p class="mb-0">Masuk ke akun Anda</p>
                    </div>

                    <div class="login-divider"><span>Login</span></div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="login-label">Email Address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="login-input @error('email') is-invalid @enderror"
                                placeholder="nama@email.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1" style="font-size:12px; color:#c0392b;" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="login-label">Password</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="login-input @error('password') is-invalid @enderror"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback d-block mt-1" style="font-size:12px; color:#c0392b;" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="form-check mb-4 ms-1">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}
                                   style="accent-color: #8C7D65;">
                            <label class="form-check-label login-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-login-submit mb-4">Masuk</button>

                        {{-- Links --}}
                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="login-link">
                                    Lupa password?
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <p class="login-footer-text mb-0">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}" class="login-link login-link-dark">
                                        Daftar sekarang
                                    </a>
                                </p>
                            @endif
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection