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
                @include('includes.auth.alert')
                
                <div class="col-12">
                    <x-infoTitleBtn title="Permuta" :btns="[['route' => route('dashboard.extract.index'), 'name' => 'Voltar']]"/>
                    
                    @if ($list != null)
                        <x-dashboardForm method="POST" methodCrsf="PUT"
                            action="{{ route('dashboard.extract.update', ['uuid' => $uuid]) }}" :fields="$fields" btn="Atualizar" />
                    @else
                        <h2 class="bold m-0">Nenhum dado encontrado!</h2>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
