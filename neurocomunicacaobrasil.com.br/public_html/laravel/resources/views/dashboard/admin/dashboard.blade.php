<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Painel do Administrador" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Indicadores --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-green-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-user-graduate text-green-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Alunos</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $total_students }}</p>
                    </div>
                </div>
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-chalkboard-teacher text-blue-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Professores</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $total_teachers }}</p>
                    </div>
                </div>
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-indigo-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-book text-indigo-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Cursos</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $total_courses_created }}</p>
                    </div>
                </div>
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-red-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-clipboard-check text-red-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Testes</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $total_tests_created }}</p>
                    </div>
                </div>
            </div>

            {{-- Tabelas com Tabs --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">
                <div x-data="{ tab: 'students' }">

                    {{-- Tabs modernas --}}
                    <div class="flex gap-1 p-1 bg-gray-800 rounded-xl mb-6 w-full sm:w-fit overflow-x-auto">
                        <button @click="tab = 'students'"
                            :class="tab === 'students' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition whitespace-nowrap">
                            <i class="fa-solid fa-user-graduate text-xs mr-1.5"></i>Alunos
                        </button>
                        <button @click="tab = 'teachers'"
                            :class="tab === 'teachers' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition whitespace-nowrap">
                            <i class="fa-solid fa-chalkboard-teacher text-xs mr-1.5"></i>Professores
                        </button>
                        <button @click="tab = 'courses'"
                            :class="tab === 'courses' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition whitespace-nowrap">
                            <i class="fa-solid fa-book text-xs mr-1.5"></i>Cursos
                        </button>
                        <button @click="tab = 'tests'"
                            :class="tab === 'tests' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition whitespace-nowrap">
                            <i class="fa-solid fa-clipboard-check text-xs mr-1.5"></i>Testes
                        </button>
                    </div>

                    {{-- ALUNOS --}}
                    <div x-show="tab === 'students'">
                        @if ($studentsList->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Nenhum aluno cadastrado</p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-gray-800">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-800 bg-gray-950/60">
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">E-mail</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cursos</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach ($studentsList as $student)
                                            <tr class="hover:bg-gray-800/40 transition">
                                                <td class="px-4 py-3.5 text-gray-200 font-medium">{{ $student->user->name }}</td>
                                                <td class="px-4 py-3.5 text-gray-400">{{ $student->user->email }}</td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">{{ $student->total_courses ?? 0 }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-4">{{ $studentsList->links() }}</div>
                        @endif
                    </div>

                    {{-- PROFESSORES --}}
                    <div x-show="tab === 'teachers'">
                        @if ($teachersList->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Nenhum professor cadastrado</p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-gray-800">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-800 bg-gray-950/60">
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">E-mail</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Especialidade</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cursos</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Testes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach ($teachersList as $teacher)
                                            <tr class="hover:bg-gray-800/40 transition">
                                                <td class="px-4 py-3.5 text-gray-200 font-medium">{{ $teacher->user->name }}</td>
                                                <td class="px-4 py-3.5 text-gray-400">{{ $teacher->user->email }}</td>
                                                <td class="px-4 py-3.5 text-gray-400">{{ $teacher->specialty ?? '—' }}</td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">{{ $teacher->total_courses ?? 0 }}</span>
                                                </td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-500/10 text-indigo-400">{{ $teacher->total_tests ?? 0 }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-4">{{ $teachersList->links() }}</div>
                        @endif
                    </div>

                    {{-- CURSOS --}}
                    <div x-show="tab === 'courses'">
                        @if ($coursesList->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Nenhum curso cadastrado</p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-gray-800">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-800 bg-gray-950/60">
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Descrição</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Alunos</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach ($coursesList as $course)
                                            <tr class="hover:bg-gray-800/40 transition">
                                                <td class="px-4 py-3.5 text-gray-200 font-medium">{{ $course->title }}</td>
                                                <td class="px-4 py-3.5 text-gray-400 max-w-xs truncate">{{ $course->description }}</td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400">{{ $course->total_students ?? 0 }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-4">{{ $coursesList->links() }}</div>
                        @endif
                    </div>

                    {{-- TESTES --}}
                    <div x-show="tab === 'tests'">
                        <div x-data="{ subTab: 'alunos' }">
                            <div class="flex gap-1 p-1 bg-gray-800 rounded-lg mb-4 w-full sm:w-fit">
                                <button @click="subTab = 'alunos'"
                                    :class="subTab === 'alunos' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                                    class="px-3 py-1 rounded-md text-xs font-medium transition whitespace-nowrap">
                                    <i class="fa-solid fa-users text-xs mr-1"></i>Alunos
                                    <span class="opacity-70">({{ $testsList->total() }})</span>
                                </button>
                                <button @click="subTab = 'eventos'"
                                    :class="subTab === 'eventos' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                                    class="px-3 py-1 rounded-md text-xs font-medium transition whitespace-nowrap">
                                    <i class="fa-solid fa-calendar-days text-xs mr-1"></i>Eventos
                                    <span class="opacity-70">({{ $testeRepList->total() }})</span>
                                </button>
                            </div>

                            {{-- Testes com login --}}
                            <div x-show="subTab === 'alunos'">
                                @if ($testsList->isEmpty())
                                    <p class="py-8 text-center text-sm text-gray-500">Nenhum teste com login cadastrado</p>
                                @else
                                    <div class="overflow-x-auto rounded-xl border border-gray-800">
                                        <table class="w-full text-sm">
                                            <thead>
                                                <tr class="border-b border-gray-800 bg-gray-950/60">
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Aluno</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Percentual</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Primário</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Secundário</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Data</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-800">
                                                @foreach ($testsList as $test)
                                                    @php
                                                        $percent = $test->percentual ?? [];
                                                        if (!is_array($percent)) {
                                                            $percent = json_decode($percent, true) ?? [];
                                                        }
                                                    @endphp
                                                    <tr class="hover:bg-gray-800/40 transition">
                                                        <td class="px-4 py-3.5 text-gray-200 font-medium">{{ mb_strtoupper($test->user->name ?? 'SEM NOME', 'UTF-8') }}</td>
                                                        <td class="px-4 py-3.5">
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach ($percent as $letra => $valor)
                                                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300 ring-1 ring-gray-700">
                                                                        <span class="font-bold text-gray-100">{{ $letra }}</span>{{ $valor }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3.5">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-400">{{ $test->primary ?? 0 }}</span>
                                                        </td>
                                                        <td class="px-4 py-3.5">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-500/10 text-orange-400">{{ $test->secondary ?? 0 }}</span>
                                                        </td>
                                                        <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap text-xs">{{ $test->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pt-4">{{ $testsList->links() }}</div>
                                @endif
                            </div>

                            {{-- Testes representacionais (sem login) --}}
                            <div x-show="subTab === 'eventos'">
                                @if ($testeRepList->isEmpty())
                                    <p class="py-8 text-center text-sm text-gray-500">Nenhum teste representacional cadastrado</p>
                                @else
                                    <div class="overflow-x-auto rounded-xl border border-gray-800">
                                        <table class="w-full text-sm">
                                            <thead>
                                                <tr class="border-b border-gray-800 bg-gray-950/60">
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Telefone</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Percentual</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Primário</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Secundário</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Data</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-800">
                                                @foreach ($testeRepList as $rep)
                                                    @php
                                                        $percent = $rep->percentual ?? [];
                                                        if (!is_array($percent)) {
                                                            $percent = json_decode($percent, true) ?? [];
                                                        }
                                                    @endphp
                                                    <tr class="hover:bg-gray-800/40 transition">
                                                        <td class="px-4 py-3.5 text-gray-200 font-medium">{{ mb_strtoupper($rep->name, 'UTF-8') }}</td>
                                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $rep->phone ?? '—' }}</td>
                                                        <td class="px-4 py-3.5">
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach ($percent as $letra => $valor)
                                                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300 ring-1 ring-gray-700">
                                                                        <span class="font-bold text-gray-100">{{ $letra }}</span>{{ $valor }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td class="px-4 py-3.5">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-400">{{ $rep->primary ?? 0 }}</span>
                                                        </td>
                                                        <td class="px-4 py-3.5">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-500/10 text-orange-400">{{ $rep->secondary ?? 0 }}</span>
                                                        </td>
                                                        <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap text-xs">{{ $rep->created_at->format('d/m/Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pt-4">{{ $testeRepList->links() }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

