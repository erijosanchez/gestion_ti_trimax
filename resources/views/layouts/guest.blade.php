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

<body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-col sm:justify-center items-center bg-gray-100 dark:bg-gray-900 pt-6 sm:pt-0 min-h-screen">
        <div>
            <a href="/">
                <x-application-logo class="fill-current w-20 h-20 text-gray-500" />
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 shadow-md mt-6 px-6 py-4 sm:rounded-lg w-full sm:max-w-md overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
