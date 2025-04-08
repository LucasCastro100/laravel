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
                <x-infoTitleBtn title="Perfil" :btns="[
                    ['route' => route('dashboard.client.sendMsgChangeEmail'), 'name' => 'Alterar E-mail'],
                    ['route' => route('dashboard.client.sendMsgChangePassword'), 'name' => 'Alterar Senha'],
                ]" />

                <div class="col-12">
                    <x-dashboardForm title="Perfil" method="POST" methodCrsf="PUT" enctype="multipart/form-data"
                        action="{{ route('dashboard.client.update', ['uuid' => Auth::user()->client->uuid]) }}"
                        :fields="$fields" btn="Salvar" />
                </div>

                {{-- @livewire('select-multiple') --}}
            </div>
        </div>
    </section>
@endsection
