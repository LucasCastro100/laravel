@extends('layouts.dashboard')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('header')
    @include('includes.auth.header')
@endsection

@section('main')
    <section>
        <div class="content">
            <div class="row">
                <x-infoTitleBtn title="Contratos" :btns="[['route' => route('dashboard.extract.index'), 'name' => 'Voltar']]" />

                @include('includes.auth.alert')

                @if (count($tbodys) > 0)
                    <x-cardsValuesExctracts col="col-lg-4" color="rgba(226, 189, 180, 0.5)" title="TOTAL DÉBITO"
                        value="{{ $values['debito'] }}" />
                    <x-cardsValuesExctracts col="col-lg-4" color="rgba(215, 229, 189, 0.5)" title="TOTAL CRÉDITO"
                        value="{{ $values['credito'] }}" />
                    <x-cardsValuesExctracts col="col-lg-4" color="rgba(22, 54, 92, 0.5)" title="SALDO FINAL"
                        value="{{ $values['saldo'] }}" />

                    <div class="col-12">
                        <div class="w-100 overflow-x">
                            <table>
                                <x-thead :theads="$theads" />

                                <tbody>
                                    @foreach ($tbodys as $key => $tbody)
                                        @php
                                            $partnerId = $tbody['partner_id'] == 0 ? 'null' : $tbody['partner_id']
                                        @endphp
                                        <tr>
                                            <th class="text-center">{{ $key + 1 }}</th>

                                            <td>{{ mb_strtoupper($tbody['name']) }}</td>

                                            <td>{{ $tbody['negotiations'] }}</td>

                                            <td data-value="debito">
                                                R${{ number_format($tbody['valueDebito'], 2, ',', '.') }}
                                            </td>

                                            <td data-value="credito">
                                                R${{ number_format($tbody['valueCredito'], 2, ',', '.') }}</td>

                                            <td data-value="saldo">R${{ number_format($tbody['valueSaldo'], 2, ',', '.') }}
                                            </td>

                                            <x-actionTable chekUser="{{ $partnerId != Auth::user()->id }}"
                                                pdf="{{ route('dashboard.contract.pdf', ['partner' => $partnerId]) }}" />
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th colspan="1" style="border: none"></th>
                                    </tr>

                                    <tr>
                                        <th colspan="3" class="text-left">TOTAL DÉBITO</th>
                                        <td>R${{ number_format($values['debito'], 2, ',', '.') }}</td>
                                    </tr>

                                    <tr>
                                        <th colspan="4" class="text-left">TOTAL CRÉDITO</th>
                                        <td>R${{ number_format($values['credito'], 2, ',', '.') }}</td>
                                    </tr>

                                    <tr>
                                        <th colspan="5" class="text-left">SALDO FINAL</th>
                                        <td colspan="2">R${{ number_format($values['saldo'], 2, ',', '.') }}</td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>

                    {{ $tbodys->onEachSide(5)->links('pagination::bootstrap') }}
                @else
                    <div class="col-12">
                        <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
