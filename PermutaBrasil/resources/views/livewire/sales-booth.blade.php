<div class="col-12">
    @if ($message)
        <div class="w-100 mb-1 alert {{ $status === 'success' ? 'alert-success' : 'alert-erro' }}">
            {{ $message }}
        </div>
    @endif

    <div class="mb-1">
        <input type="text" wire:model.live="searchSaleBooth" placeholder="Buscar por PRODUTO..." class="form-item">
    </div>

    @if ($sales->isEmpty())
        <h2 class="bold m-0">Nenhum dado cadastrado!</h2>
    @else
        <div class="card-container">
            @foreach ($sales as $shelf)
                <div class="card">
                    @if (!empty($shelf->images) && is_array($shelf->images) && count($shelf->images) > 0)
                        <img src="{{ Storage::url($shelf->images[0]) }}" alt="{{ $shelf->product_name }}"
                            class="card-img">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $shelf->name }}</h5>
                        <p class="card-text">R$ {{ $shelf->price }}</p>
                        <div class="d-flex-align-center justidy-center flex-direction-row gap">
                            <button wire:click="openViewModal({{ $shelf->id }})">VISUALIZAR</button>

                            @if ($shelf->user_id !== Auth::id())
                            <form
                                action="{{ route('dashboard.friend.convity.saleBooth', ['friendId' => $shelf->user_id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn">TENHO INTERESSE</button>
                            </form>    
                            @endif                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $sales->links() }}

        @if ($showViewModal)
            <div class="modal">
                <div class="modal-content">
                    <button type="button" class="modal-close" title="FECHAR MODAL" wire:click="closeViewModal">
                        <i class="fa-solid fa-xmark click" aria-hidden="true"></i>
                    </button>
                    @if ($selectedItem)                    
                        <h2>{{ $selectedItem->user->client->name }}</h2>
                        <h4>{{ $selectedItem->name }}</h4>
                        <p>{{ $selectedItem->description }}</p>
                        <p>R$ {{ $selectedItem->price }}</p>
                        <div>
                            @foreach ($selectedItem->images as $image)
                                <img src="{{ Storage::url($image) }}" alt="{{ $selectedItem->product_name }}"
                                    width="100">
                            @endforeach
                        </div>
                        <p>Cadastrado em: {{ $selectedItem->created_at->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>
        @endif
    @endif
</div>
