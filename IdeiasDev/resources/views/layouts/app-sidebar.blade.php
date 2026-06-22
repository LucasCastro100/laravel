<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased dark">
    <x-toast />

    <div class="fixed top-0 left-0 right-0 z-30">
        @include('navigation-menu')
    </div>

    <div x-data="{ sidebarCollapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') || 'false') }"
         @sidebar-collapsed.window="sidebarCollapsed = $event.detail"
         class="h-screen pt-16 bg-gray-950">
        @if ($showSidebar)
            <div class="fixed left-0 top-16 bottom-0 z-40 transition-all duration-300 ease-in-out"
                 :class="sidebarCollapsed ? 'w-16' : 'w-64'">
                <livewire:page.sidebar />
            </div>
        @endif

        <div class="h-full overflow-y-auto p-4 sm:p-6 transition-all duration-300 ease-in-out"
             :class="sidebarCollapsed ? 'ml-16' : 'ml-64'">
            {{ $slot }}
        </div>
    </div>

    @stack('modals')

    @livewireScripts

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/5534991535839" target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>
</body>

</html>
