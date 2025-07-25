@extends('layouts.dashboard')

@section('titlePage', $titlePage)

@section('header')
    @include('includes.auth.header')
@endsection

@section('main')
    <section>
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <div class="not-permission">
                        <h1 class="bold text-center">OPS... Você nao possui permissão apra acesar esse conteudo!</h1>
                        <a href="{{ route('dashboard.index') }}" class="btn">Voltar</a>                    
                    </div>                    
                </div>
            </div>
        </div>
    </section>
@endsection
