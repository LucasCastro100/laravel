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
                <x-infoTitleBtn title="Contatos" :btns="[['route' => route('dashboard.index'), 'name' => 'Voltar']]" />

                @include('includes.auth.alert')   

                @livewire('friends-list')
            </div>
        </div>
    </section>
@endsection
