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
                <x-infoTitleBtn title="Estante de Troca" :btns="[['route' => route('dashboard.salesBooth.mySales'), 'name' => 'Meus Itens'],['route' => route('dashboard.index'), 'name' => 'Voltar']]" />

                @livewire('sales-booth')
            </div>
        </div>
    </section>
@endsection
