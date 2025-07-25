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
                    @if ($check)
                        <h2 class="text-center bold">Alteração de E-MAIL para {{ $user }}</h2>
                        <x-dashboardForm title="Perfil" method="POST" methodCrsf="PUT"
                            action="{{ route('dashboard.client.setChangeEmail', ['token' => $token]) }}" :fields="$fields"
                            btn="Alterar" />
                    @else
                        <h2 class="text-center bold">Link expirou...</h2>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
