<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Vincular Alunos" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <x-alert-component type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert-component type="error" :message="session('error')" />
            @endif

            {{-- Alunos Vinculados --}}
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">
                    Alunos Vinculados ao Curso: <span class="text-blue-400">{{ $course->title }}</span>
                </h3>

                @if ($enrolledStudents->isEmpty())
                    <x-empty-state title="Nenhum aluno vinculado." message="Vincule alunos para dar acesso ao curso." />
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border border-gray-700">
                            <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                <tr>
                                    <th class="p-3">Nome</th>
                                    <th class="p-3">E-mail</th>
                                    <th class="p-3">Matrícula</th>
                                    <th class="p-3">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrolledStudents as $student)
                                    <tr class="border-t border-gray-700 hover:bg-gray-800">
                                        <td class="p-3">{{ $student->user->name }}</td>
                                        <td class="p-3">{{ $student->user->email }}</td>
                                        <td class="p-3">{{ $student->registration }}</td>
                                        <td class="p-3">
                                            <form method="POST"
                                                action="{{ route('teacher.destroyLinkCourse', ['courseUuid' => $course->uuid, 'userUuid' => $student->user->uuid]) }}"
                                                onsubmit="return confirm('Remover acesso do aluno a este curso?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                    <i class="fa-solid fa-unlink"></i> Remover
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
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-100 mb-4">Vincular Novos Alunos</h3>

                @if ($students->isEmpty())
                    <x-empty-state title="Nenhum aluno disponível." message="Todos os alunos já estão vinculados a este curso." />
                @else
                    <form method="POST" action="{{ route('teacher.storeLinkCourse', $course->uuid) }}">
                        @csrf

                        <div class="overflow-x-auto max-h-96 overflow-y-auto">
                            <table class="w-full text-left border border-gray-700">
                                <thead class="bg-gray-950 text-sm font-semibold text-gray-200 sticky top-0">
                                    <tr>
                                        <th class="p-3 w-12">
                                            <input type="checkbox" id="selectAll" class="rounded border-gray-600 bg-gray-800">
                                        </th>
                                        <th class="p-3">Nome</th>
                                        <th class="p-3">E-mail</th>
                                        <th class="p-3">Matrícula</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr class="border-t border-gray-700 hover:bg-gray-800">
                                            <td class="p-3 text-center">
                                                <input type="checkbox" name="students[]" value="{{ $student->user->uuid }}"
                                                    class="student-checkbox rounded border-gray-600 bg-gray-800">
                                            </td>
                                            <td class="p-3">{{ $student->user->name }}</td>
                                            <td class="p-3">{{ $student->user->email }}</td>
                                            <td class="p-3">{{ $student->registration }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <a href="{{ route('course.show', $course->uuid) }}"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Voltar</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                <i class="fa-solid fa-link"></i> Vincular Selecionados
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>
</x-app-layout>