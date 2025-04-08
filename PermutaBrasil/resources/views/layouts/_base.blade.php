<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="application/javascript; charset=utf-8">

    {{-- METATAGS --}}
    <meta property="og:site_name" content="Permuta Brasil">
    <meta property="og:title" content="Permuta Brasil">
    <meta property="og:image" content="https://permutabrasil.com.br/img/web/img_meta.jpg" />
    <meta property="og:image:width" content="2500">
    <meta property="og:image:height" content="965">
    <meta property="og:url" content="https://permutabrasil.com.br/">
    <meta property="og:description" content="Troque, Conecte, Cresça" />
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">

    <meta name="robots" content="index,follow">
    <meta name="description" content="Permuta Brasil | 34 99148-1041">
    <meta name="keywords"
        content="php, laravel, desenvolvimento web, desenvolvimento de sites, sites em php, sites em laravel, desenvolvimento de sistemas web">
    <meta name="author" content="Lucas Oliveira - Permuta Brasil">
    <meta name="googlebot" content="index, follow">

    {{-- ICON --}}
    <script src="https://kit.fontawesome.com/5ae086a3a0.js" crossorigin="anonymous" async defer></script>

    {{--  FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    {{-- CSS PAGE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- FAVICON --}}
    <link rel="shortcut icon" href="{{ asset('img/web/favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/web/favicon.png') }}" />

    {{-- TITLE --}}
    <title>@yield('titlePage')</title>
</head>

<body id="@yield('bodyId')" class="@yield('bodyClass')">
    @yield('bodyContent')
    
    @livewireScripts 
    @stack('scripts')   
</body>

</html>
