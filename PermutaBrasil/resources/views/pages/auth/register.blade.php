@extends('layouts.auth')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('main')
    <div class="col-12 d-flex justify-center">
        <x-authForm title="Registrar com" method="POST" action="{{ route('register.store') }}" :fields="$fields"
            btn="Registrar" hrefTitle="Possui conta?" hrefUrl="{{ route('login') }}" hrefName="Acessar" />
    </div>
@endsection
