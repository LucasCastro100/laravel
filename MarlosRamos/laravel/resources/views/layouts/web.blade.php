@props(['title'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- META TAGS --}}
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

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- ICONS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    {{-- TITLE --}}
    <title>{{ $title ?? 'Comunidade de Alquimistas' }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="w-full min-h-screen bg-gray-100">
        {{-- MAIN --}}
        <main class="p-5">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
