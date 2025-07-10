<div class="p-6" x-data="{ tab: '{{ array_key_first($teamsByCategory) }}' }">
    @if ($event)
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-lg font-semibold text-gray-500 mb-1">Pontuação</h2>
            <p class="text-lg font-bold text-gray-800">{{ $event['nome'] }}</p>
        </div>

        {{-- TABS POR CATEGORIA --}}
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="mb-4 border-b border-gray-200">
                <nav class="flex flex-wrap gap-2">
                    @foreach ($teamsByCategory as $categorySlug => $data)
                        <button class="py-2 px-4 text-sm font-medium rounded-t-lg focus:outline-none"
                            :class="{ 'bg-blue-500 text-white': tab === '{{ $categorySlug }}', 'text-gray-600 hover:bg-gray-100': tab !== '{{ $categorySlug }}' }"
                            @click="tab = '{{ $categorySlug }}'">
                            {{ $data['label'] }}
                        </button>
                    @endforeach
                </nav>
            </div>

            {{-- CONTEÚDO DE CADA CATEGORIA --}}
            @foreach ($teamsByCategory as $categorySlug => $data)
                <div x-show="tab === '{{ $categorySlug }}'" x-transition>
                    {{-- Container grid responsivo --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Modalidades (cada tabela uma abaixo da outra no lado esquerdo) --}}
                        <div class="space-y-6 md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($data['modalities_data'] as $modality)
                                    @php
                                        $modSlug = $modality['slug'];
                                        $modLabel = $modality['label'];
                                    @endphp

                                    <div>
                                        <h3 class="text-md font-semibold text-gray-700 mb-2">{{ $modLabel }}</h3>
                                        <table class="min-w-full table-auto border border-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-4 py-2 border">Equipe</th>
                                                    <th class="px-4 py-2 border">Pontos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['modalities'][$modSlug] ?? [] as $index => $team)
                                                    <tr @if ($index === 0) class="bg-yellow-100 font-bold" @endif>
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

                        {{-- Total Geral (lado direito) com borda vertical --}}
                        <div class="border-l border-gray-300 pl-6">
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
                                        <tr
                                            class="
                                            @if ($index === 0) bg-yellow-200 font-bold
                                            @elseif ($index === 1) bg-gray-200 font-semibold
                                            @elseif ($index === 2) bg-orange-100 font-medium @endif
                                        ">
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

        </div>
    @else
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block font-bold">Event not found.</span>
        </div>
    @endif
</div>
