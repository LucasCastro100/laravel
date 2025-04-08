@extends('layouts.app')

@section('titlePage', $titlePage)
@section('bodyId', $bodyId)
@section('bodyClass', $bodyClass)

@section('header')
    @include('includes.web.header')
@endsection

@section('main')
        <section>
        </section>
@endsection

@section('footer')
    @include('includes.web.footer')
@endsection
