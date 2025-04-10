<div class="col-12">
    <div class="row">
        <div class="col-lg-6 col-12 mb-1 form-group">
            <label for="">Data</label>
            <input type="date" wire:model.live="searchDate" class="form-item">
        </div>

        <div class="col-lg-6 col-12 mb-1 form-group">
            <label for="">Nome</label>
            <input type="text" wire:model.live="searchName" placeholder="Buscar por NOME..." class="form-item">
        </div>
    </div>

    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    <button wire:click="openCreateModal" class="btn btn-primary mb-1">Cadastrar Produto</button>

    <div class="w-100 overflow-x">
        <table>
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Imagens</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $shelf)
                    <tr>
                        <td>{{ $shelf->name }}</td>
                        <td>{{ $shelf->description }}</td>
                        <td>R$ {{ $shelf->price }}</td>
                        <td>
                            @foreach ($shelf->images as $image)
                                <img src="{{ Storage::url($image) }}" alt="{{ $shelf->name }}" class="img-thumbnail"
                                    width="50">
                            @endforeach
                        </td>
                        <td>
                            <ul class="actions">
                                <li class="edit">
                                    <div wire:click='openEditModal({{ $shelf->id }})' class="click"><i
                                            class="fa-solid fa-pencil"></i></div>
                                </li>

                                <li class="delete">
                                    <div wire:click="confirmDelete({{ $shelf->id }})" class="click"><i
                                            class="fa-solid fa-trash"></i></div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $sales->links() }}

    <!-- Create Modal -->
    @if ($showCreateModal)
    <div class="modal show" id="modal">
        <div class="modal-content">
            <div class="modal-header  d-flex justify-between align-center">
                <h5 class="modal-title m-0">Cadastrar Produto</h5>
                <button type="button" class="modal-close" title="FECHAR MODAL"
                    wire:click="$set('showCreateModal', false)"><i class="fa-solid fa-xmark click"
                        aria-hidden="true"></i></button>
            </div>

            <div class="modal-body">                
                <form wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row">                        
                        <div class="form-group col-lg-6 col-12">
                            <label for="name">Nome</label>
                            <input type="text" wire:model="name" class="form-item">
                        </div>
                        
                        <div class="form-group col-lg-6 col-12">
                            <label for="price">Valor</label>
                            <input wire:model="price" class="form-item">
                        </div>   

                        <div class="form-group col-12">
                            <label for="description">Descrição</label>
                            <textarea wire:model="description" class="form-item"></textarea>
                        </div>   
                        
                        <div class="form-group col-12">
                            <label for="price">Imagens</label>
                            <input type="file" wire:model="images" class="form-item" multiple>
                        </div>                          
                    </div>

                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-close"
                            wire:click="closeCreateMEdit">Fechar</button>

                        <button type="submit" class="btn btn-save"> Salvar</button>
                            {{-- {{ $isProcessing ? 'disabled' : '' }}>Salvar</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>        
    @endif

    <!-- Edit Modal -->
    @if ($showEditModal)
    <div class="modal show" id="modal">
        <div class="modal-content">
            <div class="modal-header  d-flex justify-between align-center">
                <h5 class="modal-title m-0">Cadastrar Produto</h5>
                <button type="button" class="modal-close" title="FECHAR MODAL"
                    wire:click="$set('showEditModal', false)"><i class="fa-solid fa-xmark click"
                        aria-hidden="true"></i></button>
            </div>

            <div class="modal-body">                
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="row">                        
                        <div class="form-group col-lg-6 col-12">
                            <label for="name">Nome</label>
                            <input type="text" wire:model="name" class="form-item">
                        </div>
                        
                        <div class="form-group col-lg-6 col-12">
                            <label for="price">Valor</label>
                            <input wire:model="price" class="form-item">
                        </div>   

                        <div class="form-group col-12">
                            <label for="description">Descrição</label>
                            <textarea wire:model="description" class="form-item"></textarea>
                        </div>   
                        
                        <div class="form-group col-12">
                            <label for="price">Imagens</label>
                            <input type="file" wire:model="images" class="form-item" multiple>
                        </div>                          
                    </div>

                    <div class="col-12 text-right">
                        <button type="button" class="btn btn-close"
                            wire:click="closeEditeModal">Fechar</button>

                        <button type="submit" class="btn btn-save"> Salvar</button>
                            {{-- {{ $isProcessing ? 'disabled' : '' }}>Salvar</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>     
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-0">Confirmar Exclusão</h5>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir este produto?</p>
                    </div>
                    <div class="modal-footer col-12 text-right">
                        <button type="button" class="btn btn-close" wire:click="closeDeleteModal">Cancelar</button>
                        <button type="button" class="btn btn-save" wire:click="delete">Confirmar
                            Exclusão</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
