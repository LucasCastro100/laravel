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
    <meta property="og:image" content="{{ asset('img/icon.png') }}" />
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:description" content="PNL" />
    <meta property="og:type" content="website">

    {{-- FAVICON --}}
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/icon.png') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    {{-- TITLE --}}
    <title>{{ $title ?? 'Comunidade de Alquimistas' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- A classe 'text-gray-200' garante que o texto padrão seja claro --}}
<body class="font-sans antialiased text-gray-200" x-data="{ openAside: false }">

    {{-- Fundo escuro (bg-gray-900 ou bg-black) --}}
    <div class="w-full min-h-screen transition-all bg-gray-950">

        <x-aside />

        {{-- HEADER: Escuro com borda sutil embaixo --}}
        <header class="bg-gray-900 shadow transition-all border-b border-gray-800" :class="openAside ? 'ml-[250px]' : 'ml-[85px]'">
            <div class="mx-auto p-4 flex justify-between items-center">
                {{ $header }}

                {{-- Dica: Se o seu logo original for preto, ele vai sumir no fundo escuro.
                     Adicione um filtro ou use uma versão branca --}}
                <img src="{{ asset('img/logo_branca.png') }}" class="w-40" alt="logo">
            </div>
        </header>

        {{-- MAIN --}}
        <main class="transition-all text-gray-200" :class="openAside ? 'ml-[250px]' : 'ml-[85px]'">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
