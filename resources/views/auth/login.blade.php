@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="membership-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-12">

                <div class="text-center mb-4">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" height="60">
                    </a>
                    <h3 class="mt-3">Selamat Datang</h3>
                    <p class="text-muted">Masuk ke akun Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}"
                      class="custom-form membership-form shadow-lg">
                    @csrf

                    {{-- Email --}}
                    <div class="form-floating mb-3">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus>
                        <label for="email">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-floating mb-3">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            required
                            autocomplete="current-password">
                        <label for="password">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="form-check mb-4 ms-1">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-white" for="remember">
                            Remember Me
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="form-control mb-3">Login</button>

                    {{-- Links --}}
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-white-50 small">
                                Lupa password?
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <p class="mt-3 mb-0 text-white-50 small">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-white">Daftar sekarang</a>
                            </p>
                        @endif
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
@endsection
