<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Resultado do Perfil Representacional" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl space-y-6">

            {{-- Cards primário/secundário + gráfico --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Primário e Secundário empilhados em 1/3 --}}
                <div class="flex flex-col gap-4">
                    <div class="bg-gray-900 rounded-2xl border border-green-500/20 p-5 flex-1">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Perfil Primário</p>
                        <p class="text-4xl font-extrabold text-green-400">{{ $primary }}</p>
                    </div>
                    <div class="bg-gray-900 rounded-2xl border border-orange-500/20 p-5 flex-1">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Perfil Secundário</p>
                        <p class="text-4xl font-extrabold text-orange-400">{{ $secondary }}</p>
                    </div>
                </div>

                {{-- Gráfico ocupa os 2/3 restantes --}}
                <div class="md:col-span-2 bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center justify-center min-h-[220px]">
                    <canvas id="percentualChart" class="w-full max-h-64"></canvas>
                </div>

            </div>

            {{-- Tabela de pontuação --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                    <h2 class="text-base font-semibold text-gray-100">Pontuação por Canal</h2>
                </div>
                <div class="overflow-x-auto rounded-xl border border-gray-800">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-800 bg-gray-950/60">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Canal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Pontuação</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Percentual</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($scores as $ch => $pontos)
                                <tr class="hover:bg-gray-800/40 transition">
                                    <td class="px-4 py-3.5 font-bold text-gray-100">{{ $ch }}</td>
                                    <td class="px-4 py-3.5 text-gray-300">{{ $pontos }}</td>
                                    <td class="px-4 py-3.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">{{ $percentual[$ch] }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Descrição dos Perfis --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-6 bg-purple-500 rounded-full"></div>
                    <h2 class="text-base font-semibold text-gray-100">Descrição dos Perfis</h2>
                </div>
                <div class="space-y-8">
                    @foreach ($perfilUsuario as $key => $perfil)
                        <div class="rounded-xl border border-gray-800 bg-gray-800/30 p-5 space-y-3">
                            <h3 class="font-semibold text-lg text-gray-100">{{ $key + 1 }}. {{ $perfil['nome'] }}</h3>
                            <p class="text-sm text-gray-300 leading-relaxed">{{ $perfil['texto'] }}</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2">
                                <div class="bg-gray-900 rounded-lg p-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-0.5">Palavra-chave</p>
                                    <p class="text-sm text-gray-200">{{ $perfil['palavra-chave'] }}</p>
                                </div>
                                <div class="bg-gray-900 rounded-lg p-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-0.5">Arquétipo Simbólico</p>
                                    <p class="text-sm text-gray-200">{{ $perfil['arquetipo'] }}</p>
                                </div>
                                <div class="bg-gray-900 rounded-lg p-3">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-0.5">Força Essencial</p>
                                    <p class="text-sm text-gray-200">{{ $perfil['forca-essencial'] }}</p>
                                </div>
                            </div>

                            <div class="pt-2">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">Aplicações Práticas</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach ([
                                        'Aprendizagem' => $perfil['aprendizagem'],
                                        'Relacionamentos' => $perfil['relacionamento'],
                                        'Comunicação em Público' => $perfil['comunicacao'],
                                        'Vendas' => $perfil['venda'],
                                        'Liderança' => $perfil['lideranca'],
                                        'Integração Simbólica' => $perfil['integracao'],
                                        'Dicas' => $perfil['dicas'],
                                        'Cuidados' => $perfil['cuidados'],
                                    ] as $label => $texto)
                                        <div class="bg-gray-900 rounded-lg p-3">
                                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-0.5">{{ $label }}</p>
                                            <p class="text-sm text-gray-300">{{ $texto }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Frase final --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6 text-center space-y-1">
                <p class="text-sm text-gray-400">Sua mente cria a imagem.</p>
                <p class="text-sm text-gray-400">Sua voz dá forma à emoção.</p>
                <p class="text-sm text-gray-400">Seu corpo sente o caminho.</p>
                <p class="text-sm text-gray-400">Sua razão constrói o método.</p>
                <p class="text-sm text-gray-300 font-medium mt-3">Quando esses quatro centros trabalham juntos, nasce a verdadeira Alquimia da Comunicação.</p>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('percentualChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($percentual)),
                datasets: [{
                    data: @json(array_values($percentual)),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#9ca3af', font: { size: 12 } } },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.label + ': ' + ctx.raw + '%'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>

