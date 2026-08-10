@extends('layouts.guest-site')
@section('title', 'Masuk - Wisata Tasikmalaya')
@section('content')

<section class="pesan-section" style="min-height:100vh; display:flex; align-items:center;">
    <div class="pesan-bg"></div>
    <div class="container position-relative py-5" style="z-index:2;">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="text-center mb-4">
                    <a href="{{ route('beranda') }}" style="text-decoration:none;">
                        <span style="color:#ffffff; font-weight:700; font-size:22px; text-shadow:0 3px 10px rgba(0,0,0,.4);">Wisata Tasikmalaya</span>
                    </a>
                </div>

                <div class="kontak-card">
                    <div class="text-center mb-4">
                        <h2 style="color:#0d3b7a; font-size:24px;">Masuk ke Akun Anda</h2>
                        <p style="color:#617286; font-size:14px;">Selamat datang kembali, silakan masuk untuk melanjutkan.</p>
                    </div>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3 form-floating">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="username" placeholder="Email">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-floating">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember" style="font-size:13px; color:#617286;">
                                    Ingat saya
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="link-selengkapnya" style="font-size:13px;">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-kirim w-100">
                            Masuk
                        </button>

                        @if (Route::has('register'))
                            <p class="text-center mt-4 mb-0" style="font-size:14px; color:#617286;">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="link-selengkapnya">Daftar sekarang</a>
                            </p>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection