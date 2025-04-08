<div class="col-12">
    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    <div class="mb-1">
        <input type="text" wire:model.live="searchTerm" placeholder="Buscar por NOME ou E-MAIL do cliente..."
            class="form-item">
    </div>

    <div class="w-100 overflow-x">
        @if (count($usuarios) > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NOME</th>
                        <th>E-MAIL</th>
                        <th>ACESSO</th>
                        <th>IP</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($usuarios as $key => $usuario)
                        <tr class="{{ $usuario->actived == 0 ? 'noActivity' : '' }}">
                            <th>{{ $usuario->id }}</th>

                            <td>{{ mb_strtoupper($usuario->client->name ?? 'Sem perfil') }}</td>

                            <td>{{ $usuario->email }}</td>

                            <td>{{ $usuario->access_time ? date_format(date_create($usuario->access_time), 'd-m-Y H:i:s') : 'Sem registro' }}
                            </td>

                            <td>{{ $usuario->access_ip ?? 'Sem registro' }}</td>

                            <td>
                                <ul class="actions">
                                    <li class="edit">
                                        <div wire:click='showUser({{ $usuario->id }}, {{ $usuario->client->id ?? 0 }})'
                                            class="click"><i class="fa-solid fa-pencil"></i></div>
                                    </li>

                                    <li class="delete">
                                        <div wire:click="confirmDelete({{ $usuario->id }})" class="click"><i
                                                class="fa-solid fa-trash"></i></div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($confirmingUpdate && $userModal)
                <div class="modal show" id="modal">
                    <div class="modal-content">
                        <div class="modal-header  d-flex justify-between align-center">
                            <h5 class="modal-title m-0">{{ $userModal->client->name ?? 'Detalhes do Cliente' }}</h5>
                            <button type="button" class="modal-close" title="FECHAR MODAL"
                                wire:click="$set('confirmingUpdate', false)"><i class="fa-solid fa-xmark click"
                                    aria-hidden="true"></i></button>
                        </div>

                        <div class="modal-body">
                            <!-- Formulário para atualização do usuário -->
                            <form wire:submit.prevent="updateUser" enctype="multipart/form-data">
                                <div class="row">
                                    <!-- Campo para 'Ativado' -->
                                    <div class="form-group col-lg-6 col-12">
                                        <label for="actived">Ativado</label>
                                        <select id="actived" wire:model="tempActived" class="form-item">
                                            <option value="1">Sim</option>
                                            <option value="0">Não</option>
                                        </select>
                                    </div>

                                    <!-- Campo para 'Permissão' -->
                                    <div class="form-group col-lg-6 col-12">
                                        <label for="role">Permissão</label>
                                        <select id="role" wire:model="tempRole" class="form-item">
                                            <option value="0">Usuário</option>
                                            <option value="1">Associado</option>
                                            <option value="2">Associado Pro</option>
                                        </select>
                                    </div>

                                    @if ($userIdToUpdate[1] > 0 && $client)
                                        <div class="form-group col-lg-6 col-12">
                                            <label for="associate">Associado</label>
                                            <select id="associate" wire:model="tempAssociate" class="form-item">
                                                <option value="0">Não</option>
                                                <option value="1">Sim</option>                                                
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-12">
                                            <label for="whatsapp">Whatsapp</label>
                                            <input type="text" wire:model.live="tempTel" id="whatsapp"
                                                class="form-item" data-mask="tel">
                                        </div>

                                        <div class="form-group col-12">
                                            <label for="image">Imagem de Perfil</label>
                                            <input type="file" wire:model="newImage" accept="image/*"
                                                class="form-item" id="image">
                                        </div>
                                    @endif

                                </div>

                                <div class="col-12 text-right">
                                    <button type="button" class="btn btn-close"
                                        wire:click="cancelUpdate">Fechar</button>

                                    <button type="submit" class="btn btn-save"
                                        {{ $isProcessing ? 'disabled' : '' }}>Atualizar</button>
                                </div>

                                <div wire:loading wire:target="newImage">
                                    <p class="text-info">Carregando imagem...</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Modal de Confirmação de Exclusão -->
            @if ($confirmingDelete)
                <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-0">Confirmar Exclusão</h5>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir este usuário?</p>
                            </div>
                            <div class="modal-footer col-12 text-right">
                                <button type="button" class="btn btn-close"
                                    wire:click="cancelDelete">Cancelar</button>
                                <button type="button" class="btn btn-save" wire:click="deleteUser">Confirmar
                                    Exclusão</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
        @endif
    </div>
</div>
