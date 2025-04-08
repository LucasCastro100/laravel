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
                 <x-infoTitleBtn title="Transações" :btns="[['route' => route('dashboard.transactionExchange.create'), 'name' => 'Cadastrar']]" />

                    @include('includes.auth.alert')
{{-- 
                @foreach ($paymants as $paymant)
                    <div class="col-lg-4 col-12">
                        <div
                            class="transaction d-flex flex-direction-row justify-between align-center {{ $paymant['class'] }}">
                            <div class="info">
                                <h2 class="bold">{{ $paymant['name'] }}</h2>
                                <h4 class="bold m-0">R$ {{ number_format($paymant['value'], 2, '.', ',') }}</h4>
                            </div>

                            <div class="icon"><i class="fa-solid fa-brazilian-real-sign"></i></div>
                        </div>
                    </div>
                @endforeach

                @if (count($tbodys) > 0)
                    <div class="col-12">
                        <div class="w-100 overflow-x">
                            <table>
                                <x-thead :theads="$theads" />

                                <tbody>
                                    @foreach ($tbodys as $key => $tbody)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>
                                            <td>{{ $tbody['provider']->name ?? '' }} -
                                                {{ $tbody['taker']->name ?? 'Sem Registro' }}</td>
                                            <td>{{ date_format(date_create($tbody['extract']->validity), 'd-m-Y') }}</td>
                                            <td>R${{ number_format($tbody['extract']->price, 2, '.', ',') }}</td>
                                            <td>{{ str_replace('_', ' ', $tbody['extract']->type_price->name) }}</td>
                                            <td>{{ str_replace('_', ' ', $tbody['extract']->type_paymant->name) }}</td>
                                            <x-actionTable
                                                pdf="{{ route('dashboard.transaction.show', ['uuid' => $tbody['control_exchange_uuid']]) }}" />
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
                    </div>
                @endif --}}
            </div>
        </div>
    </section>
@endsection
