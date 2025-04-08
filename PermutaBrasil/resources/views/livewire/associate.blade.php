<div class="col-12">
    <div class="row">
        <!-- Filtros de pesquisa -->
        <div class="col-lg-4 col-12 mb-1">
            <input type="text" wire:model.live="searchName" placeholder="Buscar por NOME..." class="form-item">
        </div>

        <div class="col-lg-4 col-12 mb-1">
            <input type="text" wire:model.live="searchCity" placeholder="Buscar por CIDADE..." class="form-item">
        </div>

        <div class="col-lg-4 col-12 mb-1">
            <input type="text" wire:model.live="searchService" placeholder="Buscar por SERVIÇO..." class="form-item">
        </div>
    </div>

    <!-- Lista de Clientes -->
    <div class="w-100 overflow-x">
        <!-- Carregamento específico dos dados de pesquisa -->
        <div wire:loading wire:target="searchName, searchCity, searchService">
            <h3 class="bold">Carregando...</h3>
        </div>

        <div wire:loading.remove wire:target="searchName, searchCity, searchService">
            @if (count($clients) > 0)
                <ul>
                    @foreach ($clients as $client)
                        <li class="mb-1">
                            <div class="info-associate">
                                <div class="col-xl-1 col-lg-2 col-12">
                                    <div class="associate-img d-flex justify-center p-relative">
                                        <div class="loading-text"
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; background-color: #000; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; border-radius: 1rem;"
                                            id="loading-{{ $client->id }}">
                                            <p style="color: #fff;">Carregando imagem...</p>
                                        </div>

                                        @if (!$client->photo == null)
                                            <img src="{{ asset('storage/img/users/' . $client->photo) }}"
                                                alt="Foto Usuário" title="Foto Usuário" class="w-100 h-100"
                                                onload="document.getElementById('loading-{{ $client->id }}').style.display='none'; this.style.display='block';">
                                        @else
                                            <i class="fa-solid fa-user"></i>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3 col-12 text-center">
                                    <p>{{ mb_strtoupper($client->name) }}</p>
                                </div>

                                <div class="col-lg-3 col-12 text-center">
                                    <p>
                                        {{ optional($client->city)->city && optional($client->state)->state
                                            ? mb_strtoupper(optional($client->city)->city . ' - ' . optional($client->state)->uf)
                                            : 'Sem registro' }}
                                    </p>
                                </div>

                                <div class="col-lg-3 col-12 text-center">
                                    <p>{{ mb_strtoupper(optional($client->typeService)->type_service ?? 'Sem registro') }}
                                    </p>
                                </div>

                                @if (Auth::user()->role->value == 3)
                                    <div class="col-lg-3 col-12 text-center">
                                        <p>Conexões:{{ $client->unique_connections_count }}</p>
                                        <p>Extratos:{{ $client->extract_connections_count }}</p>
                                    </div>
                                @endif

                                <div class="col-lg-2 col-sm-3 col-12 text-center">
                                    <button wire:click="getAssociate({{ $client->id }})" wire:loading.attr="disabled"
                                        wire:target="getAssociate" class="btn btn-danger btn-sm">Ver mais</button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Paginação -->
                {{-- {{ $clients->links() }} --}}
                {{ $clients->onEachSide(5)->links('pagination::bootstrap') }}
            @else
                <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
            @endif
        </div>
    </div>

    <!-- Modal de Detalhes do Cliente -->
    @if ($viewAssocaiate && $clientsModal)
        <div class="modal show" id="modal" wire:ignore.self>
            <div class="modal-content">
                <div class="modal-header  d-flex justify-between align-center">
                    <h5 class="modal-title m-0">{{ $clientsModal->name ?? 'Detalhes do Cliente' }}</h5>
                    <button type="button" class="modal-close" title="FECHAR MODAL"
                        wire:click="$set('viewAssocaiate', false)"><i class="fa-solid fa-xmark click"
                            aria-hidden="true"></i></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 col-12 text-center">
                            <!-- Carregamento da Imagem no Modal -->
                            <div wire:loading wire:target="getAssociate">
                                <i class="fa-solid fa-spinner fa-spin"></i> Carregando Imagem...
                            </div>
                            @if ($clientsModal)
                                @if ($clientsModal->photo == null)
                                    <i class="fa-solid fa-user"></i>
                                @else
                                    <img src="{{ asset('/storage/img/users/' . $clientsModal->photo) }} "
                                        alt="Foto Usuário" title="Foto Usuário" class="w-md-75">
                                @endif
                            @endif
                        </div>

                        <div class="col-sm-8 col-12">
                            <p><strong class="bold">Nome:</strong> {{ $clientsModal->name }}</p>
                            <p><strong class="bold">Cidade:</strong>
                                {{ $clientsModal->city->city ?? 'N/A' }}
                                - {{ $clientsModal->state->uf }}</p>
                            <p><strong class="bold">Serviço:</strong>
                                {{ $clientsModal->typeService->type_service ?? 'N/A' }}</p>

                            <!-- Exemplo de Prospecções -->
                            @if (count($connectedTypeServices) > 0)
                                <p class="mt-1">
                                    <strong class="bold">Prospecções:</strong>
                                <ul class="list-prospections">
                                    @foreach ($connectedTypeServices as $item)
                                        <li class="d-flex align-center">
                                            <div class="info-prospeccao d-flex align-center flex-direction-row">
                                                <img src="{{ asset('img/icons/prospeccao.png') }}" alt="Icon">
                                                <p>{{ $item->type_service }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                </p>
                            @endif

                            @if ($clientsModal->whatsapp != 0)
                                {{-- <p class="btn-interested d-flex mt-1"><a
                                        href="https://api.whatsapp.com/send?phone=55{{ preg_replace('/\D/', '', $clientsModal->whatsapp) }}&text=Olá, gostaria de mais informações."
                                        class="btn bold" target="_blank">TENHO INTERESSE</a></p> --}}

                                <form
                                    action="{{ route('dashboard.friend.convity', ['friendId' => $clientsModal->user->id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn">TENHO INTERESSE</button>
                                </form>
                            @else
                                <p class="bold mt-1">Não possui telefone nos registros!</p>
                            @endif
                        </div>

                        <div class="col-12">
                            <p>{!! nl2br(e($clientsModal->description)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
