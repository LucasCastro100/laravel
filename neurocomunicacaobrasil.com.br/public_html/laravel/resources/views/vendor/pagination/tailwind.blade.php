@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-col items-center gap-3 pt-1">

        {{-- Info: acima dos botões --}}
        <p class="text-xs text-gray-500">
            Mostrando
            <span class="text-gray-300 font-medium">{{ $paginator->firstItem() }}</span>
            –
            <span class="text-gray-300 font-medium">{{ $paginator->lastItem() }}</span>
            de
            <span class="text-gray-300 font-medium">{{ $paginator->total() }}</span>
            {{ $paginator->total() === 1 ? 'item' : 'itens' }}
        </p>

        {{-- Botões --}}
        <div class="flex items-center gap-1">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 rounded-lg text-xs text-gray-600 bg-gray-800 border border-gray-800 cursor-not-allowed select-none">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-1.5 rounded-lg text-xs text-gray-400 bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-gray-200 transition">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Páginas --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-1.5 text-xs text-gray-600 select-none">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-blue-600 border border-blue-600 select-none">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-1.5 rounded-lg text-xs text-gray-400 bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-gray-200 transition">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Próxima --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-1.5 rounded-lg text-xs text-gray-400 bg-gray-800 border border-gray-700 hover:bg-gray-700 hover:text-gray-200 transition">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1.5 rounded-lg text-xs text-gray-600 bg-gray-800 border border-gray-800 cursor-not-allowed select-none">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>

    </nav>
@endif
