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
                    <x-infoTitleBtn title="Extrato" :btns="[['route' => route('dashboard.extract.index'), 'name' => 'Voltar']]"/>
                    <x-dashboardForm method="POST" action="{{ route('dashboard.extract.store') }}" :fields="$fields" btn="Cadastrar" />
                </div>
            </div>
        </div>
    </section>
@endsection
