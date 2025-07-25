@extends('layouts.app')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('main')
    <section class="h-100">
        <div class="content h-100">
            <div class="row h-100 align-center justify-center flex-direction-column p-1">
                <div>
                    <a href="{{ route('home') }}" class="text-center">
                        <img src="{{ asset('img/web/logo_cabecalho.png') }}" alt="Logo Permuta Brasil"
                            title="Logo Permuta Brasil" class="">
                    </a>
                </div>

                <div class="info-convity">
                    <x-infoTitleBtn title="Informe seus dados" />
                    <x-dashboardForm method="POST" action="{{ route('convity.store') }}" :fields="$fields" btn="Enviar" />
                </div>                
            </div>
        </div>
    </section>
@endsection
