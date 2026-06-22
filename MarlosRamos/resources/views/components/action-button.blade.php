@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-950';
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-500 focus:ring-blue-500',
        'secondary' => 'bg-gray-700 text-gray-100 hover:bg-gray-600 focus:ring-gray-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus:ring-red-500',
    ];
    $class = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>{{ $slot }}</button>
@endif
