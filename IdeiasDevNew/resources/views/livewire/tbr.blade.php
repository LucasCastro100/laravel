<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">
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

                    {{-- Botão --}}
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
</div>
