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
                <x-infoTitleBtn title="Serviços" :btns="[['route' => route('dashboard.typeService.create'), 'name' => 'Cadastrar']]" />

                @include('includes.auth.alert')

                @livewire('type-service')
            </div>
        </div>
    </section>
@endsection
