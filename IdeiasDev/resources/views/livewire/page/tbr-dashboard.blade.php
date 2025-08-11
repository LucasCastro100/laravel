<div class="p-6">
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h1 class="text-2xl font-semibold text-gray-500">Dashboard</h1>
    </div>

    @if (count($events ?? []) === 0)

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block font-bold">Nenhum evento cadastrado.</span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
            @foreach ($events as $event)
                <div class="border rounded-lg p-4 shadow hover:shadow-lg transition relative">
                    {{-- Ícone engrenagem no topo direito --}}
                    <div x-data="{ open: false }" class="absolute top-3 right-3 z-10">
                        <button @click="open = !open" class="text-gray-700 hover:text-gray-900" title="Ações do evento"
                            aria-label="Ações do evento">
                            <i class="fas fa-cog"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-20">
                            <ul class="py-1 text-sm text-gray-700">
                                <li>
                                    <a href="{{ route('tbr.ranking', ['event_id' => $event['id']]) }}"
                                        class="block px-4 py-2 hover:bg-gray-100">
                                        Ranking
                                    </a>
                                </li>
                                <li>
                                    <button wire:click="openScoreModal('{{ $event['id'] }}')"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                        Avaliações
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route('tbr.link', ['event_id' => $event['id']]) }}" target="_blank"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                        Links das avaliações
                                    </a>
                                </li>
                                <li>
                                    <button wire:click="openEditModal('{{ $event['id'] }}')"
                                        class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                        Atualizar
                                    </button>
                                </li>
                                {{-- <li>
                                    <button wire:click="openDeleteModal('{{ $event['id'] }}')"
                                        class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                        Apagar
                                    </button>
                                </li> --}}

                                {{-- Novo item Exportar --}}
                                @if (!empty($event) && isset($event['id']))
                                    <li class="relative">
                                        <div x-data="{ open: false }">
                                            <button @click="open = !open"
                                                class="block w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center justify-between">
                                                Exportar (Vencedores)
                                                <i :class="{ 'rotate-180': open }"
                                                    class="fas fa-chevron-down transition-transform duration-200 ml-2"></i>
                                            </button>

                                            <ul x-show="open" @click.outside="open = false"
                                                class="absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded shadow-lg z-50"
                                                x-transition>
                                                <li>
                                                    <a href="{{ route('tbr.ranking.pptx', ['event_id' => $event['id']]) }}"
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                        PowerPoint
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('tbr.ranking.pdf', ['event_id' => $event['id']]) }}"
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                        PDF
                                                    </a>
                                                </li>
                                                <li>
                                                    <a wire:navigate
                                                        href="{{ route('tbr.slide', ['event_id' => $event['id']]) }}"
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                        HTML
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('tbr.ranking.scoresPdf', ['event_id' => $event['id']]) }}"
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                        Notas por Equipe
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    {{-- Conteúdo do card --}}
                    <div class="flex flex-col justify-between gap-2">
                        <h2 class="text-xl font-bold">{{ $event['nome'] }}</h2>

                        <div class="flex flex-col sm:flex-row gap-4 text-gray-600 text-sm">
                            {{-- Data com ícone --}}
                            <p class="flex items-start gap-1 whitespace-nowrap">
                                <i class="fas fa-calendar-alt mt-[3px]"></i>
                                {{ \Carbon\Carbon::parse($event['data'])->format('d/m/Y') }}
                            </p>

                            {{-- Localização com ícone --}}
                            @if (!empty($event['localizacao']['municipio']) && !empty($event['localizacao']['estado']))
                                <p class="flex items-start gap-1 whitespace-nowrap">
                                    <i class="fas fa-map-marker-alt mt-[3px]"></i>
                                    {{ $event['localizacao']['municipio']['nome'] }} -
                                    {{ $event['localizacao']['estado']['sigla'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Modal pontuação -->
    @if ($showScoreModal)
        <div class="fixed p-6 inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg p-8 w-full max-w-2xl relative"
                wire:key="score-modal-{{ $selectedEventId }}">
                <h2 class="text-2xl font-bold mb-6 text-center">{{ $selectedEventName }}</h2>

                <div class="mb-4">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Categoria</label>
                    <select wire:model.lazy="selectedCategory" id="category" class="w-full border rounded px-3 py-2">
                        <option value="">--- SELECIONE ---</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}">{{ $cat['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($selectedCategory)
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        @foreach ($modalities as $modality)
                            @php
                                $colorClass = match ($modality['slug']) {
                                    'mc' => 'bg-blue-600',
                                    'om' => 'bg-green-600',
                                    'te' => 'bg-yellow-600',
                                    'dp' => 'bg-red-600',
                                    default => 'bg-gray-600',
                                };
                            @endphp

                            <a href="{{ route('tbr.score', ['event_id' => $selectedEventId, 'category_id' => $selectedCategory, 'modality_id' => $modality['id']]) }}"
                                target="_blank"
                                class="py-2 rounded text-center text-white hover:opacity-90 transition {{ $colorClass }}">
                                {{ $modality['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-end">
                    <button wire:click="closeScoreModal"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de edição -->
    @if ($showEditModal)
        <div class="fixed p-6 inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <form wire:submit.prevent="updateEvent" class="bg-white p-6 rounded shadow w-full max-w-md max-h-[90vh] overflow-y-auto text-center space-y-6">
                <h2 class="text-xl font-bold mb-4">Editar Evento</h2>

                <div class="space-y-4 text-left">
                    <fieldset class="border border-gray-300 rounded p-4 mt-4">
                        <legend class="font-semibold mb-2">Dados Evento</legend>
                        <div class="mb-4">
                            {{-- Nome do evento --}}
                            <label class="block font-semibold">Nome do evento</label>
                            <input type="text" class="w-full border rounded px-3 py-2" placeholder="Nome do evento"
                                wire:model.defer="editEventName">
                            @error('editEventName')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            {{-- Data do evento --}}
                            <label class="block font-semibold">Data do evento</label>
                            <input type="date" class="w-full border rounded px-3 py-2"
                                wire:model.defer="editEventDate">
                            @error('editEventDate')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            {{-- Status do evento --}}
                            <label class="block font-semibold mb-1">Status do Evento</label>
                            <div class="flex gap-6">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="editEventStatus" wire:model="editEventStatus"
                                        value="0" class="form-radio text-blue-600" />
                                    <span class="ml-2 text-blue-600 font-semibold">Em andamento</span>
                                </label>

                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="editEventStatus" wire:model="editEventStatus"
                                        value="1" class="form-radio text-green-600" />
                                    <span class="ml-2 text-green-600 font-semibold">Concluído</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Localização --}}
                    <fieldset class="border border-gray-300 rounded p-4">
                        <legend class="font-semibold mb-2">Localização</legend>

                        {{-- Região --}}
                        <div class="mb-4">
                            <label class="block font-semibold">Região</label>
                            <input list="editRegions" wire:model.lazy="editSelectedRegion"
                                class="w-full border rounded px-3 py-2" placeholder="Digite ou selecione a região" />

                            <datalist id="editRegions">
                                @foreach ($regions as $region)
                                    {{-- agora value = nome (para o usuário) --}}
                                    <option value="{{ $region['nome'] }}"></option>
                                @endforeach
                            </datalist>

                            <div wire:loading.delay wire:target="editSelectedRegion" wire:loading.class='w-full p-2'>
                                <span class="font-semibold">Carregando Estados...</span>
                            </div>
                        </div>

                        {{-- Estado --}}
                        @if ($editSelectedRegionId)
                            <div class="mb-4">
                                <label class="block font-semibold">Estado</label>

                                @if (count($filteredEditStates) > 0)
                                    <input list="editStates" wire:model.lazy="editSelectedState"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="Digite ou selecione o estado" />

                                    <datalist id="editStates">
                                        @foreach ($filteredEditStates as $state)
                                            <option value="{{ $state['nome'] }}"></option>
                                        @endforeach
                                    </datalist>
                                @endif

                                <div wire:loading.delay wire:target="editSelectedState"
                                    wire:loading.class='w-full p-2'>
                                    <span class="font-semibold">Carregando Municípios...</span>
                                </div>
                            </div>
                        @endif

                        {{-- Município --}}
                        @if ($editSelectedStateId)
                            <div class="mb-0">
                                <label class="block font-semibold">Município</label>
                                @if (count($filteredEditCities) > 0)
                                    <input list="editCities" wire:model.lazy="editSelectedCity"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="Digite ou selecione o município" />

                                    <datalist id="editCities">
                                        @foreach ($filteredEditCities as $city)
                                            <option value="{{ $city['nome'] }}"></option>
                                        @endforeach
                                    </datalist>
                                @endif
                            </div>
                        @endif
                    </fieldset>

                    {{-- Configuração do Ranking / PowerPoint --}}
                    <fieldset class="border border-gray-300 rounded p-4 mt-4">
                        <legend class="font-semibold mb-2">Configuração do Ranking / Exportação</legend>

                        {{-- Modalidades --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Modalidades para exibir:</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach (['ap' => 'AP', 'mc' => 'MC', 'om' => 'OM', 'te' => 'TE', 'dp' => 'DP'] as $key => $label)
                                    <label class="inline-flex items-center gap-2">
                                        <input type="checkbox" wire:model.defer="editRankingConfig.modalities_to_show"
                                            value="{{ $key }}"
                                            class="form-checkbox h-5 w-5 text-purple-600" />
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('editRankingConfig.modalities_to_show')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Número de posições por modalidade --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Número de posições por modalidade:</label>
                            <input type="number" min="0" max="3"
                                wire:model.defer="editRankingConfig.top_positions"
                                class="border rounded px-3 py-2 w-20" />
                            @error('editRankingConfig.top_positions')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Número de posições no ranking geral --}}
                        <div>
                            <label class="block font-medium mb-1">Número de posições no ranking geral:</label>
                            <input type="number" min="1" max="5"
                                wire:model.defer="editRankingConfig.general_top_positions"
                                class="border rounded px-3 py-2 w-20" />
                            @error('editRankingConfig.general_top_positions')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>
                </div>

                <div class="text-right space-x-2 mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Atualizar</button>
                    <button type="button" wire:click="closeEditModal"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition">Fechar</button>
                </div>

                <div wire:loading wire:target="updateEvent" class="w-full p-2">
                    <span class="font-semibold">Atualizando evento...</span>
                </div>
            </form>
        </div>
    @endif

    <!-- Modal de confirmação para apagar -->
    @if ($showDeleteModal)
        <div class="fixed p-6 inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4 text-center text-red-600">Confirmação</h2>
                <p class="mb-4 text-center">Tem certeza que deseja apagar este evento?</p>

                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="closeDeleteModal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancelar</button>
                    <button type="button" wire:click="deleteEvent"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Apagar</button>
                </div>
            </div>
        </div>
    @endif
</div>
