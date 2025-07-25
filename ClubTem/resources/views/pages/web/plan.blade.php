@extends('layouts.app')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('main')
<section class="h-100">
    <div class="content h-100">
        <div class="row h-100 align-center justify-center flex-direction-column">
            <div class="col-md-9 col-12">
                <img src="{{ asset('img/web/planos.png') }}" alt="Planos Permuta Brasil"
                title="Planos Permuta Brasil" class="w-100">      
            </div>               
        </div>
    </div>
</section>
@endsection
