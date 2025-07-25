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
                <x-infoTitleBtn title="Avisos" :btns="[['route' => route('dashboard.message.index'), 'name' => 'Voltar']]" />                

                <form method="post" action="{{ route('dashboard.message.store') }}" class="w-100">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-9 col-12">
                            <label for="title">Titulo</label>
                            <input type="text" name="title" id="title" class="form-item">
                        </div>

                        <div class="form-group col-lg-3 col-12">
                            <label for="situation">Situação</label>
                            <select name="situation" id="situation" class="form-item">
                                <option disabled selected>Selecione...</option>
                                <option value="0">Comum</option>
                                <option value="1">Alerta</option>
                                <option value="2">Urgente</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-2 col-12">
                            <div class="d-flex flex-direction-row gap">
                                <input type="checkbox" name="permission_level[]" id="user-0" value="0" />
                                <label for="permission_level">Usuarios</label>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-12">
                            <div class="d-flex flex-direction-row gap">
                                <input type="checkbox" name="permission_level[]" id="user-1" value="1" />
                                <label for="permission_level">Associado</label>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-12">
                            <div class="d-flex flex-direction-row gap">
                                <input type="checkbox" name="permission_level[]" id="user-2" value="2" />
                                <label for="permission_level">Associado Pró</label>
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label for="description">Descrição</label>
                            <textarea name="description" id="description" class="form-item" cols="5" rows="5"></textarea>
                        </div>

                        <div class="col-12 form-btn">
                            <button type="submit" class="btn">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
