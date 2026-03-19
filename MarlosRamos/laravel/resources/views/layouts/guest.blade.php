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
    <div class="min-h-screen w-full flex bg-cover bg-center bg-no-repeat"
         style="background-image: url('http://127.0.0.1:8000/img/fundo_login.png');background-repeat: no-repeat;background-size: cover;background-position: top;">

        <div class="w-full flex justify-center md:justify-end items-center">

            <div class="h-full w-full sm:max-w-md bg-gray-100/90 backdrop-blur-md shadow-2xl overflow-hidden border border-white/20 flex flex-col items-center justify-center">
                
                <div class="p-8 text-center">
                    <a href="/">
                        <x-application-logo class="md:w-1/2 fill-current mx-auto text-gray-800" />
                    </a>
                </div>

                <div class="px-8 pb-10">
                    <div class="text-gray-800">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
