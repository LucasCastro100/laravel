<div x-data="{ collapsed: false }" class="flex h-screen">
    {{-- Sidebar --}}
    <div :class="collapsed ? 'w-auto' : 'w-56'"
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
            <li>
                <a wire:navigate href="/dashboard" class="flex items-center space-x-3 hover:text-blue-600 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Dashboard</span>
                </a>
            </li>

            <li>
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
            </li>

            <li>
                <a wire:navigate href="/pontuacao" class="flex items-center space-x-3 hover:text-blue-600 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path d="M11 17a4 4 0 100-8 4 4 0 000 8zm-7 4a9 9 0 0114 0H4z" />
                    </svg>
                    <span x-show="!collapsed" class="whitespace-nowrap">Pontuação</span>
                </a>
            </li>
        </ul>
    </div>

    {{-- Conteúdo principal --}}
    <div class="flex-1 overflow-y-auto p-6">
        <div class="grid gap-6 grid-cols-1 md:grid-cols-12">
            {{-- Input Quantidade equipes --}}
            <div class="md:col-span-12">
                <label for="numTeams" class="block font-semibold mb-1">Quantas equipes deseja adicionar?</label>
                <input type="number" id="numTeams" min="1" wire:model.lazy="numTeams"
                    class="border rounded px-3 py-2 w-24" />
            </div>

            {{-- Formulário --}}
            <form wire:submit.prevent="saveTeams" class="md:col-span-12 space-y-6">
                @foreach ($teams as $index => $team)
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-3 items-end">
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
                        <div class="col-span-3 md:col-span-1">
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

                {{-- Botões --}}
                <div class="flex space-x-4 mt-6">
                    <button type="button" wire:click="saveTeams"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Cadastrar Equipes
                    </button>

                    <button type="button" wire:click="clearStorage"
                        class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                        Limpar Dados Salvos
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
