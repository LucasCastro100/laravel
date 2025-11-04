<x-web-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Perfil Representacional') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                <div class="space-y-2">
                    <x-application-logo />
                    <h1 class="font-bold text-2xl md:text-4xl text-center">Teste do Sistema Representacional</h1>
                    <h3 class="font-bold text-center">Resultado final</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="col-span-1 lg:col-span-3">
                        <div class="flex md:flex-row items-center justify-center gap-4 mt-4 mb-6">
                            <p class="text-lg">Perfil Primário: <span class="font-bold">{{ $test->primary }}</span></p>
                            <p class="text-lg hide md:flex">|</p>
                            <p class="text-lg">Perfil Secundário: <span class="font-bold">{{ $test->secondary }}</span>
                            </p>
                        </div>

                        <table class="table-auto w-full mb-6">
                            <thead>
                                <tr class="text-left border-b">
                                    <th class="py-2">Canal</th>
                                    <th class="py-2">Pontuação</th>
                                    <th class="py-2">Percentual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($test->scores as $ch => $pontos)
                                    <tr class="border-b">
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
                        <h2 class="text-lg font-semibold mb-3 text-center">Dados do Participante</h2>

                        <div class="flex flex-col gap-4 text-gray-800">
                            <div class="flex flex-row gap-2 items-center">
                                <i class="fa-solid fa-user"></i>
                                <p class="font-medium text-gray-700">{{ $test->name ?? '—' }}</p>
                            </div>

                            <div class="flex flex-row gap-2 items-center">
                                <i class="fa-solid fa-envelope"></i>
                                <p class="font-medium text-gray-700">{{ $test->email ?? '—' }}</p>
                            </div>

                            <div class="flex flex-row gap-2 items-center">
                                <i class="fa-solid fa-phone"></i>
                                <p class="font-medium text-gray-700">{{ $test->phone ?? '—' }}</p>
                            </div>

                            <div class="flex flex-row gap-2 items-center">
                                <a href="{{ url('/teste-representacional/' . $test->uuid) }}"
                                    class="text-blue-600 underline hover:text-blue-800" target="_blank">
                                    <i class="fa-solid fa-link"></i>
                                    {{-- {{ url('/teste-representacional/' . $test->uuid) }} --}}
                                    Link do resultado
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2 col-span-1 md:col-span-3 lg:col-span-5" />

                    <div class="col-span-1 md:col-span-3 lg:col-span-5">
                        <h2 class="text-2xl font-bold mb-4 text-center">Descrição dos Perfil</h2>
                        <div class="space-y-8">
                            @foreach ($perfilUsuario as $key => $perfil)
                                <div class="space-y-2">
                                    <h3 class="font-medium text-xl">{{ $key + 1 }}. {{ $perfil['nome'] }}</h3>
                                    <p class="text-justify text-gray-700">{{ $perfil['texto'] }}</p>

                                    <p class="font-medium mt-2">
                                        <span class="font-bold">Palavra-chave:</span>
                                        <span class="text-gray-700">{{ $perfil['palavra-chave'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Arquétipo simbólico:</span>
                                        <span class="text-gray-700">{{ $perfil['arquetipo'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Força essencial</span>
                                        <span class="text-gray-700">{{ $perfil['forca-essencial'] }}</span>
                                    </p>

                                    <h4 class="font-bold mt-2">Aplicações práticas</h4>

                                    <p class="font-medium">
                                        <span class="font-bold">Aprendizagem:</span>
                                        <span class="text-gray-700">{{ $perfil['aprendizagem'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Relacionamentos amorosos:</span>
                                        <span class="text-gray-700">{{ $perfil['relacionamento'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Comunicação em público:</span>
                                        <span class="text-gray-700">{{ $perfil['comunicacao'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Vendas:</span>
                                        <span class="text-gray-700">{{ $perfil['venda'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Liderança:</span>
                                        <span class="text-gray-700">{{ $perfil['lideranca'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Integração simbólica:</span>
                                        <span class="text-gray-700">{{ $perfil['integracao'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Dicas:</span>
                                        <span class="text-gray-700">{{ $perfil['dicas'] }}</span>
                                    </p>

                                    <p class="font-medium">
                                        <span class="font-bold">Cuidados:</span>
                                        <span class="text-gray-700">{{ $perfil['cuidados'] }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-2 col-span-1 md:col-span-3 lg:col-span-5" />

                    <div class="col-span-1 md:col-span-3 lg:col-span-5 space-y-1">
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

        const labels = @json(array_keys($test->percentual)); // ['V','A','C','D']
        const dataPercentual = @json(array_values($test->percentual)); // [40, 30, 20, 10]

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Percentual (%)',
                    data: dataPercentual,
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
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-web-layout>
