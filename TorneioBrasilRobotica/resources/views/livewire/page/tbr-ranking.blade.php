<div class="p-6" x-data="{ tab: '{{ array_key_first($teamsByCategory) ?? '' }}' }">
    @if ($event)
        {{-- Cabeçalho evento --}}
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h1 class="text-3xl font-semibold text-gray-500 mb-1">Pontuação</h1>
            <p class="text-lg font-bold text-gray-800">{{ $event['nome'] }}</p>
        </div>

        @if (empty($teamsByCategory))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block font-bold">Nenhuma equipe cadastrada ou pontuada ainda.</span>
            </div>
        @else
            {{-- TABS POR CATEGORIA --}}
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="mb-4 border-b border-gray-200">
                    <nav class="flex flex-wrap gap-2">
                        @foreach ($teamsByCategory as $categorySlug => $data)
                            <button class="py-2 px-4 text-sm font-medium rounded-t-lg focus:outline-none"
                                :class="{
                                    'bg-blue-500 text-white': tab === '{{ $categorySlug }}',
                                    'text-gray-600 hover:bg-gray-100': tab !== '{{ $categorySlug }}'
                                }"
                                @click="tab = '{{ $categorySlug }}'">
                                {{ $data['label'] }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                {{-- CONTEÚDO DE CADA CATEGORIA --}}
                @foreach ($teamsByCategory as $categorySlug => $data)
                    @php
                        $hasModalities = count($data['modalities_data']) > 0;
                        $totalColSpan = $hasModalities ? 1 : 3;
                        $topPos = $data['top_positions'] ?? 3;
                        $generalTopPos = $data['general_top_positions'] ?? 3;
                        $borderClass = $hasModalities ? 'border-l border-gray-300 pl-6' : '';
                    @endphp

                    <div x-show="tab === '{{ $categorySlug }}'" x-transition>
                        <div class="grid grid-cols-1 md:grid-cols-{{ $hasModalities ? '3' : '1' }} gap-6">
                            @if ($hasModalities)
                                {{-- Modalidades --}}
                                <div class="space-y-6 md:col-span-2">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($data['modalities_data'] as $modality)
                                            @php
                                                $modSlug = $modality['slug'];
                                                $modLabel = $modality['label'];
                                                $teamsModalities = $data['modalities'][$modSlug] ?? [];
                                            @endphp

                                            <div>
                                                <h3 class="text-md font-semibold text-gray-700 mb-2">{{ $modLabel }}
                                                </h3>
                                                <table class="min-w-full table-auto border border-gray-200">
                                                    <thead class="bg-gray-100">
                                                        <tr>
                                                            <th class="px-4 py-2 border">Equipe</th>
                                                            <th class="px-4 py-2 border">Pontos</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($teamsModalities as $index => $team)
                                                            <tr @if ($index < $topPos) @if ($index === 0) class="bg-yellow-100 font-bold"
                                                                    @elseif ($index === 1) class="bg-gray-200 font-semibold"
                                                                    @elseif ($index === 2) class="bg-orange-100 font-medium" @endif
                                                                @endif
                                                                >
                                                                <td class="px-4 py-2 border">{{ $team['name'] }}</td>
                                                                <td class="px-4 py-2 border text-blue-600">
                                                                    {{ number_format($team['score'], 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Total Geral --}}
                            <div class="{{ $borderClass }} md:col-span-{{ $totalColSpan }}">
                                <h3 class="text-md font-semibold text-gray-700 mb-2">Pontuação Geral</h3>
                                <table class="min-w-full table-auto border border-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 border">Equipe</th>
                                            <th class="px-4 py-2 border">Pontos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['total'] as $index => $team)
                                            <tr @if ($index < $generalTopPos) @if ($index === 0) class="bg-yellow-200 font-bold"
                                                    @elseif ($index === 1) class="bg-gray-200 font-semibold"
                                                    @elseif ($index === 2) class="bg-orange-100 font-medium" @endif
                                                @endif
                                                >
                                                <td class="px-4 py-2 border">{{ $team['name'] }}</td>
                                                <td class="px-4 py-2 border text-green-600">
                                                    {{ number_format($team['total'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @endforeach

                @if (!empty($event) && isset($event['id']))
                    <div class="text-right space-x-2 mt-6">
                        <a href="{{ route('ranking.pptx', ['event_id' => $event['id']]) }}"
                            class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 inline-block mb-4">
                            Visualizar PowerPoint
                        </a>

                        <a href="{{ route('ranking.pdf', ['event_id' => $event['id']]) }}"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 inline-block mb-4">
                            Visualizar PDF
                        </a>

                        <a wire:navigate href="{{ route('tbr.slide', ['event_id' => $event['id']]) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block mb-4">
                            Visualizar Html
                        </a>
                    </div>
                @endif
            </div>
        @endif
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block font-bold">Evento não encontrado.</span>
        </div>
    @endif
</div>
