<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:site_name" content="Formação PNL">
    <meta property="og:title" content="Formação PNL">
    <meta property="og:image" content="http://127.0.0.1:8000/img/icon.png" />
    <meta property="og:image:width" content="2500">
    <meta property="og:image:height" content="965">
    <meta property="og:url" content="http://127.0.0.1:8000/">
    <meta property="og:description" content="PNL" />
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">

    {{-- FAVICON --}}
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/icon.png') }}" />

    <title>Comunidade de Alquimistas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="my-2">
            <a href="/">
                <x-application-logo class="w-full h-20 fill-current" />
            </a>
        </div>

        <div class="w-full sm:max-w-md my-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
