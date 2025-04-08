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

<body class="font-sans antialiased" x-data="{ openAside: false }">
    <div class="w-full min-h-screen transition-all bg-gray-100">
        <aside class="bg-white text-black fixed h-full border-r border-gray-100 md:block p-4 transition-all text-center"
            :class="openAside ? 'w-[250px]' : 'w-[85px]'">

            <button @click="openAside = !openAside" class="p-2 bg-gray-50 rounded-md mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- MENU -->
            <nav class="space-y-2">
                @foreach ($adminMenu as $item)
                    <x-responsive-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'])">
                        <i class="fas {{ $item['icon'] }} pr-2"></i>
                        <span class="ml-3 text-sm font-medium transition-all duration-300"
                            x-show="openAside">{{ __($item['name']) }}</span>
                    </x-responsive-nav-link>
                @endforeach

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt pr-2"></i>
                        <span class="ml-3 text-sm font-medium transition-all duration-300"
                            x-show="openAside">{{ __('Sair') }}</span>
                    </x-responsive-nav-link>
                </form>
            </nav>
        </aside>

        {{-- HEADER --}}
        <header class="bg-white shadow transition-all" :class="openAside ? 'ml-[250px]' : 'ml-[85px]'">
            <div class="mx-auto p-4 flex justify-between items-center">
                {{ $header }}

                <img src="{{ asset('img/logo_preta.png') }}" class="w-40" alt="logo">
            </div>
        </header>
        
        {{-- MAIN --}}
        <main class="p-5 transition-all" :class="openAside ? 'ml-[250px]' : 'ml-[85px]'">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
