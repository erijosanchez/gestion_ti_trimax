<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <img src="{{ asset('assets/images/blob.svg') }}" class="blob" />
    <div class="orbit"></div>
    <div class="login">
        <img src="{{ asset('assets/images/657557.png') }}" alt="Logo" />
        <h2>Bienvenido Trimax!</h2>
        <h3>Sistema de gestion</h3>
        @if (session('status'))
            <div style="color: green; text-align: center; margin-bottom: 10px;">
                {{ session('status') }}
            </div>
        @endif
        {{ $slot }}
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
        @endif
    </div>
</body>

</html>
