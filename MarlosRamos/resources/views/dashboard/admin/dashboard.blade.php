<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do administrador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- INDICARORES  ALUNOS | PROFESSORES | CURSOS | TESTES --}}
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Indicadores de Cadastro</h2>

                    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                        <!-- Alunos -->
                        <div
                            class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:items-center space-x-3">
                                <i class="fas fa-user-graduate text-3xl text-green-500"></i>
                                <h3 class="text-lg font-medium">Alunos</h3>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <p class="text-2xl font-bold">{{ $total_students }}</p>
                            </div>
                        </div>

                        <!-- Professores -->
                        <div
                            class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:items-center space-x-3">
                                <i class="fas fa-chalkboard-teacher text-3xl text-blue-500"></i>
                                <h3 class="text-lg font-medium">Professores</h3>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <p class="text-2xl font-bold">{{ $total_teachers }}</p>
                            </div>
                        </div>

                        <!-- Cursos -->
                        <div
                            class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:items-center space-x-3">
                                <i class="fas fa-book text-3xl text-indigo-500"></i>
                                <h3 class="text-lg font-medium">Cursos</h3>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <p class="text-2xl font-bold">{{ $total_courses_created }}</p>
                            </div>
                        </div>

                        <!-- Testes -->
                        <div
                            class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:items-center space-x-3">
                                <i class="fas fa-clipboard-check text-3xl text-red-500"></i>
                                <h3 class="text-lg font-medium">Testes</h3>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <p class="text-2xl font-bold">{{ $total_tests_created }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABS ALUNOS | PROFESSORES | CURSOS | TESTES --}}
                <div class="p-6 text-gray-900">
                    <div x-data="{ tab: 'students' }">
                        <!-- Tabs -->
                        <div class="flex flex-wrap border-b border-gray-200 mb-4">
                            <button @click="tab = 'students'"
                                :class="tab === 'students' ? 'border-indigo-600 text-indigo-600' : 'text-gray-600'"
                                class="py-2 px-4 border-b-2 font-medium text-sm">
                                Alunos
                            </button>
                            <button @click="tab = 'teachers'"
                                :class="tab === 'teachers' ? 'border-indigo-600 text-indigo-600' : 'text-gray-600'"
                                class="py-2 px-4 border-b-2 font-medium text-sm">
                                Professores
                            </button>
                            <button @click="tab = 'courses'"
                                :class="tab === 'courses' ? 'border-indigo-600 text-indigo-600' : 'text-gray-600'"
                                class="py-2 px-4 border-b-2 font-medium text-sm">
                                Cursos
                            </button>
                            <button @click="tab = 'tests'"
                                :class="tab === 'tests' ? 'border-indigo-600 text-indigo-600' : 'text-gray-600'"
                                class="py-2 px-4 border-b-2 font-medium text-sm">
                                Testes
                            </button>
                        </div>

                        {{-- ALUNOS --}}
                        <div x-show="tab === 'students'" class="overflow-x-auto">
                            @if ($studentsList->isEmpty())
                                <p class="p-4 text-gray-500">Nenhum dado cadastrado</p>
                            @else
                                <table class="w-full text-left border">
                                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">E-mail</th>
                                            <th class="p-2">Cursos Matriculados</th>
                                            <th class="p-2">Testes Matriculados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentsList as $student)
                                            <tr class="border-t">
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
                                <p class="p-4 text-gray-500">Nenhum dado cadastrado</p>
                            @else
                                <table class="w-full text-left border">
                                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
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
                                            <tr class="border-t">
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
                                <p class="p-4 text-gray-500">Nenhum dado cadastrado</p>
                            @else
                                <table class="w-full text-left border">
                                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">Descrição</th>
                                            <th class="p-2">Alunos Matriculados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coursesList as $course)
                                            <tr class="border-t">
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
                                <p class="p-4 text-gray-500">Nenhum dado cadastrado</p>
                            @else
                                <table class="w-full text-left border">
                                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                                        <tr>
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">Descrição</th>
                                            <th class="p-2">Alunos Participantes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($testsList as $test)
                                            <tr class="border-t">
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
