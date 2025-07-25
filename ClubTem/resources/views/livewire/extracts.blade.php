<div class="col-12">
    <div class="row">
        @if (Auth::user()->role->value < 3)
            <x-cardsValuesExctracts col="col-lg-4" color="rgba(156, 202, 93, 0.5);" title="TOTAL VENDA"
                value="{{ $values['credito'] }}" />
            <x-cardsValuesExctracts col="col-lg-4" color="rgba(202, 21, 40, 0.5)" title="TOTAL COMPRA"
                value="{{ $values['debito'] }}" />
            <x-cardsValuesExctracts col="col-lg-4" color="rgba(0, 113, 192, 0.5)" title="SALDO FINAL"
                value="{{ $values['saldo'] }}" />
        @endif
    </div>

    <div class="row">
        <div class="form-group col-xl-3 col-sm-6 col-12 mb-1">
            <label for="">Data Inicial</label>
            <input type="date" wire:model.live="searchDataStart" placeholder="Busque por DATA INICIAL..."
                class="form-item">
        </div>

        <div class="form-group col-xl-3 col-sm-6 col-12 mb-1">
            <label for="">Data Final</label>
            <input type="date" wire:model.live="searchDataEnd" placeholder="Buscar por DATA FINAL..."
                class="form-item">
        </div>

        <div class="form-group col-xl-3 col-sm-6 col-12 mb-1">
            <label for="">Cliente</label>
            <input type="text" wire:model.live="searchClient" placeholder="Buscar por CLIENTE..." class="form-item">
        </div>

        <div class="form-group col-xl-3 col-sm-6 col-12 mb-1">
            <label for="">Serviço</label>
            <input type="text" wire:model.live="searchService" placeholder="Buscar por SERVIÇO..." class="form-item">
        </div>

        <div class="col-12 text-right">
            <button wire:click="generateReport" class="btn btn-primary">Gerar Relatório PDF</button>
        </div>
    </div>

    {{-- @dd($extractQuery, $values, $user) --}}

    <div class="row">
        @if ($extractQuery->count() > 0)
            <div class="w-100 overflow-x">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CLIENTE</th>
                            <th>DATA</th>
                            <th>PERMUTA | TRANSAÇÃO</th>
                            <th>VENDAS</th>
                            <th>COMPRAS</th>
                            @if (Auth::user()->role->value < 3)
                                <th>AÇÃO</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($extractQuery as $key => $extract)
                            @php
                                $provider =
                                    $extract->profileProvider->name == $user['dados']->name
                                        ? 'Sem registro'
                                        : $extract->profileProvider->name;
                                $taker = $extract->profileTaker == null ? 'Sem registro' : $extract->profileTaker->name;

                                $client = $extract->profileProvider->user_id == $user['id'] ? $taker : $provider;

                                $globalIndex = ($extractQuery->currentPage() - 1) * $extractQuery->perPage() + $key + 1;
                            @endphp

                            <tr>
                                <th class="text-center">{{ $globalIndex }}</th>

                                @if (Auth::user()->role->value > 2)
                                    <td>{{ mb_strtoupper($extract->profileProvider->name ?? 'Sem registro') }} --
                                        {{ mb_strtoupper($extract->profileTaker?->name ?? 'Sem registro') }}</td>
                                @else
                                    <td>{{ mb_strtoupper($client) }}</td>
                                @endif

                                <td>{{ date_format(date_create($extract->date_service), 'd-m-Y') }}</td>

                                <td>{{ mb_strtoupper($extract->service_product) }}</td>

                                <td data-value="venda">
                                    R${{ number_format($extract->profileProvider->user_id == $user['id'] ? $extract->value_exchange : 0, 2, ',', '.') }}
                                </td>

                                <td data-value="compra">
                                    R${{ number_format($extract->profileProvider->user_id == $user['id'] ? 0 : $extract->value_exchange, 2, ',', '.') }}
                                </td>

                                @if (Auth::user()->role->value < 3)
                                    <x-actionTable
                                        show="{{ route('dashboard.extract.show', ['uuid' => $extract->uuid]) }}"
                                        edit="{{ route('dashboard.extract.edit', ['uuid' => $extract->uuid]) }}"
                                        active="{{ route('dashboard.extract.active', ['uuid' => $extract->uuid]) }}"
                                        delete="{{ route('dashboard.extract.destroy', ['uuid' => $extract->uuid]) }}"
                                        {{-- pdf="{{ route('dashboard.extract.pdf', ['uuid' => $extract->uuid]) }}" --}}
                                        chekUser="{{ $extract->service_taker_id != Auth::user()->id }}" />
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $extractQuery->links() }}
        @else
            <div class="col-12">
                <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
            </div>
        @endif
    </div>
</div>
