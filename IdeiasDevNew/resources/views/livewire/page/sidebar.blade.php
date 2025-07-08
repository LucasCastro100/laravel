<div>
    <div :class="collapsed ? 'w-auto' : 'w-64'"
        class="bg-white border-r shadow-md transition-all duration-300 ease-in-out h-full flex flex-col">

        {{-- Botão de colapsar --}}
        <div class="p-4">
            <button @click="collapsed = !collapsed" class="focus:outline-none text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Menu --}}
        <ul class="flex-1 space-y-4 px-2 mt-4 text-gray-700">
            {{-- <li>
                <a wire:navigate href="/eventos" class="flex items-center space-x-3 hover:text-blue-600 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M8 7V3M16 7V3M3 11h18M5 20h14a2 2 0 002-2V7H3v11a2 2 0 002 2z" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Eventos</span>
                </a>
            </li>

            <li>
                <a wire:navigate href="/equipes" class="flex items-center space-x-3 hover:text-blue-600 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87" />
                        <circle cx="9" cy="7" r="4" />
                        <circle cx="17" cy="7" r="4" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Equipes</span>
                </a>
            </li> --}}

            <li title="Dashboard">
                <a wire:navigate href="/dashboard" class="flex items-center space-x-3 hover:text-blue-600 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Dashboard</span>
                </a>
            </li>

            <li title="Pontuação">
                <a wire:navigate href="/pontuacao" class="flex items-center space-x-3 hover:text-blue-600 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M11 17a4 4 0 100-8 4 4 0 000 8zm-7 4a9 9 0 0114 0H4z" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Pontuação</span>
                </a>
            </li>
        </ul>

        <div class="mt-auto px-4 py-6 space-y-3">
            <button wire:click="openEventModal"
                class="flex items-center space-x-3 px-4 py-2 rounded bg-blue-600 text-white w-full hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    title="Cadastrar Eventos" stroke="currentColor">
                    <path d="M8 7V3M16 7V3M3 11h18M5 20h14a2 2 0 002-2V7H3v11a2 2 0 002 2z" />
                </svg>
                <span x-show="!collapsed"> Cadastrar Eventos </span>
            </button>

            <button wire:click="openTeamModal"
                class="flex items-center space-x-3 px-4 py-2 rounded bg-green-600 text-white w-full hover:bg-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    title="Cadastrar Equipes" stroke="currentColor">
                    <path d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87" />
                    <circle cx="9" cy="7" r="4" />
                    <circle cx="17" cy="7" r="4" />
                </svg>
                <span x-show="!collapsed"> Cadastrar Equipes </span>
            </button>

            <button wire:click="askToClearStorage"
                class="flex items-center space-x-3 px-4 py-2 rounded bg-red-600 text-white w-full hover:bg-red-700 mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                </svg>
                <span x-show="!collapsed"> Limpar Dados Salvos </span>
            </button>
        </div>
    </div>

    {{-- Modais globais --}}
    @if ($showEventModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow w-full max-w-md text-center">
                <h2 class="text-xl font-bold mb-4">Cadastrar Evento</h2>

                <div class="space-y-4">
                    <input type="text" class="w-full border rounded px-3 py-2" placeholder="Nome do evento"
                        wire:model.defer="eventName">
                    @error('eventName')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror

                    <input type="date" class="w-full border rounded px-3 py-2" wire:model.defer="eventDate">
                    @error('eventDate')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right space-x-2 mt-6">
                    {{-- Salva evento --}}
                    <button wire:click="saveEvent" class="px-4 py-2 bg-green-600 text-white rounded  hover:bg-green-700">Salvar</button>

                    {{-- Fecha modal e reseta formulário de evento --}}
                    <button wire:click="closeEventModal"
                        class="px-4 py-2 bg-gray-500 text-white rounded">Fechar</button>                    
                </div>
            </div>
        </div>
    @endif

    @if ($showTeamModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div
                class="bg-white p-6 rounded shadow w-full max-w-lg max-h-[90vh] overflow-y-auto text-center
                   sm:max-w-xl md:max-w-2xl">

                <h2 class="text-xl font-bold mb-6">Cadastrar Equipe</h2>

                {{-- Select de evento --}}
                <div class="mb-6 text-left">
                    <label for="selectedEventIndex" class="block font-semibold mb-1">Selecione o Evento:</label>
                    <select id="selectedEventIndex" wire:model="selectedEventIndex"
                        class="border rounded px-3 py-2 w-full">
                        <option value="">-- Selecione um evento --</option>
                        @foreach ($events as $index => $event)
                            <option value="{{ $index }}">{{ $event['nome'] }} ({{ $event['data'] }})</option>
                        @endforeach
                    </select>
                    @error('selectedEventIndex')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Quantidade de equipes --}}
                <div class="mb-6 text-left">
                    <label for="numTeams" class="block font-semibold mb-1">Quantas equipes deseja adicionar?</label>
                    <input type="number" id="numTeams" min="1" wire:model.lazy="numTeams"
                        class="border rounded px-3 py-2 w-24" />
                </div>

                {{-- Formulário equipes --}}
                <form wire:submit.prevent="saveTeams" class="space-y-8">
                    @foreach ($teams as $index => $team)
                        <div
                            class="grid gap-4 grid-cols-1 md:grid-cols-3 items-center
                               border border-gray-300 rounded p-4
                               @media(max-width: 768px) { grid-template-columns: 1fr !important; }">

                            {{-- Nome da equipe --}}
                            <div class="col-span-3 md:col-span-2">
                                <label for="teamName{{ $index }}" class="block font-semibold mb-1">Nome da
                                    equipe</label>
                                <input type="text" id="teamName{{ $index }}"
                                    wire:model.defer="teams.{{ $index }}.name"
                                    class="border rounded px-3 py-2 w-full" />
                                @error("teams.$index.name")
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Categoria --}}
                            <div
                                class="col-span-3 md:col-span-1 mt-4 md:mt-0 md:pl-4 border-t md:border-t-0 md:border-l border-gray-300">
                                <label for="teamCategory{{ $index }}"
                                    class="block font-semibold mb-1">Categoria</label>
                                <select id="teamCategory{{ $index }}"
                                    wire:model.defer="teams.{{ $index }}.category"
                                    class="border rounded px-3 py-2 w-full">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                    @endforeach
                                </select>
                                @error("teams.$index.category")
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div class="flex space-x-4 justify-center mt-6">
                        {{-- Envia dados das equipes --}}
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors">
                            Cadastrar Equipes
                        </button>

                        {{-- Apenas limpa o formulário de equipes (sem apagar o JSON) --}}
                        <button type="button" wire:click="resetTeamForm" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition-colors">
                            Limpar Formulário
                        </button>

                        <button wire:click="closeTeamModal"
                            class=" bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition-colors">
                            Fechar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


    @if ($confirmClearStorage)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow w-full max-w-md text-center">
                <h2 class="text-xl font-bold mb-4">Tem certeza que deseja apagar todos os dados?</h2>
                <p class="mb-6 text-gray-700">Essa ação irá limpar todos os eventos e equipes salvos no JSON.</p>

                <div class="flex justify-center space-x-4">
                    <button wire:click="cancelClearStorage"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancelar</button>

                    <button wire:click="confirmAndClearStorage"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Apagar Dados</button>
                </div>
            </div>
        </div>
    @endif
</div>
