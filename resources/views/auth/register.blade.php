@extends('layouts.guest-site')
@section('title', 'Daftar - Wisata Tasikmalaya')
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
                        <h2 style="color:#0d3b7a; font-size:24px;">Buat Akun Baru</h2>
                        <p style="color:#617286; font-size:14px;">Daftar untuk mulai memesan tiket wisata favoritmu.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3 form-floating">
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   required autofocus autocomplete="name" placeholder="Nama Lengkap">
                            <label for="name">Nama Lengkap</label>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-floating">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   required autocomplete="username" placeholder="Email">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-floating">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-floating">
                            <input id="password_confirmation" type="password"
                                   class="form-control" name="password_confirmation"
                                   required autocomplete="new-password" placeholder="Konfirmasi Password">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            @error('password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-kirim w-100">
                            Daftar
                        </button>

                        <p class="text-center mt-4 mb-0" style="font-size:14px; color:#617286;">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="link-selengkapnya">Masuk di sini</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection