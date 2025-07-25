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
                <x-infoTitleBtn title="Extratos" :btns="[['route' => route('dashboard.extract.create'), 'name' => 'Cadastrar']]" />

                @include('includes.auth.alert')

                @livewire('extracts')
            </div>
        </div>
    </section>
@endsection
