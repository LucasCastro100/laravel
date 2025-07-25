<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Metas dinâmicas com $data --}}
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="author" content="RcStudio">
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">

    {{-- ICONS --}}
    <script src="https://kit.fontawesome.com/5ae086a3a0.js" crossorigin="anonymous" defer></script>

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="py-8 bg-black text-white font-sans min-h-screen">
    <main class="max-w-7xl mx-auto px-4">
        {{ $slot }}
    </main>
</body>

</html>
