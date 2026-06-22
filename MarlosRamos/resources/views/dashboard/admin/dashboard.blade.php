<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Painel do administrador" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- INDICARORES  ALUNOS | PROFESSORES | CURSOS | TESTES --}}
                <div class="p-6 text-gray-100">
                    <h2 class="text-lg font-medium text-gray-100 mb-4">
                        {{ __('Indicadores de Cadastro') }}
                    </h2>

                    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                        <x-stat-card icon="fas fa-user-graduate" icon-class="text-green-500" title="Alunos" value="{{ $total_students }}" />
                        <x-stat-card icon="fas fa-chalkboard-teacher" icon-class="text-blue-500" title="Professores" value="{{ $total_teachers }}" />
                        <x-stat-card icon="fas fa-book" icon-class="text-indigo-500" title="Cursos" value="{{ $total_courses_created }}" />
                        <x-stat-card icon="fas fa-clipboard-check" icon-class="text-red-500" title="Testes" value="{{ $total_tests_created }}" />
                    </div>
                </div>

                {{-- TABS ALUNOS | PROFESSORES | CURSOS | TESTES --}}
                <div class="p-6 text-gray-100">
                    <div x-data="{ tab: 'students' }">
                        <!-- Tabs -->
                        <div class="flex flex-col sm:flex-row flex-wrap border-b border-gray-200 mb-4">
                            <button @click="tab = 'students'"
                                :class="tab === 'students' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-200'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-200 hover:border-b-2 hover:border-gray-300">
                                Alunos
                            </button>
                            <button @click="tab = 'teachers'"
                                :class="tab === 'teachers' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-200'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-200 hover:border-b-2 hover:border-gray-300">
                                Professores
                            </button>
                            <button @click="tab = 'courses'"
                                :class="tab === 'courses' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-200'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-200 hover:border-b-2 hover:border-gray-300">
                                Cursos
                            </button>
                            <button @click="tab = 'tests'"
                                :class="tab === 'tests' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-200'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-200 hover:border-b-2 hover:border-gray-300">
                                Testes
                            </button>
                        </div>

                        {{-- ALUNOS --}}
                        <div x-show="tab === 'students'" class="overflow-x-auto">
                            @if ($studentsList->isEmpty())
                                <p class="p-4 text-gray-200">Nenhum aluno cadastrado</p>
                            @else
                                <table class="w-full text-left border border-gray-700">
                                    <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">E-mail</th>
                                            <th class="p-2">Cursos Matriculados</th>
                                            <th class="p-2">Testes Matriculados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentsList as $student)
                                            <tr class="border-t border-gray-700">
                                                <td class="p-2">{{ $student->user->name }}</td>
                                                <td class="p-2">{{ $student->user->email }}</td>
                                                <td class="p-2">{{ $student->total_courses ?? 0 }}</td>
                                                <td class="p-2">{{ $student->total_tests ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="p-4">
                                    {{ $studentsList->links() }}
                                </div>
                            @endif
                        </div>

                        {{-- PROFESSORES --}}
                        <div x-show="tab === 'teachers'" class="overflow-x-auto">
                            @if ($teachersList->isEmpty())
                                <p class="p-4 text-gray-200">Nenhum professor cadastrado</p>
                            @else
                                <table class="w-full text-left border border-gray-700">
                                    <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">E-mail</th>
                                            <th class="p-2">Especialidade</th>
                                            <th class="p-2">Cursos Criados</th>
                                            <th class="p-2">Testes Criados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teachersList as $teacher)
                                            <tr class="border-t border-gray-700">
                                                <td class="p-2">{{ $teacher->user->name }}</td>
                                                <td class="p-2">{{ $teacher->user->email }}</td>
                                                <td class="p-2">{{ $teacher->specialty ?? '--' }}</td>
                                                <td class="p-2">{{ $teacher->total_courses ?? 0 }}</td>
                                                <td class="p-2">{{ $teacher->total_tests ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="p-4">
                                    {{ $teachersList->links() }}
                                </div>
                            @endif
                        </div>

                        {{-- CURSOS --}}
                        <div x-show="tab === 'courses'" class="overflow-x-auto">
                            @if ($coursesList->isEmpty())
                                <p class="p-4 text-gray-200">Nenhum curso cadastrado</p>
                            @else
                                <table class="w-full text-left border border-gray-700">
                                    <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">Descrição</th>
                                            <th class="p-2">Alunos Matriculados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coursesList as $course)
                                            <tr class="border-t border-gray-700">
                                                <td class="p-2">{{ $course->title }}</td>
                                                <td class="p-2">{{ $course->description }}</td>
                                                <td class="p-2">{{ $course->total_students ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="p-4">
                                    {{ $coursesList->links() }}
                                </div>
                            @endif
                        </div>

                        {{-- TESTES --}}
                        <div x-show="tab === 'tests'" class="overflow-x-auto">
                            @if ($testsList->isEmpty())
                                <p class="p-4 text-gray-200">Nenhum teste cadastrado</p>
                            @else
                                <table class="w-full text-left border border-gray-700">
                                    <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">Descrição</th>
                                            <th class="p-2">Alunos Participantes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($testsList as $test)
                                            <tr class="border-t border-gray-700">
                                                <td class="p-2">{{ $test->title }}</td>
                                                <td class="p-2">{{ $test->description }}</td>
                                                <td class="p-2">{{ $test->total_students ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="p-4">
                                    {{ $testsList->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
