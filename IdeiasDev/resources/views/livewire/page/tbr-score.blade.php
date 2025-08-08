<div class="p-6">
    @if ($event && $category && $modality)
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h1 class="text-2xl font-semibold text-gray-500">Evento</h1>
            <p class="text-lg font-bold text-gray-800">{{ $event['nome'] ?? '—' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Card Categoria -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Categoria</h2>
                <p class="text-lg font-bold text-gray-800">{{ $category['label'] ?? strtoupper($category_id) }}</p>
            </div>

            <!-- Card Modalidade -->
            <div class="bg-white rounded-lg shadow p-4">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Modalidade</h2>
                <p class="text-lg font-bold text-gray-800">{{ $modality['label'] ?? strtoupper($modality_id) }}</p>
            </div>
        </div>

        @if (!empty($filteredTeams) && $question)
            {{-- Exibe select de equipes e perguntas --}}
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Selecione uma equipe</h2>

                <select wire:model.blur="selectedTeamId" class="w-full border-gray-300 rounded shadow-sm">
                    <option value="">Selecione...</option>
                    @foreach ($filteredTeams as $team)
                        <option value="{{ $team['id'] }}">{{ $team['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Critérios de Avaliação</h2>

                @if ($hasAssessment)
                    @if ($modalitieSlug == 'dp')
                        @foreach ($question as $index => $block)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-blue-700">{{ $block['description'] }}</h3>

                                <ul
                                    class="text-gray-700 list-none grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                                    {{-- <li class="flex flex-col items-center p-4 border rounded shadow justify-center">
                                        <img src="/storage/tbr/image/dp/{{ asset($block['image']) }}" alt="Imagem da questão"
                                            class="w-16 h-16 object-cover rounded shadow">
                                    </li> --}}

                                    @foreach ($block['itens'] as $itemIndex => $item)
                                        <li class="flex flex-col items-center p-4 border rounded shadow">
                                            <div
                                                class="font-bold text-lg text-gray-800 mb-2 text-center flex items-center justify-center gap-1">
                                                <span>{{ $item['value'] }}</span>
                                                @if ($block['type'] === 'number')
                                                    <i class="fas fa-times text-black"></i>
                                                @endif
                                            </div>

                                            <div class="text-sm font-medium text-gray-700 mb-2 text-center">
                                                {{ $item['name'] }}
                                            </div>

                                            <div class="flex justify-center w-full">
                                                @if ($block['type'] === 'radio')
                                                    <input type="radio" name="dp_{{ $index }}"
                                                        value="{{ $item['value'] }}"
                                                        wire:model="scores.{{ $block['mission'] }}.{{ $index }}"
                                                        class="w-5 h-5">
                                                @elseif ($block['type'] === 'number')
                                                    <input type="number" min="0" max="10"
                                                        class="w-20 border rounded px-2 py-1 text-center" min="0"
                                                        wire:model="scoresDP.{{ $block['mission'] }}.{{ $itemIndex }}"
                                                        wire:input="updateScoreDPManual($event.target.value, '{{ $block['mission'] }}.{{ $itemIndex }}')">

                                                    {{-- campo somente leitura mostrando o resultado --}}
                                                    <input type="text"
                                                        class="w-20 border rounded px-2 py-1 text-center bg-gray-100 hidden"
                                                        wire:model="scores.{{ $block['mission'] }}.{{ $itemIndex }}"
                                                        x-model="$wire.entangle('scores.{{ $block['mission'] }}.{{ $itemIndex }}')"
                                                        readonly>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                @if ($block['rules'])
                                    <div class="mt-4">
                                        <span class="font-medium text-gray-800">Bônus realizado?</span>
                                        <div class="flex gap-4 mt-2">
                                            <label>
                                                <input type="radio" name="bonus" value="sim"
                                                    wire:click="$set('bonus', 'sim')"> Sim
                                            </label>
                                            <label>
                                                <input type="radio" name="bonus" value="nao" checked
                                                    wire:click="$set('bonus', 'nao')"> Não
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <hr class="border-gray-300 my-6">
                        @endforeach
                    @else
                        @php
                            $modalitieLevel = $category['question'] ?? 'basic';
                            $radioRange = match ($modalitieLevel) {
                                'basic' => range(0, 20),
                                'advanced' => range(1, 9),
                                default => range(1, 9),
                            };
                        @endphp

                        @foreach ($question['assessment'] as $block)
                            @if (!empty($block['description']))
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-blue-700">{{ $block['object'] }}</h3>
                                    <ul class="text-gray-700 list-none">
                                        @foreach ($block['description'] as $index => $desc)
                                            <li class="mb-4">
                                                <div class="mb-2 text-gray-800 font-medium">{{ $desc }}</div>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($radioRange as $i)
                                                        <label
                                                            class="flex flex-col items-center cursor-pointer select-none">
                                                            <span
                                                                class="mb-1 text-sm font-semibold text-gray-700">{{ $i }}</span>
                                                            <input type="radio"
                                                                name="assessment_{{ $block['object'] }}_{{ $index }}"
                                                                value="{{ $i }}" class="form-radio"
                                                                wire:model="scores.{{ $block['object'] }}.{{ $index }}">
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <hr class="border-gray-300 my-6">
                            @endif
                        @endforeach
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-700">Observações</h3>
                        <textarea wire:model="comment" rows="4" class="w-full border-gray-300 rounded shadow-sm p-2"></textarea>

                        <hr class="border-gray-300 my-6">

                        <div class="text-end">
                            <button wire:click="saveScores"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700" type="button">
                                Salvar Nota
                            </button>
                        </div>
                    </div>
                @else
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                        <span class="block font-bold">Dados incompletos para exibir pontuação.</span>
                    </div>
                @endif
            </div>
        @else
            {{-- Se faltam equipes ou perguntas, mostra a mensagem --}}
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded" role="alert">
                <span class="block font-bold">Não há equipes ou perguntas para avaliação nesta
                    categoria/modalidade.</span>
            </div>
        @endif
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            <span class="block font-bold">Dados incompletos para exibir pontuação.</span>
        </div>
    @endif

    @if ($showSuccessModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-80 text-center">
                <h2 class="text-lg font-semibold mb-4">Nota salva com sucesso!</h2>

                <button onclick="window.location.reload()"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    OK
                </button>
            </div>
        </div>
    @endif
</div>
