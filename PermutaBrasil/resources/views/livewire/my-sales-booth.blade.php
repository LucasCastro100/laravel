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
                                <img src="{{ Storage::url($image) }}" alt="{{ $shelf->name }}"
                                    class="img-thumbnail" width="50">
                            @endforeach
                        </td>
                        <td>
                            <button wire:click="openEditModal({{ $shelf->id }})"
                                class="btn btn-warning">Editar</button>
                            <button wire:click="confirmDelete({{ $shelf->id }})"
                                class="btn btn-danger">Excluir</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $sales->links() }}

    <!-- Create Modal -->
    @if ($showCreateModal)
        <div class="modal">
            <div class="modal-content">
                <button type="button" class="modal-close" title="FECHAR MODAL" wire:click="closeCreateModal">
                    <i class="fa-solid fa-xmark click" aria-hidden="true"></i>
                </button>
                <h2>Cadastrar Produto</h2>
                <form wire:submit.prevent="submit">
                    <input type="text" wire:model="name" placeholder="Nome do Produto" required>
                    <textarea wire:model="description" placeholder="Descrição" required></textarea>
                    <input wire:model="price" placeholder="Preço" required>
                    <input type="file" wire:model="images" multiple>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit Modal -->
    @if ($showEditModal)
        <div class="modal">
            <div class="modal-content">
                <button type="button" class="modal-close" title="FECHAR MODAL" wire:click="closeEditModal">
                    <i class="fa-solid fa-xmark click" aria-hidden="true"></i>
                </button>
                <h2>Editar Produto</h2>
                <form wire:submit.prevent="update">
                    <input type="text" wire:model="name" placeholder="Nome do Produto" required>
                    <textarea wire:model="description" placeholder="Descrição" required></textarea>
                    <input type="number" wire:model="price" placeholder="Preço" required>
                    <input type="file" wire:model="images" multiple>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="modal">
            <div class="modal-content">
                <button type="button" class="modal-close" title="FECHAR MODAL" wire:click="closeDeleteModal">
                    <i class="fa-solid fa-xmark click" aria-hidden="true"></i>
                </button>
                <h2>Confirmar Exclusão</h2>
                <p>Tem certeza de que deseja excluir este produto?</p>
                <button wire:click="delete" class="btn btn-danger">Deletar</button>
                <button wire:click="closeDeleteModal" class="btn btn-secondary">Cancelar</button>
            </div>
        </div>
    @endif
</div>
