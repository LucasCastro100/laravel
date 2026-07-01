@props(['title'])

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

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>{{ $title ?? 'Comunidade de Alquimistas' }}</title>

    {{-- Toast store registrado antes do Alpine carregar --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                items: [],
                add(message, type = 'success') {
                    const id = Date.now() + Math.random();
                    this.items.push({ id, message, type, visible: true });
                    setTimeout(() => {
                        const item = this.items.find(i => i.id === id);
                        if (item) item.visible = false;
                        setTimeout(() => {
                            this.items = this.items.filter(i => i.id !== id);
                        }, 400);
                    }, 4500);
                }
            });
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-200 bg-gray-950"
      x-data="{ openAside: true, mobileMenu: false }"
      x-init="
          @if(session('success')) $store.toast.add({{ json_encode(session('success')) }}, 'success'); @endif
          @if(session('error')) $store.toast.add({{ json_encode(session('error')) }}, 'error'); @endif
      ">

    {{-- Backdrop mobile (por cima do conteúdo, abaixo da sidebar) --}}
    <div x-show="mobileMenu"
         x-transition.opacity
         @click="mobileMenu = false"
         class="fixed inset-0 bg-black/60 z-40 md:hidden"
         style="display: none"></div>

    <x-aside />

    {{-- Toast Container (canto superior direito, flutuante) --}}
    <div class="fixed top-4 right-4 z-[200] flex flex-col gap-2 pointer-events-none max-w-sm w-full" x-data>
        <template x-for="item in $store.toast.items" :key="item.id">
            <div class="pointer-events-auto flex items-start gap-3 px-4 py-3 rounded-xl border shadow-2xl text-sm backdrop-blur-sm w-full"
                 :class="{
                     'bg-gray-900/95 border-green-600/40 text-green-200': item.type === 'success',
                     'bg-gray-900/95 border-red-600/40 text-red-200': item.type === 'error',
                     'bg-gray-900/95 border-yellow-600/40 text-yellow-200': item.type === 'warning'
                 }"
                 x-show="item.visible"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-full">
                <div class="shrink-0 mt-0.5">
                    <i :class="{
                        'fa-solid fa-circle-check text-green-400 text-base': item.type === 'success',
                        'fa-solid fa-circle-xmark text-red-400 text-base': item.type === 'error',
                        'fa-solid fa-triangle-exclamation text-yellow-400 text-base': item.type === 'warning'
                    }"></i>
                </div>
                <span x-text="item.message" class="flex-1 leading-snug"></span>
                <button @click="item.visible = false"
                        class="shrink-0 text-current opacity-40 hover:opacity-80 transition -mr-1 mt-0.5">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        </template>
    </div>

    {{-- Header — ml estático = estado inicial (sem flash); Alpine sobrepõe com !important quando fechado --}}
    <header class="bg-gray-900 shadow border-b border-gray-800 transition-[margin] duration-300 md:ml-[250px]"
            :class="openAside ? '' : 'md:!ml-[85px]'">
        <div class="mx-auto p-4 flex items-center gap-3">
            {{-- Hambúrguer (só mobile) --}}
            <button @click="mobileMenu = true"
                    class="md:hidden p-2 bg-gray-800 hover:bg-gray-700 rounded-md shrink-0 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200" fill="none"
                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <div class="flex-1">{{ $header }}</div>
            {{-- <img src="{{ asset('img/logo_branca.png') }}" class="w-40 shrink-0" alt="logo"> --}}
        </div>
    </header>

    {{-- Main --}}
    <main class="transition-[margin] duration-300 text-gray-200 md:ml-[250px]"
          :class="openAside ? '' : 'md:!ml-[85px]'">
        {{ $slot }}
    </main>

</body>
</html>
