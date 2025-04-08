<div class="col-12">
    <div class="mb-1">
        <input type="text" wire:model.live="searchService" placeholder="Buscar por SERVIÇO..." class="form-item">
    </div>

    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    <div class="w-100 overflow-x">
        @if (count($services) > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SERVIÇO</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $key => $service)
                        <tr>
                            <th>{{ $service->id }}</th>
                            <td>{{ $service->type_service }}</td>
                            <td>
                                <ul class="actions">
                                    <li class="edit">
                                        <a href="{{ route('dashboard.typeService.edit', ['uuid' => $service->uuid ]) }}" title="EDITAR">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    </li>

                                    <li class="delete">
                                        <div wire:click="confirmDelete({{ $service->id }})" class="click"><i
                                                class="fa-solid fa-trash"></i></div>
                                    </li>
                                </ul>                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($confirmingDelete)
                <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title m-0">Confirmar Exclusão</h5>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir este serviço?</p>
                            </div>
                            <div class="modal-footer col-12 text-right">
                                <button type="button" class="btn btn-close"
                                    wire:click="cancelDelete">Cancelar</button>
                                <button type="button" class="btn btn-save" wire:click="deleteService">Confirmar
                                    Exclusão</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{ $services->links() }}
        @else
            <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
        @endif
    </div>
</div>
