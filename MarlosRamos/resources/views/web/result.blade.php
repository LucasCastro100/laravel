<x-web-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Relatório de Perfil Representacional" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-800 text-gray-200">

                <div class="space-y-2">
                    <x-application-logo class="w-1/2 md:w-44 fill-current mx-auto text-white" />
                    <h1 class="font-bold text-2xl md:text-4xl text-center text-white">Teste do Sistema Representacional</h1>
                    <h3 class="font-bold text-center text-gray-400">Resultado final</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="col-span-1 lg:col-span-3">
                        <div class="flex md:flex-row items-center justify-center gap-4 mt-4 mb-6">
                            <p class="text-lg">Perfil Primário: <span class="font-bold text-blue-400">{{ $test->primary }}</span></p>
                            <p class="text-lg hide md:flex text-gray-200">|</p>
                            <p class="text-lg">Perfil Secundário: <span class="font-bold text-blue-400">{{ $test->secondary }}</span>
                            </p>
                        </div>

                        <table class="table-auto w-full mb-6 text-gray-200">
                            <thead>
                                <tr class="text-left border-b border-gray-700">
                                    <th class="py-2">Canal</th>
                                    <th class="py-2">Pontuação</th>
                                    <th class="py-2">Percentual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($test->scores as $ch => $pontos)
                                    <tr class="border-b border-gray-800">
                                        <td class="py-1 font-semibold">{{ $ch }}</td>
                                        <td class="py-1">{{ $pontos }}</td>
                                        <td class="py-1">{{ $test->percentual[$ch] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-span-1">
                        <div class="mb-6 w-full max-w-md mx-auto">
                            <canvas id="percentualChart" class="w-full h-64"></canvas>
                        </div>
                    </div>

                    <div class="col-span-1">
                        <h2 class="text-lg font-semibold mb-3 text-center text-white">Dados do Participante</h2>

                        <div class="flex flex-col gap-4 text-gray-400">
                            <div class="flex flex-row gap-2 items-center">
                                <i class="fa-solid fa-user text-blue-400"></i>
                                <p class="font-medium text-gray-300">{{ $test->name ?? '—' }}</p>
                            </div>

                            <div class="flex flex-row gap-2 items-center">
                                <i class="fa-solid fa-envelope text-blue-400"></i>
                                <p class="font-medium text-gray-300">{{ $test->email ?? '—' }}</p>
                            </div>

                            <div class="flex flex-row gap-2 items-center">
                                <i class="fa-solid fa-phone text-blue-400"></i>
                                <p class="font-medium text-gray-300">{{ $test->phone ?? '—' }}</p>
                            </div>

                            <div class="flex flex-row gap-2 items-center">
                                <a href="{{ url('/teste-representacional/' . $test->uuid) }}"
                                    class="text-blue-400 underline hover:text-blue-300" target="_blank">
                                    <i class="fa-solid fa-link"></i>
                                    Link do resultado
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2 col-span-1 md:col-span-3 lg:col-span-5 border-gray-700" />

                    <div class="col-span-1 md:col-span-3 lg:col-span-5">
                        <h2 class="text-2xl font-bold mb-4 text-center text-white">Descrição dos Perfil</h2>
                        <div class="space-y-8">
                            @foreach ($perfilUsuario as $key => $perfil)
                                <div class="space-y-2">
                                    <h3 class="font-medium text-xl text-blue-400">{{ $key + 1 }}. {{ $perfil['nome'] }}</h3>
                                    <p class="text-justify text-gray-300">{{ $perfil['texto'] }}</p>

                                    <p class="font-medium mt-2">
                                        <span class="font-bold text-gray-400">Palavra-chave:</span>
                                        <span class="text-gray-300">{{ $perfil['palavra-chave'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Arquétipo simbólico:</span>
                                        <span class="text-gray-300">{{ $perfil['arquetipo'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Força essencial</span>
                                        <span class="text-gray-300">{{ $perfil['forca-essencial'] }}</span>
                                    </p>

                                    <h4 class="font-bold mt-2 text-blue-300">Aplicações práticas</h4>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Aprendizagem:</span>
                                        <span class="text-gray-300">{{ $perfil['aprendizagem'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Relacionamentos amorosos:</span>
                                        <span class="text-gray-300">{{ $perfil['relacionamento'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Comunicação em público:</span>
                                        <span class="text-gray-300">{{ $perfil['comunicacao'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Vendas:</span>
                                        <span class="text-gray-300">{{ $perfil['venda'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Liderança:</span>
                                        <span class="text-gray-300">{{ $perfil['lideranca'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Integração simbólica:</span>
                                        <span class="text-gray-300">{{ $perfil['integracao'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Dicas:</span>
                                        <span class="text-gray-300">{{ $perfil['dicas'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold text-gray-400">Cuidados:</span>
                                        <span class="text-gray-300">{{ $perfil['cuidados'] }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-2 col-span-1 md:col-span-3 lg:col-span-5 border-gray-700" />

                    <div class="col-span-1 md:col-span-3 lg:col-span-5 space-y-1 text-gray-400">
                        <p class="font-medium text-center">Sua mente cria a imagem.</p>
                        <p class="font-medium text-center">Sua voz dá forma à emoção.</p>
                        <p class="font-medium text-center">Seu corpo sente o caminho.</p>
                        <p class="font-medium text-center">Sua razão constrói o método.</p>
                        <p class="font-medium text-center">Quando esses quatro centros trabalham juntos, nasce a
                            verdadeira Alquimia da Comunicação.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('percentualChart').getContext('2d');
        const labels = @json(array_keys($test->percentual));
        const dataPercentual = @json(array_values($test->percentual));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Percentual (%)',
                    data: dataPercentual,
                    backgroundColor: ['#60a5fa', '#f87171', '#fbbf24', '#2dd4bf'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#e5e7eb', font: { size: 14 } }
                    }
                }
            }
        });
    </script>
</x-web-layout>

