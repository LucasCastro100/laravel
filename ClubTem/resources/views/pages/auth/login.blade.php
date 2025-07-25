@extends('layouts.auth')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('main')
    <div class="col-12 d-flex justify-center">
        <x-authForm title="Acessar com" method="POST" action="{{ route('login.store') }}" :fields="$fields" btn="Acessar"
            hrefTitle="Não possui conta?" hrefUrl="{{ route('register.create') }}" hrefName="Registrar" />
    </div>
@endsection
