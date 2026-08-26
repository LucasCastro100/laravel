@php
    $hora = now()->hour;
    $saudacao = $hora < 12 ? 'Bom dia' : ($hora < 18 ? 'Boa tarde' : 'Boa noite');
@endphp

<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Painel do Aluno" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Banner de boas-vindas --}}
            <div class="relative bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden p-6">
                <div class="relative z-10">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">{{ now()->format('d/m/Y') }}</p>
                    <h1 class="text-2xl font-bold text-gray-100">{{ $saudacao }}, {{ Auth::user()->name }}!</h1>
                    <p class="text-sm text-gray-400 mt-1">Bem-vindo ao seu painel de aprendizagem.</p>
                </div>
                <div class="absolute inset-y-0 right-0 w-1/3 bg-gradient-to-l from-blue-500/5 to-transparent pointer-events-none"></div>
            </div>

            {{-- Ações rápidas --}}
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">Ações Rápidas</p>
                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('student.myCourses') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-blue-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 group-hover:bg-blue-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-book-open text-blue-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Meus Cursos</span>
                    </a>

                    <a href="{{ route('student.myTests') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-purple-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 group-hover:bg-purple-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-clipboard-list text-purple-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Meus Testes</span>
                    </a>

                    <a href="{{ route('student.duvidas') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-teal-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-teal-500/10 group-hover:bg-teal-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-circle-question text-teal-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Dúvidas</span>
                    </a>
                </div>
            </div>

            {{-- Conteúdo principal --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Cursos --}}
                <div class="lg:col-span-2 bg-gray-900 rounded-2xl border border-gray-800 p-6">
                    <div class="flex items-center justify-between gap-3 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                            <h2 class="text-base font-semibold text-gray-100">Cursos Disponíveis</h2>
                        </div>
                    </div>

                    {{-- Busca --}}
                    <form method="GET" action="{{ route('student.dashBoard') }}" class="mb-5">
                        <div class="flex items-center gap-2 bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 focus-within:border-blue-500 transition">
                            <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs shrink-0"></i>
                            <input type="text" name="search" value="{{ $search ?? '' }}"
                                   class="bg-transparent flex-1 text-sm text-gray-200 placeholder-gray-500 outline-none"
                                   placeholder="Buscar curso...">
                            @if ($search)
                                <a href="{{ route('student.dashBoard') }}" class="text-gray-500 hover:text-gray-300 transition shrink-0">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </a>
                            @endif
                        </div>
                    </form>

                    @if ($courses->isEmpty())
                        <x-empty-state
                            title="{{ $search ? 'Nenhum curso encontrado' : 'Mais cursos em breve!' }}"
                            message="{{ $search ? 'Tente buscar por outro termo.' : 'Novos conteúdos aparecerão aqui em breve.' }}" />
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                                                <x-action-button type="submit" variant="secondary">Matricular</x-action-button>
                                            </form>
                                        @endif
                                    @endif
                                </x-course-card>
                            @endforeach
                        </div>

                        <div class="pt-4">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>

                {{-- Teste Representacional --}}
                <div class="lg:col-span-1 bg-gray-900 rounded-2xl border border-gray-800 p-6 flex flex-col">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-1 h-6 bg-purple-500 rounded-full"></div>
                        <h2 class="text-base font-semibold text-gray-100">Perfil Representacional</h2>
                    </div>

                    @if (empty($test) || empty($percentual))
                        <div class="flex flex-col items-center justify-center flex-1 gap-4 py-8 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-purple-500/10 flex items-center justify-center">
                                <i class="fa-solid fa-brain text-purple-400 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-200">Descubra seu perfil!</p>
                                <p class="text-xs text-gray-500 mt-1">Realize o teste representacional e entenda como você aprende melhor.</p>
                            </div>
                            <a href="{{ route('student.myTests') }}"
                                class="flex items-center gap-2 px-5 py-2.5 bg-purple-600 hover:bg-purple-500 text-white text-sm font-medium rounded-lg transition">
                                <i class="fa-solid fa-play text-xs"></i>
                                Realizar o Teste
                            </a>
                        </div>
                    @else
                        <div class="flex flex-col gap-4 flex-1">
                            {{-- Perfis primário/secundário --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-800/60 rounded-xl border border-green-500/20 p-3 text-center">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Primário</p>
                                    <p class="text-3xl font-extrabold text-green-400">{{ $test->primary }}</p>
                                </div>
                                <div class="bg-gray-800/60 rounded-xl border border-orange-500/20 p-3 text-center">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Secundário</p>
                                    <p class="text-3xl font-extrabold text-orange-400">{{ $test->secondary }}</p>
                                </div>
                            </div>

                            {{-- Gráfico --}}
                            <div class="flex-1 flex items-center justify-center min-h-[180px]">
                                <canvas id="percentualChart" class="w-full max-h-52"></canvas>
                            </div>

                            {{-- Botão resultado --}}
                            <a href="{{ route('student.resultTest') }}"
                                class="flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-200 text-sm font-medium rounded-lg transition w-full">
                                <i class="fa-solid fa-chart-pie text-xs"></i>
                                Ver Resultado Completo
                            </a>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    @if (!empty($percentual))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
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
                        legend: {
                            position: 'bottom',
                            labels: { color: '#9ca3af', font: { size: 11 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ctx.label + ': ' + ctx.raw + '%'
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            font: { weight: 'bold', size: 12 },
                            formatter: (value) => value + '%'
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        </script>
    @endif

</x-app-layout>


