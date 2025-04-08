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
                    <div class="errorPermission">
                        <h1 class="bold text-center">OPS... Você precisa cadastrar seu perfil para acessar todas as funcionalidades!</h1>
                        <a href="{{ route('dashboard.client.index') }}" class="btn">Criar perfil</a>                    
                    </div>                    
                </div>
            </div>
        </div>
    </section>
@endsection
