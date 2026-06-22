@props([
    'title' => 'Nenhuma informação disponível.',
    'message' => null,
    'icon' => 'fas fa-inbox',
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-gray-700 bg-gray-800/80 p-6 text-center text-gray-300 shadow-sm']) }}>
    <i class="{{ $icon }} mb-3 text-2xl text-blue-300"></i>
    <h3 class="text-lg font-semibold text-gray-100">{{ $title }}</h3>
    @if($message)
        <p class="mt-2 text-sm text-gray-400">{{ $message }}</p>
    @endif
</div>
