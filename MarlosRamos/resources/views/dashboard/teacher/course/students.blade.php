<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Vincular Alunos" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('course.index') }}" class="hover:text-gray-300 transition">Cursos</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-700"></i>
                <a href="{{ route('course.show', $course->uuid) }}" class="hover:text-gray-300 transition">{{ $course->title }}</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-700"></i>
                <span class="text-gray-300">Vincular Alunos</span>
            </div>

            {{-- Alunos Vinculados --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                    <h3 class="text-base font-semibold text-gray-100">
                        Alunos Vinculados
                        <span class="ml-1.5 text-xs font-normal text-gray-400 bg-gray-800 px-2 py-0.5 rounded-full">{{ $enrolledStudents->count() }}</span>
                    </h3>
                </div>

                @if ($enrolledStudents->isEmpty())
                    <x-empty-state title="Nenhum aluno vinculado." message="Vincule alunos para dar acesso ao curso." />
                @else
                    <div class="overflow-x-auto rounded-xl border border-gray-800">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-800 bg-gray-950/60">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">E-mail</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Matrícula</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach ($enrolledStudents as $student)
                                    <tr class="hover:bg-gray-800/40 transition">
                                        <td class="px-4 py-3.5 text-gray-200 font-medium whitespace-nowrap">{{ $student->user->name }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $student->user->email }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $student->registration ?? '—' }}</td>
                                        <td class="px-4 py-3.5">
                                            <form method="POST"
                                                action="{{ route('teacher.destroyLinkCourse', ['courseUuid' => $course->uuid, 'userUuid' => $student->user->uuid]) }}"
                                                onsubmit="return confirm('Remover acesso do aluno a este curso?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-1.5 px-2.5 py-1 text-xs text-red-400 border border-red-500/20 rounded-lg hover:bg-red-500/10 transition">
                                                    <i class="fa-solid fa-unlink text-xs"></i> Remover
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Vincular Novos Alunos --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1 h-6 bg-green-500 rounded-full"></div>
                    <h3 class="text-base font-semibold text-gray-100">
                        Alunos Disponíveis
                        <span class="ml-1.5 text-xs font-normal text-gray-400 bg-gray-800 px-2 py-0.5 rounded-full">{{ $students->count() }}</span>
                    </h3>
                </div>

                @if ($students->isEmpty())
                    <x-empty-state title="Nenhum aluno disponível." message="Todos os alunos já estão vinculados a este curso." />
                @else
                    <form method="POST" action="{{ route('teacher.storeLinkCourse', $course->uuid) }}">
                        @csrf

                        <div class="overflow-x-auto rounded-xl border border-gray-800 max-h-96 overflow-y-auto">
                            <table class="w-full text-sm">
                                <thead class="sticky top-0 z-10">
                                    <tr class="border-b border-gray-800 bg-gray-950">
                                        <th class="px-4 py-3 w-10">
                                            <input type="checkbox" id="selectAll"
                                                class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                        </th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">E-mail</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Matrícula</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @foreach ($students as $student)
                                        <tr class="hover:bg-gray-800/40 transition cursor-pointer" onclick="this.querySelector('input[type=checkbox]').click(); event.stopPropagation();">
                                            <td class="px-4 py-3.5 text-center" onclick="event.stopPropagation()">
                                                <input type="checkbox" name="students[]" value="{{ $student->user->uuid }}"
                                                    class="student-checkbox w-4 h-4 rounded border-gray-600 bg-gray-800 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                            </td>
                                            <td class="px-4 py-3.5 text-gray-200 font-medium">{{ $student->user->name }}</td>
                                            <td class="px-4 py-3.5 text-gray-400">{{ $student->user->email }}</td>
                                            <td class="px-4 py-3.5 text-gray-400">{{ $student->registration ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex items-center justify-between mt-5 pt-5 border-t border-gray-800">
                            <a href="{{ route('course.show', $course->uuid) }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-400 hover:text-gray-200 border border-gray-700 rounded-lg hover:border-gray-500 transition">
                                <i class="fa-solid fa-arrow-left text-xs"></i>
                                Voltar
                            </a>
                            <button type="submit"
                                class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                                <i class="fa-solid fa-link"></i>
                                Vincular Selecionados
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
            });
        }
    </script>
</x-app-layout>


