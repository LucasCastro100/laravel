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
                <x-infoTitleBtn title="Meus Itens" :btns="[['route' => route('dashboard.index'), 'name' => 'Voltar']]" />

                @livewire('my-sales-booth')
            </div>
        </div>
    </section>
@endsection
