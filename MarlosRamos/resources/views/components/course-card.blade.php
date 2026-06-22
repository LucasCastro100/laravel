@props([
    'title',
    'description',
    'image',
    'count' => null,
    'href' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'group bg-gray-800 shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer relative']) }}
     @if($href) @click="window.location.href = '{{ $href }}'" @endif
     style="aspect-ratio: 4/3;">
    @if(!empty($image))
        <img src="{{ $image }}" alt="{{ $title }}" class="absolute inset-0 w-full h-full object-cover">
    @endif

    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        @if(!is_null($count))
            <div class="absolute top-2 right-2 flex items-center gap-2 rounded-md border border-gray-600 bg-gray-900/90 px-2 py-1 text-xs text-gray-100 shadow-sm">
                <i class="fas fa-user"></i>
                {{ $count }}
            </div>
        @endif
    </div>

    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-gray-900 via-gray-900/95 to-transparent pt-8 pb-4 px-4 translate-y-2 group-hover:translate-y-0 transition-all duration-300 opacity-0 group-hover:opacity-100">
        <h3 class="text-xl font-semibold text-gray-100">{{ $title }}</h3>

        @if($subtitle)
            <p class="mt-1 text-xs uppercase tracking-[0.2em] text-blue-300">{{ $subtitle }}</p>
        @endif

        @if (!empty($slot))
            <div class="mt-3 flex flex-wrap gap-2 items-center [&>form]:contents">{{ $slot }}</div>
        @endif
    </div>
</div>
