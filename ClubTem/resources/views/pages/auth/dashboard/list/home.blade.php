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
                    <h3 class="bold">Bem-vindo ao painel!</h3>
                </div>

                <div class="col-12">
                    <h4 class="bold">Caro(a) usuário(a) Permuta Brasil</h4>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="msgLimit">
                        <h5 class="bold">{{ $connection['limit'] }}</h5>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="msgRemaining">
                        <h5 class="bold">{{ $connection['remaining'] }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                @if (count($notices) > 0)
                    <div class="col-12">
                        <h3 class="bold">Avisos</h3>
                    </div>

                    <div class="col-12">
                        @foreach ($notices as $notice)
                            <details
                                class="list-notices mb-1 msg-{{ \App\Enums\SituationMessage::tryFrom($notice->situation->value)?->label() }}">
                                <summary class="bold"> {{ $notice->title }} - {{ $notice->situation->name }} </summary>

                                <div class="col-12">
                                    <p class="bold">{!! nl2br(e($notice->description)) !!}</p>
                                </div>
                            </details>
                        @endforeach
                    </div>
                @else
                    <div class="col-12">
                        <h2 class="bold m-0">Nenhum aviso encontrado!</h2>
                    </div>
                @endif
            </div>
        </div>

        @if (Auth::user()->role->value < 3)
            <div class="content">
                <div class="row">
                    @if (count($interests) > 0)
                        <div class="col-12">
                            <h3 class="bold">Usuários Interessados em fazer negócio</h3>
                        </div>

                        <div class="col-12">
                            <ul class="list-conections d-flex flex-direction-column gap">
                                @foreach ($interests as $interest)
                                    <li class="d-flex align-center flex-direction-row gap">
                                        <i class="fa-solid fa-handshake"></i>
                                        <p class="bold">{{ $interest->name }}</p>
                                        @if ($interest->whatsapp != 0)
                                            <p class="btn-interested d-flex"><a
                                                    href="https://api.whatsapp.com/send?phone=55{{ preg_replace('/\D/', '', $interest->whatsapp) }}&text=Olá, gostaria de mais informações."
                                                    class="btn bold" target="_blank">TENHO INTERESSE</a></p>
                                        @else
                                            <p class="bold">Não possui telefone nos registros!</p>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{ $interests->onEachSide(5)->links('pagination::bootstrap') }}
                    @else
                        <div class="col-12">
                            <h2 class="bold m-0">Nenhum interesse encontrado!</h2>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if (Auth::user()->role->value > 2)
            <div class="content">
                <div class="row">
                    @if (count($clients) > 0)
                        <div class="col-12">
                            <h3 class="bold">Prospecções Associados</h3>
                        </div>

                        <div class="col-12">
                            <div class="w-100 overflow-x">
                                <table id="associated-prospecting">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ASSOCIADOS</th>
                                            <th>INTERESSES</th>
                                            <th>PAINEL</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($clients as $key => $client)
                                            <tr>
                                                <th>{{ $key + 1 }}</th>

                                                <td>{{ mb_strtoupper($client->name) }}</td>

                                                <td>
                                                    {{ !empty($client->service_names) ? mb_strtoupper(implode(', ', $client->service_names)) : '--' }}
                                                </td>

                                                <td>
                                                    {{ !empty($client->connections) ? mb_strtoupper(implode(', ', $client->connections)) : '--' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <h2 class="bold m-0">Nenhum conexão encontrada!</h2>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        {{-- @if (Auth::user()->role->value > 2)
            <div class="content">
                <div class="row">
                    @if (count($connectionUsers) > 0)                    
                        <div class="col-12">
                            <h3 class="bold">Conexões</h3>
                        </div>

                        <div class="col-12">
                            @foreach ($connectionUsers as $userID => $users)                                                        
                                <details class="mb-1">
                                    <summary class="bold">{{ mb_strtoupper($users->first()->client_name) }}</summary>

                                    <div class="col-12">
                                        <ul>
                                            @foreach ($users as $user)                                                      
                                                <li class="d-flex flex-firection-row align-center gap">
                                                    <i class="fa-solid fa-minus"></i>
                                                    <p class="bold">{{ mb_strtoupper($user->connectedClient->name ?? 'Sem registro') }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    @else
                        <div class="col-12">
                            <h2 class="bold m-0">Nenhum conexão encontrada!</h2>
                        </div>
                    @endif
                </div>
            </div>
        @endif --}}
    </section>
@endsection
