<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:site_name" content="Formação PNL">
    <meta property="og:title" content="Formação PNL">
    <meta property="og:image" content="{{ asset('img/icon.png') }}" />
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:description" content="PNL" />
    <meta property="og:type" content="website">

    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/icon.png') }}" />

    <title>Comunidade de Alquimistas</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-100 antialiased">
    <div class="min-h-screen w-full relative flex">

        <div class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('img/fundo_login.png') }}');">
        </div>

        <div class="w-full flex items-center justify-center relative z-10 md:justify-end">
            <div class="w-full max-w-xs md:w-[30%] md:h-full p-4 bg-black shadow-2xl flex flex-col justify-center">
                <div class="text-center">
                    <a href="/">
                        <x-application-logo class="w-1/2 md:w-44 fill-current mx-auto text-white" />
                    </a>
                </div>

                <div class="text-gray-200 mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
