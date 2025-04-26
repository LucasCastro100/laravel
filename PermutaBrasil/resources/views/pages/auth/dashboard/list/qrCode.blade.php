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
                <x-infoTitleBtn title="QrCodes" :btns="[['route' => route('dashboard.index'), 'name' => 'Voltar']]" />

                @include('includes.auth.alert')

                @livewire('qr-code')
            </div>
        </div>
    </section>
@endsection
