<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Painel do Aluno" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="col-span-1 md:col-span-2 bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h2 class="text-lg font-medium text-gray-100 mb-4">
                        {{ __('Cursos') }}
                    </h2>

                    @if ($courses->isEmpty())
                        <x-empty-state title="Mais cursos em breve!" message="Novos conteúdos aparecerão aqui em breve." />
                    @else
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($courses as $course)
                                <x-course-card
                                    title="{{ $course->title }}"
                                    description="{{ $course->description }}"
                                    image="{{ Storage::url($course->image_cover) }}"
                                >
                                    @if (in_array($course->id, $userCourseIds))
                                        <x-action-button href="{{ route('student.courseShow', ['uuid' => $course->uuid]) }}" variant="primary">Acessar</x-action-button>
                                    @else
                                        @if ($course->price > 0 && !empty($course->payment_link))
                                            <x-action-button href="{{ $course->payment_link }}" variant="primary">Comprar</x-action-button>
                                        @else
                                            <form action="{{ route('matriculation.course.store', ['course_uuid' => $course->uuid, 'user_uuid' => Auth::user()->uuid]) }}" method="POST">
                                                @csrf
                                                <x-action-button type="submit" variant="secondary">Matrícular</x-action-button>
                                            </form>
                                        @endif
                                    @endif
                                </x-course-card>
                            @endforeach
                        </div>

                        <div class="p-4">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-span-1 bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200">
                    <h2 class="text-lg font-medium text-gray-200 mb-4">
                        {{ __('Teste Representacional') }}
                    </h2>

                    @if (empty($test) || empty($percentual))
                        <div class="text-center text-gray-200">
                            <x-action-button href="{{ route('student.myTests') }}" variant="primary" class="w-full justify-center">
                                Realize o teste!
                            </x-action-button>
                        </div>
                    @else
                        <div class="mb-6 w-full max-w-md mx-auto">
                            <canvas id="percentualChart" class="w-full h-64"></canvas>
                        </div>

                        <div class="text-center text-gray-200">
                            <x-action-button href="{{ route('student.resultTest') }}" variant="secondary" class="w-full justify-center">
                                Resultado
                            </x-action-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@if (!empty($percentual))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

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
                        position: 'right',
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
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value) => value + '%'
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
@endif
