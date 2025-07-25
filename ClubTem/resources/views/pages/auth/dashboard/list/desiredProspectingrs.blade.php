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
                <div class="col-12">
                    <x-infoTitleBtn title="Prospecções Desejadas" :btns="[['route' => route('dashboard.index'), 'name' => 'Voltar']]" />

                    @livewire('desired-prospectingr')
                </div>
            </div>
        </div>
    </section>
@endsection
