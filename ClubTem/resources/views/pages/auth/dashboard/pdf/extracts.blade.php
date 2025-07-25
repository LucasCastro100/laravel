@extends('layouts.pdf')

@section('main')
    <section style="page-break-inside: avoid;">
        <div class="headerPDF">
            <h4 class="title">PERMUTA BRASIL</h4>
        </div>

        <div class="headerPDF">
            <h5 class="title">RELATÓRIO DE EXTRATO </h5>
        </div>

        <div class="itens-data">
            <span class="mb-0">Data Inicial: {{ $searchDataStart ?? 'não informado' }}</span>
            <span> | </span>
            <span class="mb-0">Data Final: {{ $searchDataEnd ?? 'não informado' }}</span>
        </div>

        <div class="w-100 mb-1 infoValues">
            <table class="extract">
                <thead>
                    <tr>
                        <th class="column-1">#</th>
                        <th class="column-2">CLIENTE</th>
                        <th class="column-3">DATA</th>
                        <th class="column-4">PERMUTA | TRANSAÇÃO</th>
                        <th class="column-5">VENDAS</th>
                        <th class="column-6">COMPRAS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($extracts as $key => $extract)
                        @php
                            $provider =
                                $extract->profileProvider->name == $user['dados']->name
                                    ? 'Sem registro'
                                    : $extract->profileProvider->name;
                            $taker = $extract->profileTaker == null ? 'Sem registro' : $extract->profileTaker->name;

                            $client = $extract->profileProvider->user_id == $user['id'] ? $taker : $provider;
                        @endphp

                        <tr>
                            <th class="text-center column-1">{{ $key + 1 }}</th>

                            @if (Auth::user()->role->value > 2)
                                <td class="column-2">{{ mb_strtoupper($extract->profileProvider->name ?? 'Sem registro') }} --
                                    {{ mb_strtoupper($extract->profileTaker?->name ?? 'Sem registro') }}</td>
                            @else
                                <td class="column-2">{{ mb_strtoupper($client) }}</td>
                            @endif

                            <td class="column-3" style="text-align: center;">{{ date_format(date_create($extract->date_service), 'd-m-Y') }}</td>

                            <td class="column-4">{{ mb_strtoupper($extract->service_product) }}</td>

                            <td class="column-5" style="text-align: center;">
                                R${{ number_format($extract->profileProvider->user_id == $user['id'] ? $extract->value_exchange : 0, 2, ',', '.') }}
                            </td>

                            <td class="column-6" style="text-align: center;">
                                R${{ number_format($extract->profileProvider->user_id == $user['id'] ? 0 : $extract->value_exchange, 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
