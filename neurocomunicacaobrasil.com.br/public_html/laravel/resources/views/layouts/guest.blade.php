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

        {{-- Background --}}
        <div class="absolute inset-0 w-full h-full bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('img/fundo_login.png') }}');">
        </div>
        <div class="absolute inset-0 bg-black/40"></div>

        {{-- Panel --}}
        <div class="w-full flex items-stretch justify-center relative z-10 md:justify-end">
            <div class="w-full max-w-sm md:w-[32%] md:max-w-none md:h-full relative flex flex-col justify-center bg-black/85 backdrop-blur-md shadow-2xl border-l border-white/5">

                {{-- Accent line top --}}
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-blue-500/60 to-transparent"></div>

                <div class="px-8 py-10 md:px-10">
                    {{-- Logo --}}
                    <div class="text-center mb-8">
                        <a href="/">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-40 mx-auto">
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
