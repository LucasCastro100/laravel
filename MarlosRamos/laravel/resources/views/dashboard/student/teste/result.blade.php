<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relatório de Perfil Representacional') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4 text-center">Resultado Final</h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex flex-col md:flex-row items-center justify-center gap-4 mt-4 mb-6">
                            <p class="text-lg">Perfil Primário: <span class="font-bold">{{ $primary }}</span></p>
                            <p class="text-lg hide md:flex">|</p>
                            <p class="text-lg">Perfil Secundário: <span class="font-bold">{{ $secondary }}</span></p>
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
                                @foreach ($scores as $ch => $pontos)
                                    <tr class="border-b">
                                        <td class="py-1 font-semibold">{{ $ch }}</td>
                                        <td class="py-1">{{ $pontos }}</td>
                                        <td class="py-1">{{ $percentual[$ch] }}%</td>
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
                </div>

                {{-- Exibir respostas do usuário --}}
                {{-- <h2 class="text-xl font-semibold mb-2">Suas Respostas:</h2>
                <ul class="list-disc pl-6">
                    @foreach ($answers as $question => $answer)
                        <li><strong>{{ $question }}:</strong> {{ $answer }}</li>
                    @endforeach
                </ul> --}}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('percentualChart').getContext('2d');

        const labels = @json(array_keys($percentual)); // ['V','A','C','D']
        const dataPercentual = @json(array_values($percentual)); // [40, 30, 20, 10]

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

</x-app-layout>
