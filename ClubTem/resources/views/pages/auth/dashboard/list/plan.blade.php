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
                <x-infoTitleBtn title="Planos" :btns="[['route' => route('dashboard.plan.index'), 'name' => 'Cadastrar']]" />
            </div>
        </div>
    </section>
@endsection
