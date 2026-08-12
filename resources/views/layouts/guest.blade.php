<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Wisata Tasikmalaya'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <style>
        .guest-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 45%, #0ea5e9 100%);
            padding: 2rem 1rem;
        }
        .guest-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }
        .guest-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        /* Styling untuk component form (label, input, button, error) */
        .profil-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.4rem;
        }
        .profil-input {
            display: block;
            width: 100%;
            padding: 0.6rem 0.9rem;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .profil-input:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }
        .btn-profil-primary {
            background: linear-gradient(135deg, #0369a1, #0ea5e9);
            color: #fff;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-profil-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(14, 165, 233, 0.35);
            color: #fff;
        }
        .profil-error-list {
            list-style: none;
            padding: 0;
            margin: 0.5rem 0 0;
            color: #dc2626;
            font-size: 0.85rem;
        }
    </style>
</head>
<body class="font-sans antialiased">

    <div class="guest-wrapper">
        <div class="guest-card">
            <div class="guest-logo">
                <a href="{{ route('beranda') }}">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 56px;">
                </a>
            </div>

            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>