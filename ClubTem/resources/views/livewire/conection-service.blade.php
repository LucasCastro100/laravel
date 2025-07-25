<div class="col-12">
    <div class="mb-1">
        <input type="text" wire:model.live="searchService" placeholder="Buscar por CONEXÃO..." class="form-item">
    </div>

    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    @if ($warningMessage)
        <div class="col-12 alert alert-erro">
            {{ $warningMessage }}
        </div>
    @endif

    <div class="w-100">
        <form wire:submit.prevent="createProspecction" enctype="multipart/form-data">
            <div class="row">
                <!-- Campo para 'Ativado' -->
                <div class="form-group col-12 p-0">
                    <label class="bold">Nova Prospecção</label>
                </div>

                <div class="form-group col-lg-5 col-12">
                    <label for="actived">Tipo</label>
                    <select id="actived" wire:model="typeProspecction" class="form-item">
                        <option value="0">Segmento</option>
                        <option value="1">Empresa</option>
                    </select>
                </div>

                <!-- Campo para 'Permissão' -->
                <div class="form-group col-lg-5 col-12">
                    <label for="nameProspecction">Nome</label>
                    <input type="text" wire:model="nameProspecction" id="nameProspecction"
                        class="form-item">
                </div>

                <div class="col-lg-2 col-12 text-right">
                    <button type="submit" class="btn btn-save">Cadastrar
                        Prospecção</button>
                </div>
            </div>            
        </form>
    </div>

    <div class="w-100">
        @if (count($conections) > 0)
            <form method="POST"
                action="{{ route('dashboard.conectionsService.update', ['uuid' => Auth::user()->client->uuid]) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    @foreach ($conections as $key => $service)
                        <div class="form-group col-xl-3 col-lg-4 col-md-6 col-12">
                            <input type="checkbox" wire:model.live="selectedServices" value="{{ $service->id }}"
                                @if (in_array($service->id, $selectedServices)) checked @endif>
                            <label>{{ mb_strtoupper($service->type_service) }}</label>
                        </div>
                    @endforeach

                    <input type="hidden" name="connected_type_services" value="{{ json_encode($selectedServices) }}">

                    <div class="col-12 form-btn text-right">
                        <div wire:click="newProspecction" class="btn m-x">Cadastrar
                            Prospecção</div>

                        <button type="submit" class="btn">Salvar</button>
                    </div>
                </div>
            </form>

            @if ($openModal)
                <div class="modal show" id="modal">
                    <div class="modal-content">
                        <div class="modal-header  d-flex justify-between align-center">
                            <h5 class="modal-title m-0">Nova Prospecção</h5>
                            <button type="button" class="modal-close" title="FECHAR MODAL"
                                wire:click="$set('openModal', false)"><i class="fa-solid fa-xmark click"
                                    aria-hidden="true"></i></button>
                        </div>

                        <div class="modal-body">
                            <!-- Formulário para atualização do usuário -->
                            <form wire:submit.prevent="createProspecction" enctype="multipart/form-data">
                                <div class="row">
                                    <!-- Campo para 'Ativado' -->
                                    <div class="form-group col-lg-6 col-12">
                                        <label for="actived">Tipo Prospecção</label>
                                        <select id="actived" wire:model="typeProspecction" class="form-item">
                                            <option value="0">Segmento</option>
                                            <option value="1">Empresa</option>
                                        </select>
                                    </div>

                                    <!-- Campo para 'Permissão' -->
                                    <div class="form-group col-lg-6 col-12">
                                        <label for="nameProspecction">Nome</label>
                                        <input type="text" wire:model="nameProspecction" id="nameProspecction"
                                            class="form-item">
                                    </div>
                                </div>

                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-close" wire:click="closeModal">Fechar</button>

                                    <button type="submit" class="btn btn-save">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
        @endif
    </div>
</div>
