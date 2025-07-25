@extends('layouts.pdf')

@section('header')
    <section>
        <div class="headerPDF">
            <h4 class="title">PERMUTA BRASIL</h4>
        </div>

        <div class="headerPDF">
            <h5 class="title">RELATÓRIO DE EXTRATO | {{ mb_strtoupper($partners[0]) }} - {{ mb_strtoupper($partners[1]) }}
            </h5>
        </div>
    </section>
@endsection

@section('main')
    <section>
        <div class="w-100 mb-1 infoValues">
            <table>
                <thead>
                    <tr>
                        <th colspan="3">VALORES TOTAIS</th>
                    </tr>
                    <tr>
                        <th>DÉBITO</th>
                        <th>CRÉDITO</th>
                        <th>SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">R$ {{ number_format($values['debito'], 2, ',', '.') }}</td>
                        <td class="text-center">R$ {{ number_format($values['credito'], 2, ',', '.') }}</td>
                        <td class="text-center">R$ {{ number_format($values['saldo'], 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="w-100">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>DATA</th>
                        <th>SERVIÇO | PRODUTO</th>
                        <th>VENDAS</th>
                        <th>COMPRAS</th>
                        <th>DINHEIRO</th>
                        <th>DESCRIÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($extratcs as $key => $extratc)
                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td class="text-center">{{ date_format(date_create($extratc->date_service), 'd-m-Y') }}</td>
                            <td>{{ mb_strtoupper($extratc->service_product) }}</td>
                            <td class="text-center">
                                R${{ number_format($extratc->profileProvider->user_id == $userData['id'] ? $extratc->value_exchange : 0, 2, ',', '.') }}
                            </td>
                            <td class="text-center">
                                R${{ number_format($extratc->profileProvider->user_id == $userData['id'] ? 0 : $extratc->value_exchange, 2, ',', '.') }}
                            </td>
                            <td class="text-center">
                                R${{ number_format($extratc->profileProvider->user_id == $userData['id'] ? $extratc->transaction_financial : 0, 2, ',', '.') }}
                            </td>
                            <td class="text-center">{{ $extratc->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
