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
                <x-infoTitleBtn title="{{ $client }}" :btns="[['route' => route('dashboard.index'), 'name' => 'Voltar']]" />

                @livewire('chat', ['friendId' => $friendId])
            </div>
        </div>
    </section>
@endsection
