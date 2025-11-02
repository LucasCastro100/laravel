<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do aluno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="col-span-1 md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Cursos') }}
                    </h2>

                    @if ($courses->isEmpty())
                        <div class="text-center
                        text-gray-500">
                            Mais cursos em breve!
                        </div>
                    @else
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($courses as $index => $course)
                                <div
                                    class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                                    <img src="{{ Storage::url($course->image) }}" alt="Imagem do curso"
                                        class="w-full h-48 object-cover">

                                    <div class="p-4">
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $course->title }}</h3>
                                        <p class="text-gray-600 mt-2">{{ Str::limit($course->description, 100) }}</p>
                                    </div>

                                    <div class="py-4 text-right">
                                        @if (in_array($course->id, $userCourseIds))
                                            <span
                                                class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-green-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-800 dark:text-white dark:border-gray-600 dark:hover:bg-green-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                onclick="window.location.href = '{{ route('student.courseShow', ['uuid' => $course->uuid]) }}'">Acessar</span>
                                        @else
                                            <form
                                                action="{{ route('matriculation.course.store', ['course_uuid' => $course->uuid, 'user_uuid' => Auth::user()->uuid]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                                    Matrícular
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-4">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Teste Representacional') }}
                    </h2>

                    @if (empty($test) || empty($percentual))
                        <div class="text-center text-gray-500">
                            <a href="{{ route('student.myTests') }}">
                                <x-primary-button class="block">
                                    Realize o teste!
                                </x-primary-button>
                            </a>
                        </div>
                    @else
                        <div class="mb-6 w-full max-w-md mx-auto">
                            <canvas id="percentualChart" class="w-full h-64"></canvas>
                        </div>

                        <div class="text-center text-gray-500">
                            <a href="{{ route('student.resultTest') }}">
                                <x-primary-button class="block">
                                    Resultado
                                </x-primary-button>
                            </a>
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
