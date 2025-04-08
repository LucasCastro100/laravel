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
                    <x-infoTitleBtn title="Perfil" :btns="[['route' => route('dashboard.index'), 'name' => 'Voltar']]"/>
                    <x-dashboardForm method="POST" enctype="multipart/form-data" methodCrsf="" action="{{ route('dashboard.client.store') }}" :fields="$fields" btn="Salvar" />                    
                </div>
            </div>
        </div>
    </section>
@endsection
