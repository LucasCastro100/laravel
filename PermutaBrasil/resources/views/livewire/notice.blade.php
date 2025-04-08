<div class="col-12">
    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    <div class="mb-1">
        <input type="text" wire:model.live="searchNotice" placeholder="Buscar pelo titulo do aviso..." class="form-item">
    </div>

    <div class="w-100 overflow-x">        
        @if (count($notices) > 0)
            <table>
                <thead>
                    <tr>
                        <th>TITULO</th>
                        <th>VISUALIZAÇÃO</th>
                        <th>SITUAÇÃO</th>
                        <th>MENSAGEM</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $notice)
                        <tr>
                            <td>{{ $notice->title }}</td>

                            <td>
                                @foreach ($notice->permission_level as $level)
                                    {{ \App\Enums\RoleStatus::tryFrom($level)?->label() ?? 'Desconhecido' }},
                                @endforeach
                            </td>

                            <td>{{ $notice->situation->name }}</td>

                            <td>{!! nl2br(e($notice->description)) !!}</td>

                            <td>
                                <ul class="actions">
                                    <li class="edit">
                                        <div wire:click='showNotice({{ $notice->id }})' class="click"><i
                                                class="fa-solid fa-pencil"></i></div>
                                    </li>

                                    <li class="delete">
                                        <div wire:click="confirmDelete({{ $notice->id }})" class="click"><i
                                                class="fa-solid fa-trash"></i></div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($confirmingUpdate && $noticeModal)
                <div class="modal show" id="modal">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-between align-center">
                            <h5 class="modal-title m-0">{{ $noticeModal->client->name ?? 'Detalhes do Aviso' }}</h5>
                            <button type="button" class="modal-close" title="FECHAR MODAL"
                                wire:click="$set('confirmingUpdate', false)">
                                <i class="fa-solid fa-xmark click" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form wire:submit.prevent="updateNotice">
                                <div class="row">
                                    <div class="form-group col-lg-8 col-12">
                                        <label for="title">Título</label>
                                        <input type="text" wire:model="title" id="title" class="form-item" />
                                        @error('title') <span class="error">{{ $message }}</span> @enderror
                                    </div>


                                    <div class="form-group col-lg-4 col-12">
                                        <label for="situation">Situação</label>
                                        <select wire:model="situation" id="situation" class="form-item">
                                            <option value="0">Comum</option>
                                            <option value="1">Alerta</option>
                                            <option value="2">Urgente</option>
                                        </select>
                                        @error('situation') <span class="error">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-12">
                                        <div class="d-flex flex-direction-row gap">
                                            <input type="checkbox" wire:model="permissionLevel" value="0"
                                                id="user-0" />
                                            <label for="user-0">Usuários</label>
                                            @error('permissionLevel') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-12">
                                        <div class="d-flex flex-direction-row gap">
                                            <input type="checkbox" wire:model="permissionLevel" value="1"
                                                id="user-1" />
                                            <label for="user-1">Associado</label>
                                            @error('permissionLevel') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-4 col-12">
                                        <div class="d-flex flex-direction-row gap">
                                            <input type="checkbox" wire:model="permissionLevel" value="2"
                                                id="user-2" />
                                            <label for="user-2">Associado Pró</label>
                                            @error('permissionLevel') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="description">Descrição</label>
                                        <textarea wire:model="description" id="description" class="form-item" cols="5" rows="5"></textarea>
                                        @error('description') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary"
                                        wire:click="cancelUpdate">Fechar</button>

                                    <button type="submit" class="btn btn-primary"
                                        {{ $isProcessing ? 'disabled' : '' }}>Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if ($confirmingDelete)
                <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-0">Confirmar Exclusão</h5>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir este aviso?</p>
                            </div>
                            <div class="modal-footer col-12 text-right">
                                <button type="button" class="btn btn-close"
                                    wire:click="cancelDelete">Cancelar</button>
                                <button type="button" class="btn btn-save" wire:click="deleteNotice">Confirmar
                                    Exclusão</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{ $notices->links() }}
        @else
            <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
        @endif
    </div>
</div>
