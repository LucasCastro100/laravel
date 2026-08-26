@props([
    'icon',
    'title',
    'value',
    'iconClass' => 'text-indigo-500',
])

<div {{ $attributes->merge(['class' => 'bg-gray-800 p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left']) }}>
    <div class="flex flex-col sm:flex-row sm:items-center">
        <i class="{{ $icon }} text-4xl {{ $iconClass }}"></i>
        <h3 class="text-lg font-medium m-0 sm:ml-4 text-gray-100">{{ $title }}</h3>
    </div>
    <div class="mt-2 sm:mt-0">
        <p class="text-2xl font-bold text-gray-200">{{ $value }}</p>
    </div>
</div>
