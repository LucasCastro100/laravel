@extends('layouts.dashboard')

@section('titlePage', $titlePage)

@section('header')
    @include('includes.auth.header')
@endsection

@section('main')
    <section>
        <div class="content">
            <div class="row">
                @if (!Auth::user()->client)
                    <div class="col-12">
                        <h3 class="bold">Você precisa cadastrar seu perfil para acessar todas as funcionalidades.</h3>
                    </div>
                @else
                    <div class="col-12">
                        <h3 class="bold">Bem-vindo ao painel!</h3>
                    </div>

                    <div class="col-12">
                        <h4 class="bold">Caro(a) usuário(a) Permuta Brasil</h4>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="msgLimit"><h5 class="bold">{{ $connection['limit'] }}</h5></div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="msgRemaining"><h5 class="bold">{{ $connection['remaining'] }}</h5></div>
                    </div>                    
                @endif
            </div>
        </div>
    </section>
@endsection
