@props([
    'src',
    'alt' => 'Banner do Curso',
])

@if ($src)
    <div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-gray-800 bg-gray-900 w-full']) }}>
        <img src="{{ $src }}" alt="{{ $alt }}" class="w-full">
    </div>
@endif
