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
                <x-infoTitleBtn title="Avisos" :btns="[['route' => route('dashboard.message.create'), 'name' => 'Cadastrar']]" />

                @include('includes.auth.alert')

                @livewire('notice')
            </div>
        </div>
    </section>
@endsection
