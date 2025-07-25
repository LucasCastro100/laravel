@if ($paginator->hasPages())
    <div class="col-12">
        <nav class="d-flex flex-direction-row align-center justify-between">
            <div>
                <p class="small text-muted">
                    {!! __('Mostrando') !!}
                    <span class="bold">{{ $paginator->firstItem() }}</span>
                    {!! __('a') !!}
                    <span class="bold">{{ $paginator->lastItem() }}</span>
                    {!! __('de') !!}
                    <span class="bold">{{ $paginator->total() }}</span>
                    {!! __('resultados') !!}
                </p>
            </div>

            <div>
                <ul class="pagination d-flex flex-direction-row">
                    <!-- Botão para a página anterior -->
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">

                        </li>
                    @else
                        <li class="page-item">
                            <span class="page-link" wire:click="setPage({{ $paginator->currentPage() - 1 }})"
                                aria-hidden="true"><i class="fa-solid fa-angle-left"></i></span>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        {{-- Separador de "Três Pontos" --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span
                                    class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array de links de páginas --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span
                                            class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item">
                                        <span wire:click="setPage({{ $page }})" class="page-link"
                                            style="cursor: pointer;">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <span class="page-link" wire:click="setPage({{ $paginator->currentPage() + 1 }})"
                                aria-hidden="true"><i class="fa-solid fa-angle-right"></i></span>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        </li>
                    @endif
            </div>
        </nav>
    </div>
@endif
