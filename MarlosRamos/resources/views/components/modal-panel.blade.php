@props([
    'title' => null,
    'open' => false,
    'maxWidth' => '2xl',
])

<template x-if="{{ $open }}">
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/80 p-4" @click.stop>
        <div class="w-full max-w-{{ $maxWidth }} rounded-xl border border-gray-700 bg-gray-900 p-6 shadow-2xl">
            @if($title)
                <div class="mb-4 flex items-center justify-between gap-4">
                    <h2 class="text-xl font-semibold text-gray-100">{{ $title }}</h2>
                    <button type="button" @click="{{ $open }} = false" class="text-gray-400 hover:text-gray-100" aria-label="Fechar">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</template>
