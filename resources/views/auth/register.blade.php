@extends('layouts.app')

@section('title', 'Register')

@section('content')
<section class="membership-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">

                <div class="text-center mb-4">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" height="60">
                    </a>
                    <h3 class="mt-3">Buat Akun Baru</h3>
                    <p class="text-muted">Bergabung bersama kami</p>
                </div>

                <form method="POST" action="{{ route('register') }}"
                      class="custom-form membership-form shadow-lg">
                    @csrf

                    {{-- Name --}}
                    <div class="form-floating mb-3">
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nama Lengkap"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus>
                        <label for="name">Nama Lengkap</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

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
                            autocomplete="email">
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
                            autocomplete="new-password">
                        <label for="password">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-floating mb-4">
                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Konfirmasi Password"
                            required
                            autocomplete="new-password">
                        <label for="password-confirm">Konfirmasi Password</label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="form-control mb-3">Daftar</button>

                    {{-- Link ke login --}}
                    <div class="text-center">
                        <p class="mt-2 mb-0 text-white-50 small">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-white">Login di sini</a>
                        </p>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
@endsection
